<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class CourseReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        // Lấy course từ route parameter
        $courseSlug = $this->route('courseSlug');
        $course = \App\Models\Course::where('slug', $courseSlug)->first();

        if (!$course) {
            return false;
        }

        // Kiểm tra user đã enroll khóa học chưa
        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        return $enrollment;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'review' => [
                'nullable',
                'string',
                'max:1000'
            ]
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer' => 'Đánh giá phải là số nguyên.',
            'rating.min' => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max' => 'Đánh giá tối đa là 5 sao.',
            'review.string' => 'Nội dung đánh giá phải là văn bản.',
            'review.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'rating' => 'đánh giá sao',
            'review' => 'nội dung đánh giá',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Bạn cần đăng ký khóa học này trước khi có thể đánh giá.'
        );
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Kiểm tra user đã review khóa học này chưa (chỉ cho store request)
            if ($this->isMethod('post')) {
                $courseSlug = $this->route('courseSlug');
                $course = \App\Models\Course::where('slug', $courseSlug)->first();

                if ($course) {
                    $existingReview = \App\Models\CourseReview::where('student_id', Auth::id())
                        ->where('course_id', $course->id)
                        ->first();

                    if ($existingReview) {
                        $validator->errors()->add('rating', 'Bạn đã đánh giá khóa học này rồi.');
                    }
                }
            }
        });
    }
}
