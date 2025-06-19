<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Quiz;
use Illuminate\Http\Request;

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
            'time_limit' => 'nullable|integer',
            'max_attempts' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'show_results' => 'boolean',
            'shuffle_questions' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $section->quizzes()->create(array_merge($validated, ['course_id' => $course->id]));

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài kiểm tra đã được tạo.');
    }

    public function edit(Course $course, CourseSection $section, Quiz $quiz)
    {
        return view('admin.courses.quizzes.edit', compact('course', 'section', 'quiz'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'time_limit' => 'nullable|integer',
            'max_attempts' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'show_results' => 'boolean',
            'shuffle_questions' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài kiểm tra đã được cập nhật.');
    }

    public function destroy(Course $course, CourseSection $section, Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài kiểm tra đã được xóa.');
    }
}
