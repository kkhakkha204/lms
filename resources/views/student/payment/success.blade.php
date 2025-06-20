@extends('layouts.student')

@section('title', 'Thanh toán thành công - LMS')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Thanh toán thành công!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Cảm ơn bạn đã mua khóa học. Bạn đã được đăng ký thành công và có thể bắt đầu học ngay bây giờ.
                </p>

                <!-- Course Info -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <div class="flex items-start space-x-4">
                        <img src="{{ $payment->course->thumbnail ? asset('storage/' . $payment->course->thumbnail) : 'https://via.placeholder.com/120x80?text=Course' }}"
                             alt="{{ $payment->course->title }}"
                             class="w-20 h-14 object-cover rounded">

                        <div class="flex-1 text-left">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $payment->course->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $payment->course->short_description }}</p>

                            <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Giảng viên: {{ $payment->course->instructor->name }}
                            </span>
                                <span class="text-lg font-semibold text-green-600">
                                {{ number_format($payment->final_amount) }}đ
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin thanh toán</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="text-left">
                            <span class="text-gray-600">Mã giao dịch:</span>
                        </div>
                        <div class="text-right font-medium">
                            {{ $payment->transaction_id }}
                        </div>

                        <div class="text-left">
                            <span class="text-gray-600">Thời gian:</span>
                        </div>
                        <div class="text-right font-medium">
                            {{ $payment->paid_at->format('d/m/Y H:i') }}
                        </div>

                        <div class="text-left">
                            <span class="text-gray-600">Phương thức:</span>
                        </div>
                        <div class="text-right font-medium">
                            <i class="fas fa-credit-card mr-1"></i>
                            Thẻ tín dụng
                        </div>

                        <div class="text-left">
                            <span class="text-gray-600">Trạng thái:</span>
                        </div>
                        <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>
                            Thành công
                        </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('student.learn', $payment->course->slug) }}"
                       class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-play mr-2"></i>
                        Bắt đầu học ngay
                    </a>

                    <div class="flex space-x-4">
                        <a href="{{ route('student.dashboard') }}"
                           class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-user mr-2"></i>
                            Dashboard của tôi
                        </a>

                        <a href="{{ route('student.courses.index') }}"
                           class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-book mr-2"></i>
                            Khóa học khác
                        </a>
                    </div>
                </div>

                <!-- Receipt Notice -->
                <div class="mt-8 p-4 bg-yellow-50 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5"></i>
                        <div class="text-left">
                            <p class="text-sm text-yellow-800 font-medium">Thông báo</p>
                            <p class="text-sm text-yellow-700">
                                Hóa đơn điện tử đã được gửi đến email {{ auth()->user()->email }}.
                                Bạn có thể tải xuống hóa đơn từ trang Dashboard.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bước tiếp theo</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-600">1</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Bắt đầu học</h4>
                            <p class="text-sm text-gray-600">Truy cập vào khóa học và bắt đầu với bài học đầu tiên.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-600">2</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Theo dõi tiến độ</h4>
                            <p class="text-sm text-gray-600">Kiểm tra tiến độ học tập của bạn trong Dashboard.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-600">3</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Nhận chứng chỉ</h4>
                            <p class="text-sm text-gray-600">Hoàn thành khóa học để nhận chứng chỉ hoàn thành.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
