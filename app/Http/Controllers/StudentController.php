<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Quiz;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StudentController extends Controller
{
    /**
     * Display the list of courses.
     */
    public function index()
    {
        $courses = Course::where('status', 'published')->with('category')->get();
        return view('student.courses.index', compact('courses'));

    }

    /**
     * Display the course details.
     */
    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $course->load(['category', 'sections.lessons', 'sections.quizzes']);
        $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();

        return view('student.courses.show', compact('course', 'enrollment'));
    }

    /**
     * Handle course enrollment.
     */
    public function enroll(Request $request, Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $user = Auth::user();
        $existingEnrollment = $user->enrollments()->where('course_id', $course->id)->first();

        if ($existingEnrollment) {
            return redirect()->route('student.courses.learn', $course)->with('success', 'Bạn đã đăng ký khóa học này.');
        }

        if ($course->is_free) {
            $enrollment = Enrollment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'paid_amount' => 0,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);

            $course->increment('enrolled_count');

            return redirect()->route('student.courses.learn', $course)->with('success', 'Đăng ký khóa học miễn phí thành công!');
        }

        return redirect()->route('student.courses.payment.form', $course);
    }

    /**
     * Display the payment form.
     */
    public function showPaymentForm(Course $course)
    {
        if ($course->is_free || $course->status !== 'published') {
            return redirect()->route('student.courses.show', $course)->with('error', 'Khóa học không khả dụng để thanh toán.');
        }

        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($enrollment) {
            return redirect()->route('student.courses.show', $course)->with('info', 'Bạn đã đăng ký khóa học này.');
        }

        return view('student.courses.payment', compact('course'));
    }

    /**
     * Process the payment (simulated).
     */
    public function processPayment(Request $request, Course $course)
    {
        if ($course->is_free || $course->status !== 'published') {
            return response()->json(['message' => 'Khóa học không khả dụng.'], 400);
        }

        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($enrollment) {
            return response()->json(['message' => 'Bạn đã đăng ký khóa học này.'], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $amount = $course->discount_price ?? $course->price;
        $amountInCents = (int) ($amount * 100); // Ensure integer for Stripe (VND has no subunits, but Stripe expects smallest unit)

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => $course->title,
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('student.courses.payment.success', $course, true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('student.courses.payment.form', $course, true),
                'metadata' => [
                    'course_id' => $course->id,
                    'student_id' => Auth::id(),
                ],
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            Log::error('Stripe payment error: ' . $e->getMessage(), [
                'course_id' => $course->id,
                'student_id' => Auth::id(),
                'amount' => $amount,
            ]);
            return response()->json(['message' => 'Lỗi thanh toán: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Display payment success page.
     */
    public function paymentSuccess(Request $request, Course $course)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->query('session_id');

        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                $amount = $session->amount_total / 100; // Convert back to VND

                Payment::create([
                    'student_id' => Auth::id(),
                    'course_id' => $course->id,
                    'transaction_id' => $session->payment_intent,
                    'payment_method' => 'stripe',
                    'amount' => $amount,
                    'discount_amount' => $course->discount_price ? $course->price - $course->discount_price : 0,
                    'final_amount' => $amount,
                    'currency' => 'VND',
                    'status' => 'completed',
                    'payment_details' => ['stripe_session_id' => $sessionId],
                    'paid_at' => now(),
                ]);

                Enrollment::create([
                    'student_id' => Auth::id(),
                    'course_id' => $course->id,
                    'paid_amount' => $amount,
                    'status' => 'active',
                    'enrolled_at' => now(),
                ]);

                $course->increment('enrolled_count');

                return redirect()->route('student.courses.learn', $course)->with('success', 'Thanh toán và đăng ký khóa học thành công.');
            } else {
                return redirect()->route('student.courses.payment.form', $course)->with('error', 'Thanh toán không thành công.');
            }
        } catch (\Exception $e) {
            Log::error('Stripe payment success error: ' . $e->getMessage(), [
                'session_id' => $sessionId,
                'course_id' => $course->id,
                'student_id' => Auth::id(),
            ]);
            return redirect()->route('student.courses.payment.form', $course)->with('error', 'Lỗi xác nhận thanh toán: ' . $e->getMessage());
        }
    }

    /**
     * Display the learning interface for the course.
     */
    public function learn(Course $course)
    {
        $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();

        if (!$enrollment || $enrollment->status !== 'active') {
            abort(403, 'Bạn chưa đăng ký khóa học này.');
        }

        $course->load(['sections.lessons.materials', 'sections.quizzes.questions.options']);
        $progress = StudentProgress::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->get()
            ->keyBy(function ($item) {
                return $item->type . '_' . ($item->lesson_id ?? $item->quiz_id);
            });

        return view('student.courses.learn', compact('course', 'enrollment', 'progress'));
    }

    /**
     * Update lesson progress.
     */
    public function updateLessonProgress(Request $request, Course $course, Lesson $lesson)
    {
        $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();

        if (!$enrollment || $enrollment->status !== 'active') {
            return response()->json(['error' => 'Bạn không có quyền truy cập khóa học này'], 403);
        }

        $request->validate([
            'video_watched_seconds' => 'required|integer|min:0',
            'lesson_completed' => 'required|boolean',
        ]);

        $existingProgress = StudentProgress::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->where('type', 'lesson')
            ->first();

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'type' => 'lesson',
            ],
            [
                'video_watched_seconds' => $request->video_watched_seconds,
                'lesson_completed' => $request->lesson_completed,
                'status' => $request->lesson_completed ? 'completed' : 'in_progress',
                'started_at' => $existingProgress->started_at ?? now(),
                'completed_at' => $request->lesson_completed ? now() : null,
            ]
        );

        // Update enrollment progress
        $this->updateEnrollmentProgress($enrollment, $course);

        return response()->json([
            'success' => true,
            'message' => $request->lesson_completed ? 'Hoàn thành bài học thành công!' : 'Cập nhật tiến độ bài học thành công!'
        ]);
    }

    /**
     * Submit quiz answers and update progress.
     */
    public function submitQuiz(Request $request, Course $course, Quiz $quiz)
    {
        $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();

        if (!$enrollment || $enrollment->status !== 'active') {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập khóa học này');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ], [
            'answers.required' => 'Vui lòng trả lời tất cả các câu hỏi',
            'answers.*.required' => 'Vui lòng trả lời tất cả các câu hỏi',
        ]);

        $progress = StudentProgress::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('quiz_id', $quiz->id)
            ->where('type', 'quiz')
            ->first();

        // Check max attempts
        if ($progress && $progress->quiz_attempts >= $quiz->max_attempts) {
            return redirect()->back()->with('error', 'Bạn đã hết lượt làm bài kiểm tra này.');
        }

        // Validate all questions are answered
        $quiz->load('questions');
        if (count($request->answers) < $quiz->questions->count()) {
            return redirect()->back()->with('error', 'Vui lòng trả lời tất cả các câu hỏi trước khi nộp bài.');
        }

        // Calculate score
        $scoreData = $this->calculateQuizScore($quiz, $request->answers);
        $score = $scoreData['score'];
        $passed = $score >= $quiz->passing_score;
        $currentAttempts = $progress ? $progress->quiz_attempts + 1 : 1;

        // Update or create progress
        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $course->id,
                'quiz_id' => $quiz->id,
                'type' => 'quiz',
            ],
            [
                'quiz_score' => $score,
                'quiz_attempts' => $currentAttempts,
                'quiz_passed' => $passed,
                'quiz_answers' => $request->answers,
                'status' => $passed ? 'completed' : 'in_progress',
                'started_at' => $progress ? $progress->started_at : now(),
                'completed_at' => $passed ? now() : null,
            ]
        );

        // Update enrollment progress
        $this->updateEnrollmentProgress($enrollment, $course);

        $attemptsLeft = $quiz->max_attempts - $currentAttempts;

        if ($passed) {
            $message = "Chúc mừng! Bạn đã vượt qua bài kiểm tra với điểm số {$score}%";
            $messageType = 'success';
        } else {
            $message = "Bạn chưa đạt điểm qua ({$quiz->passing_score}%). Điểm của bạn: {$score}%";
            if ($attemptsLeft > 0) {
                $message .= " Bạn còn {$attemptsLeft} lượt làm bài.";
            } else {
                $message .= " Bạn đã hết lượt làm bài.";
            }
            $messageType = 'error';
        }

        // Store quiz results in session for display
        session()->flash('quiz_results', [
            'passed' => $passed,
            'score' => $score,
            'passing_score' => $quiz->passing_score,
            'attempts_used' => $currentAttempts,
            'attempts_left' => $attemptsLeft,
            'show_results' => $quiz->show_results,
            'results' => $quiz->show_results ? $scoreData['results'] : null
        ]);

        return redirect()->route('student.courses.learn', [$course, 'quiz' => $quiz->id])
            ->with($messageType, $message);
    }

    /**
     * Update enrollment progress based on completed lessons and quizzes.
     */
    protected function updateEnrollmentProgress(Enrollment $enrollment, Course $course)
    {
        $totalLessons = $course->lessons()->count();
        $totalQuizzes = $course->quizzes()->count();
        $totalItems = $totalLessons + $totalQuizzes;

        $completedLessons = StudentProgress::where('student_id', $enrollment->student_id)
            ->where('course_id', $course->id)
            ->where('type', 'lesson')
            ->where('lesson_completed', true)
            ->count();

        $completedQuizzes = StudentProgress::where('student_id', $enrollment->student_id)
            ->where('course_id', $course->id)
            ->where('type', 'quiz')
            ->where('quiz_passed', true)
            ->count();

        $progressPercentage = $totalItems > 0 ? (($completedLessons + $completedQuizzes) / $totalItems) * 100 : 0;

        $averageQuizScore = StudentProgress::where('student_id', $enrollment->student_id)
            ->where('course_id', $course->id)
            ->where('type', 'quiz')
            ->avg('quiz_score') ?? 0;

        $enrollment->update([
            'progress_percentage' => round($progressPercentage, 2),
            'lessons_completed' => $completedLessons,
            'quizzes_completed' => $completedQuizzes,
            'average_quiz_score' => round($averageQuizScore, 2),
            'completed_at' => $progressPercentage >= 100 ? now() : null,
        ]);
    }

    /**
     * Calculate quiz score based on submitted answers.
     */
    protected function calculateQuizScore(Quiz $quiz, array $answers)
    {
        $quiz->load('questions.options');
        $totalPoints = $quiz->questions->sum('points');
        $earnedPoints = 0;
        $results = [];

        foreach ($quiz->questions as $index => $question) {
            $result = [
                'question' => $question->question,
                'user_answer' => null,
                'correct_answer' => null,
                'is_correct' => false,
                'points_earned' => 0,
                'points_possible' => $question->points,
                'explanation' => $question->explanation
            ];

            if (!isset($answers[$index])) {
                $results[] = $result;
                continue;
            }

            $submittedAnswer = $answers[$index];
            $result['user_answer'] = $submittedAnswer;

            if ($question->type === 'single_choice') {
                $correctOption = $question->options->where('is_correct', true)->first();
                $userOption = $question->options->find($submittedAnswer);

                if ($correctOption) {
                    $result['correct_answer'] = $correctOption->option_text;
                    if ($submittedAnswer == $correctOption->id) {
                        $earnedPoints += $question->points;
                        $result['is_correct'] = true;
                        $result['points_earned'] = $question->points;
                    }
                }

                if ($userOption) {
                    $result['user_answer'] = $userOption->option_text;
                }
            }

            $results[] = $result;
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;

        return [
            'score' => $score,
            'earned_points' => $earnedPoints,
            'total_points' => $totalPoints,
            'results' => $results
        ];
    }
}
