@extends('layouts.app')

@section('title', 'Thanh toán - ' . $course->title)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Hoàn tất đăng ký</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Chỉ còn một bước nữa để bắt đầu hành trình học tập của bạn
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-16">
                <div class="flex items-center justify-center max-w-2xl mx-auto">
                    <div class="flex items-center w-full">
                        <!-- Step 1 -->
                        <div class="flex items-center text-emerald-600">
                            <div class="relative">
                                <div class="flex items-center justify-center w-12 h-12 bg-emerald-600 text-white rounded-full shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-4 text-sm font-semibold hidden sm:block">Chọn khóa học</span>
                        </div>

                        <!-- Connector -->
                        <div class="flex-1 mx-6 h-0.5 bg-gradient-to-r from-emerald-600 to-red-600"></div>

                        <!-- Step 2 -->
                        <div class="flex items-center text-red-600">
                            <div class="relative">
                                <div class="flex items-center justify-center w-12 h-12 bg-red-600 text-white rounded-full shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-4 text-sm font-semibold hidden sm:block">Thanh toán</span>
                        </div>

                        <!-- Connector -->
                        <div class="flex-1 mx-6 h-0.5 bg-gray-300"></div>

                        <!-- Step 3 -->
                        <div class="flex items-center text-gray-400">
                            <div class="relative">
                                <div class="flex items-center justify-center w-12 h-12 bg-gray-300 text-gray-600 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-4 text-sm font-semibold text-gray-500 hidden sm:block">Hoàn thành</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Course Information Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                        <!-- Course Image -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x200?text=Course' }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Bestseller
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $course->short_description }}</p>

                            <!-- Course Meta -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $course->instructor->name }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $course->duration_hours }} giờ học
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    {{ number_format($course->rating, 1) }} ({{ $course->reviews_count ?? 0 }} đánh giá)
                                </div>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="border-t border-gray-100 pt-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Giá gốc:</span>
                                        <span class="text-gray-900 font-medium">{{ number_format($originalPrice) }}đ</span>
                                    </div>

                                    @if($discountAmount > 0)
                                        <div class="flex justify-between items-center text-emerald-600">
                                            <span>Giảm giá:</span>
                                            <span class="font-medium">-{{ number_format($discountAmount) }}đ</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                        <span class="text-lg font-bold text-gray-900">Tổng cộng:</span>
                                        <span class="text-2xl font-bold text-red-600">{{ number_format($finalPrice) }}đ</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Benefits -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h4 class="font-semibold text-gray-900 mb-4">Quyền lợi của bạn:</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Truy cập trọn đời
                                    </li>
                                    <li class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Học trên mọi thiết bị
                                    </li>
                                    <li class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Chứng chỉ hoàn thành
                                    </li>
                                    <li class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Hỗ trợ từ giảng viên
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-900 via-red-900 to-red-700 p-8">
                            <h2 class="text-2xl font-bold text-white mb-2">Thông tin thanh toán</h2>
                            <p class="text-red-100">Điền thông tin bảo mật để hoàn tất giao dịch</p>
                        </div>

                        <div class="p-8">
                            <!-- Payment Method Selection -->
                            <div class="mb-8">
                                <label class="text-lg font-semibold text-gray-900 mb-4 block">Phương thức thanh toán</label>
                                <div class="grid grid-cols-1 gap-4">
                                    <label class="relative flex items-center p-6 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 transition-all duration-200 group">
                                        <input type="radio" name="payment_method" value="card" checked class="sr-only">
                                        <div class="absolute inset-0 border-2 border-red-600 rounded-xl opacity-100"></div>
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-semibold text-gray-900">Thẻ tín dụng / Thẻ ghi nợ</div>
                                                <div class="text-sm text-gray-500">Thanh toán an toàn với Stripe</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="flex space-x-2">
                                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAzMiAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjIwIiByeD0iNCIgZmlsbD0iIzAwNTFBNSIvPgo8cGF0aCBkPSJNMTIuNzUgN0gxNC4yNVYxM0gxMi43NVY3WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+"
                                                     alt="Visa" class="h-6">
                                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAzMiAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjIwIiByeD0iNCIgZmlsbD0iI0VCMDAxQiIvPgo8Y2lyY2xlIGN4PSIxMiIgY3k9IjEwIiByPSI2IiBmaWxsPSIjRkY1RjAwIi8+CjxjaXJjbGUgY3g9IjIwIiBjeT0iMTAiIHI9IjYiIGZpbGw9IiNGRkY1RjAiLz4KPC9zdmc+"
                                                     alt="Mastercard" class="h-6">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Payment Form -->
                            <form id="payment-form" class="space-y-6">
                                <!-- Card Information -->
                                <div class="space-y-4">
                                    <label class="block text-lg font-semibold text-gray-900">
                                        Thông tin thẻ
                                    </label>
                                    <div class="relative">
                                        <div id="card-element" class="p-4 border-2 border-gray-200 rounded-xl bg-gray-50 transition-colors duration-200 focus-within:border-red-500 focus-within:bg-white">
                                            <!-- Stripe Elements sẽ tạo input ở đây -->
                                        </div>
                                        <div id="card-errors" class="text-red-600 text-sm mt-2"></div>
                                    </div>
                                </div>

                                <!-- Billing Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Họ và tên</label>
                                        <div class="relative">
                                            <input type="text"
                                                   value="{{ auth()->user()->name }}"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:border-red-500 focus:bg-white transition-colors duration-200"
                                                   readonly>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                                        <div class="relative">
                                            <input type="email"
                                                   value="{{ auth()->user()->email }}"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:border-red-500 focus:bg-white transition-colors duration-200"
                                                   readonly>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <label class="flex items-start space-x-3">
                                        <input type="checkbox" id="agree-terms" class="mt-1 w-5 h-5 text-red-600 border-2 border-gray-300 rounded focus:ring-red-500">
                                        <div class="text-sm text-gray-700">
                                            <span class="font-medium">Tôi đồng ý với</span>
                                            <a href="#" class="text-red-600 hover:text-red-700 font-semibold">Điều khoản sử dụng</a>
                                            <span class="font-medium">và</span>
                                            <a href="#" class="text-red-600 hover:text-red-700 font-semibold">Chính sách bảo mật</a>
                                            <span class="font-medium">của chúng tôi.</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        id="submit-payment"
                                        class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        <span id="button-text">Thanh toán an toàn {{ number_format($finalPrice) }}đ</span>
                                        <div id="spinner" class="hidden ml-3">
                                            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                        </div>
                                    </span>
                                </button>
                            </form>

                            <!-- Security Notice -->
                            <div class="mt-8 flex items-center justify-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.818-4.954A9.965 9.965 0 0121 12c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2a9.965 9.965 0 014.318.954L17 5l-3-3h5v5l-2-2z"></path>
                                    </svg>
                                    Bảo mật SSL 256-bit
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Được bảo vệ bởi Stripe
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Course -->
            <div class="mt-12 text-center">
                <a href="{{ route('student.courses.show', $course->slug) }}"
                   class="inline-flex items-center text-gray-600 hover:text-red-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Quay lại trang khóa học
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #card-element {
            background-color: transparent;
        }

        .StripeElement {
            background-color: transparent;
            height: 50px;
            padding: 14px 16px;
            border-radius: 12px;
            border: none;
            box-shadow: none;
            transition: all 150ms ease;
            font-size: 16px;
            color: #1f2937;
        }

        .StripeElement--focus {
            background-color: white;
            box-shadow: 0 0 0 2px #dc2626;
        }

        .StripeElement--invalid {
            border-color: #dc2626;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefce8 !important;
        }

        .StripeElement::placeholder {
            color: #9ca3af;
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Loading animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Gradient text effect */
        .gradient-text {
            background: linear-gradient(135deg, #dc2626, #7c2d12);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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

            // Create card element with custom styling
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#1f2937',
                        fontFamily: 'system-ui, -apple-system, sans-serif',
                        fontSmoothing: 'antialiased',
                        '::placeholder': {
                            color: '#9ca3af',
                        },
                        iconColor: '#dc2626',
                    },
                    invalid: {
                        color: '#dc2626',
                        iconColor: '#dc2626',
                    },
                },
                hidePostalCode: true,
            });

            cardElement.mount('#card-element');

            // Handle real-time validation errors from the card Element
            cardElement.on('change', function(event) {
                const displayError = document.getElementById('card-errors');
                const cardContainer = document.getElementById('card-element');

                if (event.error) {
                    displayError.textContent = event.error.message;
                    cardContainer.classList.add('border-red-500', 'bg-red-50');
                    cardContainer.classList.remove('border-gray-200', 'bg-gray-50');
                } else {
                    displayError.textContent = '';
                    cardContainer.classList.remove('border-red-500', 'bg-red-50');
                    cardContainer.classList.add('border-gray-200', 'bg-gray-50');
                }
            });

            // Add visual feedback for card element focus
            cardElement.on('focus', function() {
                const cardContainer = document.getElementById('card-element');
                cardContainer.classList.add('border-red-500', 'bg-white');
                cardContainer.classList.remove('border-gray-200', 'bg-gray-50');
            });

            cardElement.on('blur', function() {
                const cardContainer = document.getElementById('card-element');
                if (!document.getElementById('card-errors').textContent) {
                    cardContainer.classList.remove('border-red-500', 'bg-white');
                    cardContainer.classList.add('border-gray-200', 'bg-gray-50');
                }
            });

            // Enhanced form submission with better UX
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                // Check terms agreement
                const agreeTerms = document.getElementById('agree-terms');
                if (!agreeTerms.checked) {
                    // Better error display
                    showErrorMessage('Vui lòng đồng ý với điều khoản sử dụng để tiếp tục.');
                    agreeTerms.focus();
                    return;
                }

                const submitButton = document.getElementById('submit-payment');
                const buttonText = document.getElementById('button-text');
                const spinner = document.getElementById('spinner');

                // Enhanced loading state
                setLoadingState(true);

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
                        throw new Error(data.error || 'Có lỗi xảy ra khi tạo thanh toán');
                    }

                    // Update button text
                    buttonText.textContent = 'Đang xác thực thẻ...';

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
                        showErrorMessage(error.message);
                        setLoadingState(false);
                    } else {
                        // Update button text for final step
                        buttonText.textContent = 'Đang hoàn tất đăng ký...';

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
                            // Show success state
                            buttonText.textContent = 'Thành công! Đang chuyển hướng...';
                            submitButton.classList.remove('from-red-600', 'to-red-700', 'hover:from-red-700', 'hover:to-red-800');
                            submitButton.classList.add('from-emerald-600', 'to-emerald-700');

                            // Delay redirect for better UX
                            setTimeout(() => {
                                window.location.href = confirmData.redirect_url || '{{ route("payment.success") }}?payment_intent=' + paymentIntent.id;
                            }, 1000);
                        } else {
                            throw new Error(confirmData.error || 'Có lỗi xảy ra khi xác nhận thanh toán');
                        }
                    }
                } catch (error) {
                    showErrorMessage(error.message);
                    setLoadingState(false);
                }
            });

            // Helper functions for better UX
            function setLoadingState(loading) {
                const submitButton = document.getElementById('submit-payment');
                const buttonText = document.getElementById('button-text');
                const spinner = document.getElementById('spinner');

                if (loading) {
                    submitButton.disabled = true;
                    buttonText.textContent = 'Đang xử lý thanh toán...';
                    spinner.classList.remove('hidden');
                    submitButton.classList.add('opacity-90', 'cursor-wait');
                } else {
                    submitButton.disabled = false;
                    buttonText.textContent = 'Thanh toán an toàn {{ number_format($finalPrice) }}đ';
                    spinner.classList.add('hidden');
                    submitButton.classList.remove('opacity-90', 'cursor-wait');
                }
            }

            function showErrorMessage(message) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = message;

                // Scroll to error for better visibility
                errorElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Add visual emphasis
                errorElement.classList.add('animate-pulse');
                setTimeout(() => {
                    errorElement.classList.remove('animate-pulse');
                }, 2000);
            }

            // Add smooth scroll behavior to form sections
            const formInputs = document.querySelectorAll('input, #card-element');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                });
            });
        });
    </script>
@endpush
