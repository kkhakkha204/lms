<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\StudentProgress;
use App\Models\Enrollment;
use App\Models\LessonMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LearningController extends Controller
{
    /**
     * Giao diện học tập chính
     */
    public function index($courseSlug, $contentType = null, $contentSlug = null)
    {
        $course = Course::with([
            'sections' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'sections.lessons' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'sections.quizzes' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }
        ])->where('slug', $courseSlug)->firstOrFail();

        // Kiểm tra quyền truy cập
        $this->checkAccess($course);

        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->firstOrFail();

        // Lấy nội dung hiện tại
        $currentContent = $this->getCurrentContent($course, $contentType, $contentSlug);

        // Lấy tiến độ học tập
        $progress = $this->getStudentProgress($course->id);

        // Tính phần trăm hoàn thành
        $completionPercentage = $this->calculateProgress($course, $progress);

        return view('student.learn.index', compact(
            'course',
            'currentContent',
            'enrollment',
            'progress',
            'completionPercentage'
        ));
    }

    /**
     * Xem bài học
     */
    public function lesson($courseSlug, $lessonSlug)
    {
        return $this->index($courseSlug, 'lesson', $lessonSlug);
    }

    /**
     * Làm quiz
     */
    public function quiz($courseSlug, $quizSlug)
    {
        return $this->index($courseSlug, 'quiz', $quizSlug);
    }

    /**
     * Cập nhật tiến độ video
     */
    public function updateVideoProgress(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'watched_seconds' => 'required|integer|min:0',
            'completed' => 'boolean'
        ]);

        $lesson = Lesson::findOrFail($validated['lesson_id']);

        // Kiểm tra quyền truy cập
        $this->checkAccess($lesson->course);

        // Cập nhật hoặc tạo progress
        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $lesson->course_id,
                'lesson_id' => $lesson->id,
                'type' => 'lesson'
            ],
            [
                'video_watched_seconds' => $validated['watched_seconds'],
                'lesson_completed' => $validated['completed'] ?? false,
                'status' => $validated['completed'] ? 'completed' : 'in_progress',
                'started_at' => now(),
                'completed_at' => $validated['completed'] ? now() : null,
            ]
        );

        // Cập nhật tiến độ enrollment nếu hoàn thành
        $updatedPercentage = 0;
        if ($validated['completed']) {
            $updatedPercentage = $this->updateEnrollmentProgress($lesson->course_id);
        }

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'completion_percentage' => $updatedPercentage ?: $this->calculateProgress($lesson->course)
        ]);
    }

    /**
     * Nộp bài quiz
     */
    public function submitQuiz(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array'
        ]);

        $quiz = Quiz::with('questions.options')->findOrFail($validated['quiz_id']);

        // Kiểm tra quyền truy cập
        $this->checkAccess($quiz->course);

        // Kiểm tra số lần làm bài
        $existingProgress = StudentProgress::where([
            'student_id' => Auth::id(),
            'quiz_id' => $quiz->id,
        ])->first();

        if ($existingProgress && $existingProgress->quiz_attempts >= $quiz->max_attempts) {
            return response()->json([
                'error' => 'Bạn đã hết số lần làm bài cho quiz này.'
            ], 400);
        }

        // Tính điểm
        $result = $this->calculateQuizScore($quiz, $validated['answers']);

        // Cập nhật progress
        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $quiz->course_id,
                'quiz_id' => $quiz->id,
                'type' => 'quiz'
            ],
            [
                'quiz_score' => $result['score'],
                'quiz_attempts' => ($existingProgress->quiz_attempts ?? 0) + 1,
                'quiz_passed' => $result['passed'],
                'quiz_answers' => $validated['answers'],
                'status' => $result['passed'] ? 'completed' : 'in_progress',
                'started_at' => $existingProgress->started_at ?? now(),
                'completed_at' => $result['passed'] ? now() : null,
            ]
        );

        // Cập nhật tiến độ enrollment
        $updatedPercentage = $this->updateEnrollmentProgress($quiz->course_id);

        return response()->json([
            'success' => true,
            'result' => $result,
            'progress' => $progress,
            'completion_percentage' => $updatedPercentage
        ]);
    }

    /**
     * Tải xuống tài liệu
     */
    public function downloadMaterial($materialId)
    {
        $material = LessonMaterial::where('id', $materialId)
            ->where('is_active', true)
            ->with('lesson.course')
            ->firstOrFail();

        // Kiểm tra quyền truy cập
        $this->checkAccess($material->lesson->course);

        // Tăng số lượt download
        $material->increment('download_count');

        // Kiểm tra file tồn tại
        if (!Storage::disk('public')->exists($material->file_path)) {
            // Tạo file PDF mẫu nếu không tồn tại
            $this->createSamplePDF($material);
        }

        // Trả về file
        if (Storage::disk('public')->exists($material->file_path)) {
            return Storage::disk('public')->download($material->file_path, $material->file_name);
        }

        abort(404, 'File không tồn tại.');
    }

    /**
     * Tạo file PDF mẫu cho testing
     */
    private function createSamplePDF($material)
    {
        $content = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>{$material->title}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                h1 { color: #333; }
                .content { line-height: 1.6; }
            </style>
        </head>
        <body>
            <h1>{$material->title}</h1>
            <div class='content'>
                <p>Đây là tài liệu mẫu cho bài học: {$material->lesson->title}</p>
                <p>Nội dung này được tạo tự động để demo chức năng download.</p>
                <p>Trong thực tế, bạn sẽ upload file PDF thật từ admin panel.</p>
                <br>
                <p><strong>Thông tin file:</strong></p>
                <ul>
                    <li>Tên file: {$material->file_name}</li>
                    <li>Loại file: {$material->file_type}</li>
                    <li>Kích thước: " . round($material->file_size / 1024) . " KB</li>
                </ul>
            </div>
        </body>
        </html>";

        // Tạo thư mục nếu chưa có
        $directory = dirname($material->file_path);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Lưu file HTML tạm (trong production nên dùng PDF library)
        Storage::disk('public')->put($material->file_path, $content);
    }

    /**
     * Lấy danh sách tiến độ học tập
     */
    public function getProgress($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $this->checkAccess($course);

        $progress = $this->getStudentProgress($course->id);
        $completionPercentage = $this->calculateProgress($course, $progress);

        return response()->json([
            'progress' => $progress,
            'completion_percentage' => $completionPercentage
        ]);
    }

    /**
     * Kiểm tra quyền truy cập khóa học
     */
    private function checkAccess($course)
    {
        if (!Auth::check()) {
            abort(401, 'Vui lòng đăng nhập.');
        }

        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            abort(403, 'Bạn chưa đăng ký khóa học này.');
        }
    }

    /**
     * Lấy nội dung hiện tại (lesson hoặc quiz)
     */
    private function getCurrentContent($course, $contentType, $contentSlug)
    {
        if (!$contentType || !$contentSlug) {
            // Lấy nội dung đầu tiên
            return $this->getFirstContent($course);
        }

        if ($contentType === 'lesson') {
            return Lesson::where('slug', $contentSlug)
                ->where('course_id', $course->id)
                ->where('is_active', true)
                ->with(['materials' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }])
                ->firstOrFail();
        }

        if ($contentType === 'quiz') {
            // Tìm quiz bằng slug được tạo từ title
            $quizTitle = str_replace('-', ' ', $contentSlug);

            return Quiz::where('course_id', $course->id)
                ->where('is_active', true)
                ->where(function($query) use ($quizTitle, $contentSlug) {
                    $query->whereRaw('LOWER(REPLACE(title, " ", "-")) = ?', [strtolower($contentSlug)])
                        ->orWhereRaw('LOWER(title) = ?', [strtolower($quizTitle)]);
                })
                ->with(['questions' => function ($query) {
                    $query->orderBy('sort_order')->with('options');
                }])
                ->firstOrFail();
        }

        abort(404);
    }

    /**
     * Lấy nội dung đầu tiên của khóa học
     */
    private function getFirstContent($course)
    {
        $firstSection = $course->sections->first();
        if (!$firstSection) return null;

        // Ưu tiên lesson trước
        $firstLesson = $firstSection->lessons->first();
        if ($firstLesson) {
            return $firstLesson->load(['materials' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }]);
        }

        // Nếu không có lesson thì lấy quiz
        $firstQuiz = $firstSection->quizzes->first();
        if ($firstQuiz) {
            return $firstQuiz->load(['questions' => function ($query) {
                $query->orderBy('sort_order')->with('options');
            }]);
        }

        return null;
    }

    /**
     * Lấy tiến độ học tập của học viên
     */
    private function getStudentProgress($courseId)
    {
        return StudentProgress::where('student_id', Auth::id())
            ->where('course_id', $courseId)
            ->get()
            ->keyBy(function ($item) {
                return $item->type . '_' . ($item->lesson_id ?: $item->quiz_id);
            });
    }

    /**
     * Tính điểm quiz
     */
    private function calculateQuizScore($quiz, $answers)
    {
        $totalPoints = 0;
        $earnedPoints = 0;
        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $userAnswer = $answers[$question->id] ?? null;

            if ($this->isAnswerCorrect($question, $userAnswer)) {
                $earnedPoints += $question->points;
                $correctAnswers++;
            }
        }

        $scorePercentage = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;
        $passed = $scorePercentage >= $quiz->passing_score;

        return [
            'score' => $scorePercentage,
            'earned_points' => $earnedPoints,
            'total_points' => $totalPoints,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'passed' => $passed,
            'passing_score' => $quiz->passing_score
        ];
    }

    /**
     * Kiểm tra câu trả lời có đúng không
     */
    private function isAnswerCorrect($question, $userAnswer)
    {
        switch ($question->type) {
            case 'single_choice':
            case 'true_false':
                $correctOption = $question->options->where('is_correct', true)->first();
                return $correctOption && $userAnswer == $correctOption->id;

            case 'multiple_choice':
                $correctOptionIds = $question->options->where('is_correct', true)->pluck('id')->toArray();
                $userAnswerArray = is_array($userAnswer) ? $userAnswer : [];
                sort($correctOptionIds);
                sort($userAnswerArray);
                return $correctOptionIds === array_map('intval', $userAnswerArray);

            case 'fill_blank':
                $correctAnswer = $question->options->where('is_correct', true)->first();
                return $correctAnswer && trim(strtolower($userAnswer)) === trim(strtolower($correctAnswer->option_text));

            default:
                return false;
        }
    }

    /**
     * Tính phần trăm hoàn thành khóa học
     */
    private function calculateProgress($course, $progress = null)
    {
        if (!$progress) {
            $progress = $this->getStudentProgress($course->id);
        }

        $totalItems = 0;
        $completedItems = 0;

        foreach ($course->sections as $section) {
            foreach ($section->lessons as $lesson) {
                $totalItems++;
                $progressKey = 'lesson_' . $lesson->id;
                if (isset($progress[$progressKey]) && $progress[$progressKey]->lesson_completed) {
                    $completedItems++;
                }
            }

            foreach ($section->quizzes as $quiz) {
                $totalItems++;
                $progressKey = 'quiz_' . $quiz->id;
                if (isset($progress[$progressKey]) && $progress[$progressKey]->quiz_passed) {
                    $completedItems++;
                }
            }
        }

        return $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
    }

    /**
     * Cập nhật tiến độ enrollment
     */
    private function updateEnrollmentProgress($courseId)
    {
        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            $course = Course::with('sections.lessons', 'sections.quizzes')->find($courseId);
            $completionPercentage = $this->calculateProgress($course);

            // Đếm lessons và quizzes hoàn thành
            $progress = $this->getStudentProgress($courseId);
            $lessonsCompleted = $progress->where('type', 'lesson')->where('lesson_completed', true)->count();
            $quizzesCompleted = $progress->where('type', 'quiz')->where('quiz_passed', true)->count();

            $enrollment->update([
                'progress_percentage' => $completionPercentage,
                'lessons_completed' => $lessonsCompleted,
                'quizzes_completed' => $quizzesCompleted,
                'completed_at' => $completionPercentage >= 100 ? now() : null,
            ]);

            return $completionPercentage;
        }

        return 0;
    }
}
