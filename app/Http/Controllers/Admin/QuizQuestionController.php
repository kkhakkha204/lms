<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    public function create(Course $course, CourseSection $section, Quiz $quiz)
    {
        return view('admin.courses.quizzes.questions.create', compact('course', 'section', 'quiz'));
    }

    public function store(Request $request, Course $course, CourseSection $section, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:single_choice,multiple_choice,fill_blank,true_false',
            'explanation' => 'nullable|string',
            'points' => 'required|numeric|min:0',
            'is_required' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'options.*.option_text' => 'required_if:type,single_choice,multiple_choice,true_false|string',
            'options.*.is_correct' => 'required_if:type,single_choice,multiple_choice,true_false|in:0,1',
            'options' => [
                'required_if:type,single_choice,multiple_choice,true_false',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array($request->type, ['single_choice', 'multiple_choice', 'true_false'])) {
                        $hasCorrect = collect($value)->contains('is_correct', '1');
                        if (!$hasCorrect) {
                            $fail('Phải có ít nhất một tùy chọn đúng.');
                        }
                        if ($request->type === 'single_choice' && collect($value)->where('is_correct', '1')->count() > 1) {
                            $fail('Loại trắc nghiệm một đáp án chỉ được có một tùy chọn đúng.');
                        }
                    }
                },
            ],
        ]);

        $question = $quiz->questions()->create($validated);

        if (in_array($validated['type'], ['single_choice', 'multiple_choice', 'true_false']) && !empty($request->options)) {
            foreach ($request->options as $option) {
                $question->options()->create([
                    'option_text' => $option['option_text'],
                    'is_correct' => (bool) $option['is_correct'],
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Câu hỏi đã được tạo.');
    }

    public function edit(Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        return view('admin.courses.quizzes.questions.edit', compact('course', 'section', 'quiz', 'question'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:single_choice,multiple_choice,fill_blank,true_false',
            'explanation' => 'nullable|string',
            'points' => 'required|numeric|min:0',
            'is_required' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'options.*.option_text' => 'required_if:type,single_choice,multiple_choice,true_false|string',
            'options.*.is_correct' => 'required_if:type,single_choice,multiple_choice,true_false|in:0,1',
            'options' => [
                'required_if:type,single_choice,multiple_choice,true_false',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array($request->type, ['single_choice', 'multiple_choice', 'true_false'])) {
                        $hasCorrect = collect($value)->contains('is_correct', '1');
                        if (!$hasCorrect) {
                            $fail('Phải có ít nhất một tùy chọn đúng.');
                        }
                        if ($request->type === 'single_choice' && collect($value)->where('is_correct', '1')->count() > 1) {
                            $fail('Loại trắc nghiệm một đáp án chỉ được có một tùy chọn đúng.');
                        }
                    }
                },
            ],
        ]);

        $question->update($validated);

        if (in_array($validated['type'], ['single_choice', 'multiple_choice', 'true_false'])) {
            $question->options()->delete();
            if (!empty($request->options)) {
                foreach ($request->options as $option) {
                    $question->options()->create([
                        'option_text' => $option['option_text'],
                        'is_correct' => (bool) $option['is_correct'],
                        'sort_order' => 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Câu hỏi đã được cập nhật.');
    }

    public function destroy(Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Câu hỏi đã được xóa.');
    }
}
