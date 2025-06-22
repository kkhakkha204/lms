<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Lấy statistics trực tiếp bằng DB::table để tránh conflict
        $stats = [
            'total_payments' => DB::table('payments')->count(),
            'total_revenue' => DB::table('payments')->where('status', 'completed')->sum('final_amount'),
            'pending_payments' => DB::table('payments')->where('status', 'pending')->count(),
            'completed_payments' => DB::table('payments')->where('status', 'completed')->count(),
            'failed_payments' => DB::table('payments')->where('status', 'failed')->count(),
            'refunded_payments' => DB::table('payments')->where('status', 'refunded')->count(),
            'average_order_value' => DB::table('payments')->where('status', 'completed')->avg('final_amount') ?? 0,
        ];

        $query = Payment::with(['student', 'course'])
            ->select('payments.*');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Payment method filter
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Amount range filter
        if ($request->filled('amount_from')) {
            $query->where('final_amount', '>=', $request->amount_from);
        }
        if ($request->filled('amount_to')) {
            $query->where('final_amount', '<=', $request->amount_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $payments = $query->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'course']);

        return response()->json([
            'payment' => $payment,
            'formatted_payment_details' => $this->formatPaymentDetails($payment->payment_details),
            'timeline' => $this->getPaymentTimeline($payment)
        ]);
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded,cancelled',
            'reason' => 'nullable|string|max:500'
        ]);

        $oldStatus = $payment->status;
        $payment->status = $request->status;

        if ($request->status === 'completed' && !$payment->paid_at) {
            $payment->paid_at = now();
        }

        if ($request->filled('reason')) {
            $payment->failure_reason = $request->reason;
        }

        $payment->save();

        // Handle enrollment creation/update based on status
        $this->handleEnrollmentStatus($payment, $oldStatus);

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully'
        ]);
    }

    public function export(Request $request)
    {
        $query = Payment::with(['student', 'course']);

        // Apply same filters as index
        $this->applyFilters($query, $request);

        $payments = $query->get();

        $csvData = [];
        $csvData[] = [
            'Transaction ID',
            'Student Name',
            'Student Email',
            'Course Title',
            'Payment Method',
            'Amount',
            'Discount',
            'Final Amount',
            'Currency',
            'Status',
            'Payment Date',
            'Created At'
        ];

        foreach ($payments as $payment) {
            $csvData[] = [
                $payment->transaction_id,
                $payment->student->name,
                $payment->student->email,
                $payment->course->title,
                ucfirst($payment->payment_method),
                number_format($payment->amount, 2),
                number_format($payment->discount_amount, 2),
                number_format($payment->final_amount, 2),
                $payment->currency,
                ucfirst($payment->status),
                $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : '',
                $payment->created_at->format('Y-m-d H:i:s')
            ];
        }

        $fileName = 'payments_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('amount_from')) {
            $query->where('final_amount', '>=', $request->amount_from);
        }
        if ($request->filled('amount_to')) {
            $query->where('final_amount', '<=', $request->amount_to);
        }
    }

    private function formatPaymentDetails($details)
    {
        if (!$details || !is_array($details)) {
            return [];
        }

        $formatted = [];
        foreach ($details as $key => $value) {
            $formatted[] = [
                'key' => ucwords(str_replace('_', ' ', $key)),
                'value' => is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value
            ];
        }

        return $formatted;
    }

    private function getPaymentTimeline($payment)
    {
        $timeline = [];

        $timeline[] = [
            'title' => 'Payment Created',
            'description' => 'Payment was initiated',
            'date' => $payment->created_at,
            'status' => 'info'
        ];

        if ($payment->paid_at) {
            $timeline[] = [
                'title' => 'Payment Completed',
                'description' => 'Payment was successfully processed',
                'date' => $payment->paid_at,
                'status' => 'success'
            ];
        }

        if ($payment->status === 'failed' && $payment->failure_reason) {
            $timeline[] = [
                'title' => 'Payment Failed',
                'description' => $payment->failure_reason,
                'date' => $payment->updated_at,
                'status' => 'error'
            ];
        }

        if ($payment->status === 'refunded') {
            $timeline[] = [
                'title' => 'Payment Refunded',
                'description' => 'Payment was refunded to customer',
                'date' => $payment->updated_at,
                'status' => 'warning'
            ];
        }

        return collect($timeline)->sortBy('date')->values();
    }

    private function handleEnrollmentStatus($payment, $oldStatus)
    {
        // If payment is completed, ensure enrollment exists
        if ($payment->status === 'completed' && $oldStatus !== 'completed') {
            $enrollment = \App\Models\Enrollment::firstOrCreate([
                'student_id' => $payment->student_id,
                'course_id' => $payment->course_id,
            ], [
                'paid_amount' => $payment->final_amount,
                'enrolled_at' => now(),
                'status' => 'active'
            ]);
        }

        // If payment is refunded or cancelled, update enrollment status
        if (in_array($payment->status, ['refunded', 'cancelled']) && $oldStatus === 'completed') {
            \App\Models\Enrollment::where([
                'student_id' => $payment->student_id,
                'course_id' => $payment->course_id,
            ])->update(['status' => 'cancelled']);
        }
    }
}
