@extends('layouts.student')

@section('title', 'Thanh toán bị hủy - LMS')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <!-- Cancel Icon -->
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-times text-red-600 text-3xl"></i>
                </div>

                <!-- Cancel Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Thanh toán bị hủy</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Giao dịch thanh toán của bạn đã bị hủy. Không có khoản phí nào được tính.
                </p>

                <!-- Reasons -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Có thể bạn gặp phải:</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-circle text-xs text-gray-400 mr-3 mt-2"></i>
                            Thông tin thẻ không chính xác
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-circle text-xs text-gray-400 mr-3 mt-2"></i>
                            Số dư tài khoản không đủ
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-circle text-xs text-gray-400 mr-3 mt-2"></i>
                            Thẻ đã hết hạn hoặc bị khóa
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-circle text-xs text-gray-400 mr-3 mt-2"></i>
                            Kết nối mạng không ổn định
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button onclick="history.back()"
                            class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Thử lại thanh toán
                    </button>

                    <div class="flex space-x-4">
                        <a href="{{ route('student.courses.index') }}"
                           class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-book mr-2"></i>
                            Xem khóa học khác
                        </a>

                        <a href="{{ route('home') }}"
                           class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Về trang chủ
                        </a>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-question-circle text-blue-600 mr-2 mt-0.5"></i>
                        <div class="text-left">
                            <p class="text-sm text-blue-800 font-medium">Cần hỗ trợ?</p>
                            <p class="text-sm text-blue-700">
                                Liên hệ với chúng tôi qua email:
                                <a href="mailto:support@lms.com" class="font-medium underline">support@lms.com</a>
                                hoặc hotline: <span class="font-medium">1900 1234</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Mẹo thanh toán thành công</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-0.5"></i>
                        <p>Kiểm tra kỹ thông tin thẻ (số thẻ, ngày hết hạn, CVV)</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-0.5"></i>
                        <p>Đảm bảo tài khoản có đủ số dư để thanh toán</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-0.5"></i>
                        <p>Sử dụng kết nối internet ổn định</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-0.5"></i>
                        <p>Liên hệ ngân hàng nếu thẻ bị khóa hoặc hạn chế giao dịch online</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
