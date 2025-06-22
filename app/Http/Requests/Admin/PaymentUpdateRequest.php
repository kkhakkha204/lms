<?php
// app/Http/Requests/Admin/PaymentUpdateRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,completed,failed,refunded,cancelled',
            'reason' => 'nullable|string|max:500',
            'payment_details' => 'nullable|array',
            'failure_reason' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Payment status is required.',
            'status.in' => 'Invalid payment status selected.',
            'reason.max' => 'Reason cannot exceed 500 characters.',
            'failure_reason.max' => 'Failure reason cannot exceed 1000 characters.'
        ];
    }
}
