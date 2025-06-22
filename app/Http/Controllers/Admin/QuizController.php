<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function create(Course $course, CourseSection $section)
    {
        return view('admin.courses.quizzes.create', compact('course', 'section'));
    }

    public function store(Request $request, Course $course, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'max_attempts' => 'required|integer|min:1|max:10',
            'passing_score' => 'required|numeric|min:0|max:100',
            'show_results' => 'boolean',
            'shuffle_questions' => 'boolean',
        ]);

        // Tự động tính sort_order dựa trên số lượng lessons và quizzes hiện có trong section
        $lastSortOrder = $section->lessons()->max('sort_order') ?? 0;
        $lastQuizSortOrder = $section->quizzes()->max('sort_order') ?? 0;
        $nextSortOrder = max($lastSortOrder, $lastQuizSortOrder) + 1;

        // Xử lý checkbox values
        $validated['show_results'] = $request->has('show_results');
        $validated['shuffle_questions'] = $request->has('shuffle_questions');
        $validated['sort_order'] = $nextSortOrder;
        $validated['is_active'] = true;

        // Tạo quiz và lưu vào biến để có thể redirect đến trang edit
        $quiz = $section->quizzes()->create(array_merge($validated, ['course_id' => $course->id]));

        return redirect()->route('admin.courses.sections.quizzes.edit', [$course, $section, $quiz])
            ->with('success', 'Bài kiểm tra đã được tạo thành công.');
    }

    public function edit(Course $course, CourseSection $section, Quiz $quiz)
    {
        // Load questions với sort_order để hiển thị đúng thứ tự
        $quiz->load(['questions' => function($query) {
            $query->orderBy('sort_order');
        }]);

        return view('admin.courses.quizzes.edit', compact('course', 'section', 'quiz'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'max_attempts' => 'required|integer|min:1|max:10',
            'passing_score' => 'required|numeric|min:0|max:100',
            'show_results' => 'boolean',
            'shuffle_questions' => 'boolean',
        ]);

        // Xử lý checkbox values
        $validated['show_results'] = $request->has('show_results');
        $validated['shuffle_questions'] = $request->has('shuffle_questions');

        $quiz->update($validated);

        return redirect()->route('admin.courses.sections.quizzes.edit', [$course, $section, $quiz])
            ->with('success', 'Bài kiểm tra đã được cập nhật thành công.');
    }

    public function destroy(Course $course, CourseSection $section, Quiz $quiz)
    {
        // Kiểm tra xem quiz có questions không
        if ($quiz->questions()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa bài kiểm tra này vì vẫn còn câu hỏi. Vui lòng xóa tất cả câu hỏi trước.');
        }

        $quiz->delete();

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Bài kiểm tra đã được xóa thành công.');
    }

    /**
     * Sắp xếp lại thứ tự câu hỏi bằng kéo thả
     */
    public function sortQuestions(Request $request, Course $course, CourseSection $section, Quiz $quiz): JsonResponse
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'required|integer|exists:quiz_questions,id'
        ]);

        $questionIds = $request->input('questions');

        // Kiểm tra tất cả questions thuộc về quiz này
        $questionsCount = QuizQuestion::where('quiz_id', $quiz->id)
            ->whereIn('id', $questionIds)
            ->count();

        if ($questionsCount !== count($questionIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Một số câu hỏi không thuộc về bài kiểm tra này.'
            ], 400);
        }

        // Cập nhật sort_order cho từng câu hỏi
        foreach ($questionIds as $index => $questionId) {
            QuizQuestion::where('id', $questionId)
                ->where('quiz_id', $quiz->id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thứ tự câu hỏi đã được cập nhật thành công.'
        ]);
    }
}
