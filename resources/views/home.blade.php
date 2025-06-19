@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Học tập hiệu quả với
                        <span class="text-yellow-400">LMS</span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-100">
                        Hệ thống quản lý học tập trực tuyến hiện đại, giúp bạn phát triển kỹ năng và kiến thức một cách toàn diện.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors text-center">
                            Bắt đầu học ngay
                        </a>
                        <a href="#courses" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors text-center">
                            Khám phá khóa học
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="w-96 h-96 bg-white/10 rounded-full backdrop-blur-sm"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-play-circle text-8xl text-white/80"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">1000+</div>
                    <div class="text-gray-600">Học viên</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                    <div class="text-gray-600">Khóa học</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">20+</div>
                    <div class="text-gray-600">Giảng viên</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">95%</div>
                    <div class="text-gray-600">Hài lòng</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tại sao chọn LMS?</h2>
                <p class="text-xl text-gray-600">Những tính năng nổi bật giúp bạn học tập hiệu quả</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Học mọi lúc, mọi nơi</h3>
                    <p class="text-gray-600">Truy cập khóa học 24/7 trên mọi thiết bị</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Giảng viên chuyên nghiệp</h3>
                    <p class="text-gray-600">Đội ngũ giảng viên giàu kinh nghiệm</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Chứng chỉ uy tín</h3>
                    <p class="text-gray-600">Nhận chứng chỉ sau khi hoàn thành</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Sẵn sàng bắt đầu hành trình học tập?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Tham gia cùng hàng nghìn học viên đang học tập tại LMS
            </p>
            <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors inline-block">
                Đăng ký ngay
            </a>
        </div>
    </section>
@endsection
