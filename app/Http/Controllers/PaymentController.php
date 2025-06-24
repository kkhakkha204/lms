<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Trang checkout
     */
    public function checkout($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('status', 'published')
            ->firstOrFail();

        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để mua khóa học.');
        }

        $user = Auth::user();

        // Kiểm tra đã đăng ký chưa
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('student.courses.show', $course->slug)
                ->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        // Kiểm tra khóa học miễn phí
        if ($course->is_free) {
            return $this->enrollFree($course, $user);
        }

        // Tính toán giá
        $originalPrice = $course->price;
        $discountPrice = $course->discount_price;
        $finalPrice = $discountPrice ?: $originalPrice;
        $discountAmount = $discountPrice ? ($originalPrice - $discountPrice) : 0;

        return view('student.checkout', compact(
            'course',
            'originalPrice',
            'discountPrice',
            'finalPrice',
            'discountAmount'
        ));
    }

    /**
     * Đăng ký khóa học miễn phí
     */
    private function enrollFree($course, $user)
    {
        DB::transaction(function () use ($course, $user) {
            // Tạo payment record cho khóa học miễn phí
            $payment = Payment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'transaction_id' => 'free_' . time() . '_' . $user->id,
                'payment_method' => 'free',
                'amount' => 0,
                'discount_amount' => 0,
                'final_amount' => 0,
                'currency' => 'VND',
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Tạo enrollment
            Enrollment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'paid_amount' => 0,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);

            // Cập nhật số lượng đăng ký
            $course->increment('enrolled_count');
        });

        return redirect()->route('student.dashboard')
            ->with('success', 'Bạn đã đăng ký thành công khóa học miễn phí!');
    }

    /**
     * Tính toán amount cho Stripe dựa trên currency
     */
    private function calculateStripeAmount($amount, $currency = 'vnd')
    {
        // Các loại tiền tệ không sử dụng đơn vị nhỏ hơn (zero-decimal currencies)
        $zeroDecimalCurrencies = [
            'bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw',
            'mga', 'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf',
            'xcd', 'xof', 'xpf'
        ];

        $currency = strtolower($currency);

        if (in_array($currency, $zeroDecimalCurrencies)) {
            // Với VND và các loại tiền zero-decimal, không nhân với 100
            return (int) $amount;
        } else {
            // Với USD, EUR, etc. cần nhân với 100 để chuyển thành cents
            return (int) ($amount * 100);
        }
    }

    /**
     * Tạo Payment Intent cho Stripe
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($request->course_id);
        $user = Auth::user();

        // Kiểm tra đã đăng ký chưa
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'error' => 'Bạn đã đăng ký khóa học này rồi.'
            ], 400);
        }

        try {
            $finalPrice = $course->discount_price ?: $course->price;
            $currency = 'vnd';

            // Tính toán amount phù hợp cho Stripe
            $stripeAmount = $this->calculateStripeAmount($finalPrice, $currency);

            // Kiểm tra giới hạn của Stripe cho VND (99,999,999)
            if ($currency === 'vnd' && $stripeAmount > 99999999) {
                return response()->json([
                    'error' => 'Số tiền vượt quá giới hạn cho phép của Stripe VND (₫99,999,999).'
                ], 400);
            }

            // Tạo Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $stripeAmount,
                'currency' => $currency,
                'metadata' => [
                    'course_id' => $course->id,
                    'student_id' => $user->id,
                    'course_title' => $course->title,
                ],
                'description' => "Thanh toán khóa học: {$course->title}",
            ]);

            // Tạo payment record với status pending
            $payment = Payment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'transaction_id' => $paymentIntent->id,
                'payment_method' => 'stripe',
                'amount' => $course->price,
                'discount_amount' => $course->discount_price ? ($course->price - $course->discount_price) : 0,
                'final_amount' => $finalPrice,
                'currency' => 'VND',
                'status' => 'pending',
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $payment->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi tạo thanh toán: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xác nhận thanh toán thành công
     */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        try {
            // Lấy Payment Intent từ Stripe
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'error' => 'Thanh toán chưa hoàn thành.'
                ], 400);
            }

            // Tìm payment record
            $payment = Payment::where('transaction_id', $paymentIntent->id)->first();

            if (!$payment) {
                return response()->json([
                    'error' => 'Không tìm thấy thông tin thanh toán.'
                ], 404);
            }

            if ($payment->status === 'completed') {
                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán đã được xử lý trước đó.',
                    'enrollment_exists' => true,
                ]);
            }

            // Xử lý trong transaction
            DB::transaction(function () use ($payment, $paymentIntent) {
                // Cập nhật payment
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'payment_details' => $paymentIntent->toArray(),
                ]);

                // Tạo enrollment
                Enrollment::create([
                    'student_id' => $payment->student_id,
                    'course_id' => $payment->course_id,
                    'paid_amount' => $payment->final_amount,
                    'status' => 'active',
                    'enrolled_at' => now(),
                ]);

                // Cập nhật số lượng đăng ký
                $payment->course->increment('enrolled_count');
            });

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công! Bạn đã được đăng ký vào khóa học.',
                'redirect_url' => route('student.dashboard'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Webhook từ Stripe
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response('Webhook signature verification failed.', 400);
        }

        // Xử lý các event từ Stripe
        switch ($event['type']) {
            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event['data']['object']);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event['data']['object']);
                break;

            default:
                // Unhandled event type
        }

        return response('Webhook handled', 200);
    }

    /**
     * Xử lý thanh toán thành công từ webhook
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent['id'])->first();

        if ($payment && $payment->status === 'pending') {
            DB::transaction(function () use ($payment, $paymentIntent) {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'payment_details' => $paymentIntent,
                ]);

                // Kiểm tra enrollment đã tồn tại chưa
                $enrollment = Enrollment::where('student_id', $payment->student_id)
                    ->where('course_id', $payment->course_id)
                    ->first();

                if (!$enrollment) {
                    Enrollment::create([
                        'student_id' => $payment->student_id,
                        'course_id' => $payment->course_id,
                        'paid_amount' => $payment->final_amount,
                        'status' => 'active',
                        'enrolled_at' => now(),
                    ]);

                    $payment->course->increment('enrolled_count');
                }
            });
        }
    }

    /**
     * Xử lý thanh toán thất bại từ webhook
     */
    private function handlePaymentIntentFailed($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent['id'])->first();

        if ($payment && $payment->status === 'pending') {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $paymentIntent['last_payment_error']['message'] ?? 'Payment failed',
                'payment_details' => $paymentIntent,
            ]);
        }
    }

    /**
     * Trang thanh toán thành công
     */
    public function success(Request $request)
    {
        $paymentIntentId = $request->get('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Không tìm thấy thông tin thanh toán.');
        }

        $payment = Payment::where('transaction_id', $paymentIntentId)
            ->with('course')
            ->first();

        if (!$payment) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Không tìm thấy thông tin thanh toán.');
        }

        return view('student.payment.success', compact('payment'));
    }

    /**
     * Trang thanh toán thất bại
     */
    public function cancel(Request $request)
    {
        return view('student.payment.cancel');
    }
}
