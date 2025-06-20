@extends('layouts.student')

@section('title', 'Thanh toán - ' . $course->title)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center text-blue-600">
                        <span class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full text-sm font-medium">
                            1
                        </span>
                            <span class="ml-3 text-sm font-medium">Chọn khóa học</span>
                        </div>
                        <div class="flex-1 mx-4 h-1 bg-blue-600"></div>
                        <div class="flex items-center text-blue-600">
                        <span class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full text-sm font-medium">
                            2
                        </span>
                            <span class="ml-3 text-sm font-medium">Thanh toán</span>
                        </div>
                        <div class="flex-1 mx-4 h-1 bg-gray-300"></div>
                        <div class="flex items-center text-gray-400">
                        <span class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full text-sm font-medium">
                            3
                        </span>
                            <span class="ml-3 text-sm font-medium">Hoàn thành</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Course Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Thông tin khóa học</h2>

                    <div class="flex items-start space-x-4">
                        <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/120x80?text=Course' }}"
                             alt="{{ $course->title }}"
                             class="w-20 h-14 object-cover rounded">

                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $course->short_description }}</p>

                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                {{ $course->instructor->name }}
                            </span>
                                <span class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $course->duration_hours }} giờ
                            </span>
                                <span class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                {{ number_format($course->rating, 1) }}
                            </span>
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Giá gốc:</span>
                                <span class="text-gray-900">{{ number_format($originalPrice) }}đ</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between items-center text-green-600">
                                    <span>Giảm giá:</span>
                                    <span>-{{ number_format($discountAmount) }}đ</span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center text-lg font-semibold border-t pt-3">
                                <span class="text-gray-900">Tổng cộng:</span>
                                <span class="text-blue-600">{{ number_format($finalPrice) }}đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Course Features -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Bạn sẽ nhận được:</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Truy cập trọn đời
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Học trên mọi thiết bị
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Chứng chỉ hoàn thành
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Hỗ trợ từ giảng viên
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Thông tin thanh toán</h2>

                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="text-sm font-medium text-gray-700 mb-3 block">Phương thức thanh toán</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="card" checked class="text-blue-600 focus:ring-blue-500">
                                <div class="ml-3 flex items-center">
                                    <i class="fas fa-credit-card text-gray-400 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-900">Thẻ tín dụng / Thẻ ghi nợ</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Stripe Payment Form -->
                    <form id="payment-form">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Thông tin thẻ
                            </label>
                            <div id="card-element" class="p-3 border border-gray-300 rounded-lg">
                                <!-- Stripe Elements sẽ tạo input ở đây -->
                            </div>
                            <div id="card-errors" class="text-red-600 text-sm mt-2"></div>
                        </div>

                        <!-- Billing Info -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Họ tên</label>
                                <input type="text"
                                       value="{{ auth()->user()->name }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email"
                                       value="{{ auth()->user()->email }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       readonly>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" id="agree-terms" class="mt-1 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">
                                Tôi đồng ý với
                                <a href="#" class="text-blue-600 hover:text-blue-700">Điều khoản sử dụng</a>
                                và
                                <a href="#" class="text-blue-600 hover:text-blue-700">Chính sách bảo mật</a>
                            </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submit-payment"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-lock mr-2"></i>
                            <span id="button-text">Thanh toán {{ number_format($finalPrice) }}đ</span>
                            <div id="spinner" class="hidden ml-2">
                                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </span>
                        </button>
                    </form>

                    <!-- Security Notice -->
                    <div class="mt-4 p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                            <span class="text-sm text-green-700">
                            Thanh toán được bảo mật bởi Stripe SSL 256-bit
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Course -->
            <div class="mt-8 text-center">
                <a href="{{ route('student.courses.show', $course->slug) }}"
                   class="text-blue-600 hover:text-blue-700 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Quay lại trang khóa học
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #card-element {
            background-color: white;
        }

        .StripeElement {
            background-color: white;
            height: 40px;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Stripe
            const stripe = Stripe('{{ config("services.stripe.key") }}');
            const elements = stripe.elements();

            // Create card element
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#424770',
                        '::placeholder': {
                            color: '#aab7c4',
                        },
                    },
                },
            });

            cardElement.mount('#card-element');

            // Handle real-time validation errors from the card Element
            cardElement.on('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                // Check terms agreement
                const agreeTerms = document.getElementById('agree-terms');
                if (!agreeTerms.checked) {
                    alert('Vui lòng đồng ý với điều khoản sử dụng.');
                    return;
                }

                const submitButton = document.getElementById('submit-payment');
                const buttonText = document.getElementById('button-text');
                const spinner = document.getElementById('spinner');

                // Disable button and show loading
                submitButton.disabled = true;
                buttonText.textContent = 'Đang xử lý...';
                spinner.classList.remove('hidden');

                try {
                    // Create payment intent
                    const response = await fetch('{{ route("payment.create-intent") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            course_id: {{ $course->id }},
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Có lỗi xảy ra');
                    }

                    // Confirm payment with Stripe
                    const {error, paymentIntent} = await stripe.confirmCardPayment(data.client_secret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: '{{ auth()->user()->name }}',
                                email: '{{ auth()->user()->email }}',
                            },
                        },
                    });

                    if (error) {
                        // Show error to customer
                        document.getElementById('card-errors').textContent = error.message;

                        // Re-enable button
                        submitButton.disabled = false;
                        buttonText.textContent = 'Thanh toán {{ number_format($finalPrice) }}đ';
                        spinner.classList.add('hidden');
                    } else {
                        // Payment succeeded
                        const confirmResponse = await fetch('{{ route("payment.confirm") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                payment_intent_id: paymentIntent.id,
                            }),
                        });

                        const confirmData = await confirmResponse.json();

                        if (confirmData.success) {
                            // Redirect to success page
                            window.location.href = confirmData.redirect_url || '{{ route("payment.success") }}?payment_intent=' + paymentIntent.id;
                        } else {
                            throw new Error(confirmData.error || 'Có lỗi xảy ra khi xác nhận thanh toán');
                        }
                    }
                } catch (error) {
                    document.getElementById('card-errors').textContent = error.message;

                    // Re-enable button
                    submitButton.disabled = false;
                    buttonText.textContent = 'Thanh toán {{ number_format($finalPrice) }}đ';
                    spinner.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
