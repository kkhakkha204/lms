<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class QuizQuestionController extends Controller
{
    public function index(Course $course, CourseSection $section, Quiz $quiz)
    {
        $questions = $quiz->questions()
            ->orderBy('sort_order')
            ->with('options')
            ->get();

        return view('admin.courses.quizzes.questions.index', compact('course', 'section', 'quiz', 'questions'));
    }

    public function create(Course $course, CourseSection $section, Quiz $quiz)
    {
        // Tự động tính sort_order cho câu hỏi mới
        $nextSortOrder = $quiz->questions()->max('sort_order') + 1;

        return view('admin.courses.quizzes.questions.create', compact('course', 'section', 'quiz', 'nextSortOrder'));
    }

    public function store(Request $request, Course $course, CourseSection $section, Quiz $quiz)
    {
        $validated = $this->validateQuestionData($request);

        DB::transaction(function () use ($validated, $quiz, $request) {
            // Tạo câu hỏi
            $question = $quiz->questions()->create($validated);

            // Xử lý tùy chọn cho các loại câu hỏi có tùy chọn
            $this->handleQuestionOptions($question, $request, $validated['type']);
        });

        return redirect()->route('admin.courses.sections.quizzes.edit', [$course, $section, $quiz])
            ->with('success', 'Câu hỏi đã được tạo thành công.');
    }

    public function edit(Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        $question->load('options');
        return view('admin.courses.quizzes.questions.edit', compact('course', 'section', 'quiz', 'question'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        $validated = $this->validateQuestionData($request, $question);

        DB::transaction(function () use ($validated, $question, $request) {
            // Cập nhật câu hỏi
            $question->update($validated);

            // Xử lý tùy chọn
            $this->handleQuestionOptions($question, $request, $validated['type']);
        });

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Câu hỏi đã được cập nhật thành công.');
    }

    public function destroy(Course $course, CourseSection $section, Quiz $quiz, QuizQuestion $question)
    {
        DB::transaction(function () use ($question) {
            // Xóa tất cả tùy chọn trước
            $question->options()->delete();
            // Xóa câu hỏi
            $question->delete();
        });

        return redirect()->back()->with('success', 'Câu hỏi đã được xóa.');
    }

    /**
     * Validate dữ liệu câu hỏi
     */
    private function validateQuestionData(Request $request, QuizQuestion $question = null)
    {
        $rules = [
            'question' => 'required|string|min:10|max:1000',
            'type' => 'required|in:single_choice,multiple_choice,fill_blank,true_false',
            'explanation' => 'nullable|string|max:2000',
            'points' => 'required|numeric|min:0.1|max:100',
            'is_required' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ];

        // Validation rules cho tùy chọn
        if (in_array($request->type, ['single_choice', 'multiple_choice', 'true_false'])) {
            $rules['options'] = [
                'required',
                'array',
                'min:2',
                function ($attribute, $value, $fail) use ($request) {
                    $this->validateOptions($value, $request->type, $fail);
                },
            ];
            $rules['options.*.option_text'] = 'required|string|min:1|max:500';
            $rules['options.*.is_correct'] = 'required|in:0,1';
        }

        // Validation cho fill_blank
        if ($request->type === 'fill_blank') {
            $rules['correct_answer'] = 'required|string|min:1|max:500';
        }

        $messages = [
            'question.required' => 'Câu hỏi là bắt buộc.',
            'question.min' => 'Câu hỏi phải có ít nhất 10 ký tự.',
            'question.max' => 'Câu hỏi không được vượt quá 1000 ký tự.',
            'type.required' => 'Loại câu hỏi là bắt buộc.',
            'type.in' => 'Loại câu hỏi không hợp lệ.',
            'points.required' => 'Điểm số là bắt buộc.',
            'points.min' => 'Điểm số phải lớn hơn 0.',
            'points.max' => 'Điểm số không được vượt quá 100.',
            'options.required' => 'Tùy chọn là bắt buộc cho loại câu hỏi này.',
            'options.min' => 'Phải có ít nhất 2 tùy chọn.',
            'options.*.option_text.required' => 'Nội dung tùy chọn là bắt buộc.',
            'options.*.option_text.min' => 'Nội dung tùy chọn không được để trống.',
            'options.*.option_text.max' => 'Nội dung tùy chọn không được vượt quá 500 ký tự.',
            'correct_answer.required' => 'Đáp án đúng là bắt buộc cho câu hỏi điền chỗ trống.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Validate tùy chọn câu hỏi
     */
    private function validateOptions($options, $type, $fail)
    {
        if (empty($options)) {
            $fail('Phải có ít nhất 2 tùy chọn.');
            return;
        }

        // Đếm tùy chọn đúng - kiểm tra cả '1' và 1 và true
        $correctOptions = collect($options)->filter(function($option) {
            return isset($option['is_correct']) && (
                    $option['is_correct'] === '1' ||
                    $option['is_correct'] === 1 ||
                    $option['is_correct'] === true
                );
        });

        // Debug: Log để kiểm tra
        \Log::info('Options validation:', [
            'type' => $type,
            'options' => $options,
            'correct_count' => $correctOptions->count()
        ]);

        if ($correctOptions->isEmpty()) {
            $fail('Phải có ít nhất một tùy chọn đúng.');
            return;
        }

        // Kiểm tra số lượng tùy chọn đúng theo loại câu hỏi
        switch ($type) {
            case 'single_choice':
                if ($correctOptions->count() > 1) {
                    $fail('Câu hỏi một đáp án chỉ được có một tùy chọn đúng.');
                }
                if (count($options) < 2) {
                    $fail('Câu hỏi một đáp án phải có ít nhất 2 tùy chọn.');
                }
                break;

            case 'multiple_choice':
                if ($correctOptions->count() < 1) {
                    $fail('Câu hỏi nhiều đáp án phải có ít nhất một tùy chọn đúng.');
                }
                if (count($options) < 3) {
                    $fail('Câu hỏi nhiều đáp án phải có ít nhất 3 tùy chọn.');
                }
                break;

            case 'true_false':
                if (count($options) !== 2) {
                    $fail('Câu hỏi đúng/sai phải có đúng 2 tùy chọn.');
                }
                if ($correctOptions->count() !== 1) {
                    $fail('Câu hỏi đúng/sai phải có đúng một tùy chọn đúng.');
                }
                break;
        }

        // Kiểm tra nội dung tùy chọn không được trùng lặp
        $optionTexts = collect($options)->pluck('option_text')->filter();
        if ($optionTexts->count() !== $optionTexts->unique()->count()) {
            $fail('Các tùy chọn không được trùng lặp.');
        }
    }

    /**
     * Xử lý tùy chọn câu hỏi
     */
    private function handleQuestionOptions(QuizQuestion $question, Request $request, string $type)
    {
        // Xóa tất cả tùy chọn cũ nếu đang cập nhật
        $question->options()->delete();

        if (in_array($type, ['single_choice', 'multiple_choice', 'true_false'])) {
            $this->createQuestionOptions($question, $request->options);
        } elseif ($type === 'fill_blank') {
            // Lưu đáp án đúng cho câu hỏi điền chỗ trống
            $correctAnswer = $request->input('correct_answer');
            if ($correctAnswer) {
                $question->options()->create([
                    'option_text' => trim($correctAnswer),
                    'is_correct' => true,
                    'sort_order' => 1,
                ]);
            }
        }
    }

    /**
     * Tạo tùy chọn cho câu hỏi
     */
    private function createQuestionOptions(QuizQuestion $question, array $options)
    {
        foreach ($options as $index => $option) {
            if (!empty(trim($option['option_text']))) {
                // Kiểm tra is_correct - có thể là '1', 1, true, hoặc 'on'
                $isCorrect = isset($option['is_correct']) && (
                        $option['is_correct'] === '1' ||
                        $option['is_correct'] === 1 ||
                        $option['is_correct'] === true ||
                        $option['is_correct'] === 'on'
                    );

                $question->options()->create([
                    'option_text' => trim($option['option_text']),
                    'is_correct' => $isCorrect,
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }

    /**
     * Sắp xếp lại thứ tự câu hỏi
     */
    public function reorder(Request $request, Course $course, CourseSection $section, Quiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:quiz_questions,id',
            'questions.*.sort_order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $quiz) {
            foreach ($validated['questions'] as $questionData) {
                $quiz->questions()
                    ->where('id', $questionData['id'])
                    ->update(['sort_order' => $questionData['sort_order']]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Thứ tự câu hỏi đã được cập nhật.']);
    }
}
