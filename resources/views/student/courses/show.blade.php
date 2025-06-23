@extends('layouts.app')

@section('title', $course->title . ' - LMS')
@section('description', $course->short_description)

@section('content')
    <!-- Hero Section with Modern Design -->
    <div class="relative bg-gradient-to-br from-[#1c1c1c] via-[#2a2a2a] to-[#7e0202] text-white overflow-hidden pt-32">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-40 h-40 bg-[#ed292a] opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-20 right-20 w-32 h-32 bg-white opacity-5 rounded-full blur-xl"></div>
            <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-[#7e0202] opacity-20 rounded-full blur-lg"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Enhanced Breadcrumb -->
                    <nav class="flex items-center space-x-3 text-sm mb-8 p-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl">
                        <a href="{{ route('student.courses.index') }}" class="text-[#ed292a] hover:text-white transition-colors duration-300 font-medium">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Khóa học
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="{{ route('student.courses.category', $course->category->slug) }}" class="text-[#ed292a] hover:text-white transition-colors duration-300 font-medium">
                            {{ $course->category->name }}
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="text-gray-300">{{ Str::limit($course->title, 30) }}</span>
                    </nav>

                    <!-- Enhanced Course Title & Info -->
                    <div class="mb-8">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-[#ed292a] bg-opacity-20 border border-[#ed292a] border-opacity-30 text-[#ed292a] text-sm font-medium mb-6">
                            <i class="fas fa-star mr-2"></i>
                            Khóa học được đánh giá cao
                        </div>

                        <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent leading-tight" style="font-family: 'CustomTitle', sans-serif; ">
                            {{ $course->title }}
                        </h1>

                        <p class="text-[16px] text-gray-300 mb-8 leading-relaxed max-w-3xl">
                            {{ $course->short_description }}
                        </p>
                    </div>

                    <!-- Enhanced Course Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-8">
                        <!-- Rating -->
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                            <div class="flex justify-center text-amber-400 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($course->rating))
                                        <i class="fas fa-star text-lg"></i>
                                    @elseif($i <= $course->rating)
                                        <i class="fas fa-star-half-alt text-lg"></i>
                                    @else
                                        <i class="far fa-star text-lg"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-2xl font-semibold text-white">{{ number_format($course->rating, 1) }}</div>
                        </div>

                        <!-- Students -->
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                            <div class="flex justify-center text-[#ed292a] mb-2">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div class="text-2xl font-semibold text-white">{{ number_format($course->enrolled_count) }}</div>
                        </div>

                        <!-- Duration -->
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                            <div class="flex justify-center text-blue-400 mb-2">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                            <div class="text-2xl font-semibold text-white">{{ $course->duration_hours }}</div>
                        </div>

                        <!-- Level -->
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                            <div class="flex justify-center text-green-400 mb-2">
                                @php
                                    $levelIcons = [
                                        'beginner' => 'fas fa-seedling',
                                        'intermediate' => 'fas fa-tree',
                                        'advanced' => 'fas fa-mountain'
                                    ];
                                @endphp
                                <i class="{{ $levelIcons[$course->level] ?? 'fas fa-signal' }} text-2xl"></i>
                            </div>
                            @php
                                $levelLabels = [
                                    'beginner' => 'Cơ bản',
                                    'intermediate' => 'Trung cấp',
                                    'advanced' => 'Nâng cao'
                                ];
                            @endphp
                            <div class="text-lg font-semibold text-white">{{ $levelLabels[$course->level] ?? ucfirst($course->level) }}</div>
                        </div>

                        <!-- Language -->
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                            <div class="flex justify-center text-purple-400 mb-2">
                                <i class="fas fa-globe text-2xl"></i>
                            </div>
                            <div class="text-lg font-semibold text-white">{{ $course->language == 'vi' ? 'Tiếng Việt' : 'English' }}</div>
                        </div>
                    </div>

                    <!-- Enhanced Instructor Info -->
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-chalkboard-teacher text-white mr-3"></i>
                            Giảng viên của khóa học
                        </h3>
                        <div class="flex items-center">
                            <div class="relative">
                                <img src="{{ $course->instructor->avatar_url }}"
                                     alt="{{ $course->instructor->name }}"
                                     class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-[#1c1c1c] text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-xl font-bold text-white mb-2">{{ $course->instructor->name }}</h4>
                                @if($course->instructor->bio)
                                    <p class="text-gray-300 leading-relaxed">{{ Str::limit($course->instructor->bio, 150) }}</p>
                                @endif
                                <div class="flex items-center mt-3 space-x-4">
                                    <span class="text-sm text-gray-400">
                                        <i class="fas fa-medal text-white mr-1"></i>
                                        Chuyên gia
                                    </span>
                                    <span class="text-sm text-gray-400">
                                        <i class="fas fa-certificate text-white mr-1"></i>
                                        Giảng viên được chứng nhận
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar - Course Purchase Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden sticky top-24 border border-gray-200">
                        <!-- Enhanced Preview Section -->
                        <div class="relative">
                            @if($course->preview_video)
                                <video controls class="w-full h-56 object-cover">
                                    <source src="{{ asset('storage/' . $course->preview_video) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x225?text=Course+Preview' }}"
                                     alt="{{ $course->title }}"
                                     class="w-full h-56 object-cover">
                            @endif

                            @if(!$course->preview_video)
                                <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center group hover:bg-opacity-50 transition-all duration-300">
                                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm">
                                        <i class="fas fa-play text-white text-2xl ml-1"></i>
                                    </div>
                                </div>
                            @endif

                            <!-- Quality Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg">
                                    <i class="fas fa-crown mr-2"></i>
                                    Premium
                                </span>
                            </div>
                        </div>

                        <div class="p-8">
                            <!-- Enhanced Price Section -->
                            <div class="mb-8">
                                @if($course->is_free)
                                    <div class="text-center">
                                        <div class="text-4xl font-bold text-green-600 mb-2">Miễn phí</div>
                                        <div class="text-sm text-gray-500">Truy cập ngay lập tức</div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        @if($course->discount_price && $course->discount_price < $course->price)
                                            <div class="flex items-center justify-center space-x-3 mb-4">
                                                <span class="text-4xl font-extrabold text-[#1c1c1c]">
                                                    {{ number_format($course->discount_price) }}đ
                                                </span>

                                            </div>
                                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-medium">
                                                <i class="fas fa-tag mr-2"></i>
                                                Tiết kiệm {{ number_format($course->price - $course->discount_price) }}đ
                                            </div>
                                        @else
                                            <div class="text-4xl font-bold text-[#ed292a] mb-2">
                                                {{ number_format($course->price) }}đ
                                            </div>
                                            <div class="text-sm text-gray-500">Thanh toán một lần</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Enhanced Action Buttons -->
                            @auth
                                @if($isEnrolled)
                                    <a href="{{ route('student.learn', $course->slug) }}"
                                       class="block w-full bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-3 rounded-2xl hover:shadow-lg hover:shadow-green-600/25 font-bold text-lg transition-all duration-300 hover:scale-105 mb-4">
                                        <i class="fas fa-play mr-3"></i>
                                        Tiếp tục học tập
                                    </a>
                                @else
                                    @if($course->is_free)
                                        <a href="{{ route('payment.checkout', $course->slug) }}"
                                           class="block w-full bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white text-center py-3 rounded-2xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-bold text-lg transition-all duration-300 hover:scale-105 mb-4">
                                            <i class="fas fa-graduation-cap mr-3"></i>
                                            Đăng ký miễn phí ngay
                                        </a>
                                    @else
                                        <a href="{{ route('payment.checkout', $course->slug) }}"
                                           class="block w-full bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white text-center py-3 rounded-2xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-bold text-lg transition-all duration-300 hover:scale-105 mb-4">
                                            <i class="fas fa-shopping-cart mr-3"></i>
                                            Mua khóa học ngay
                                        </a>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="block w-full bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white text-center py-3 rounded-2xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-bold text-lg transition-all duration-300 hover:scale-105 mb-4">
                                    <i class="fas fa-sign-in-alt mr-3"></i>
                                    Đăng nhập để mua khóa học
                                </a>
                            @endauth

                            <!-- 30-day Money Back Guarantee -->
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-xl text-sm font-medium">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Đảm bảo hoàn tiền trong 30 ngày
                                </div>
                            </div>

                            <!-- Enhanced Course Includes -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-bold text-[#1c1c1c] mb-4 flex items-center">
                                    <i class="fas fa-gift text-[#ed292a] mr-3"></i>
                                    Khóa học này bao gồm:
                                </h4>
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <li class="flex items-center">
                                        <i class="fas fa-play-circle text-[#ed292a] w-5 mr-3"></i>
                                        <span class="font-medium">{{ $totalLessons }} bài học video chất lượng cao</span>
                                    </li>
                                    @if($totalQuizzes > 0)
                                        <li class="flex items-center">
                                            <i class="fas fa-question-circle text-[#ed292a] w-5 mr-3"></i>
                                            <span class="font-medium">{{ $totalQuizzes }} bài kiểm tra thực hành</span>
                                        </li>
                                    @endif
                                    <li class="flex items-center">
                                        <i class="fas fa-infinity text-[#ed292a] w-5 mr-3"></i>
                                        <span class="font-medium">Truy cập trọn đời không giới hạn</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-mobile-alt text-[#ed292a] w-5 mr-3"></i>
                                        <span class="font-medium">Học trên mọi thiết bị (PC, Mobile, Tablet)</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-certificate text-[#ed292a] w-5 mr-3"></i>
                                        <span class="font-medium">Chứng chỉ hoàn thành được chứng nhận</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-headset text-[#ed292a] w-5 mr-3"></i>
                                        <span class="font-medium">Hỗ trợ học viên 24/7</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Enhanced Share Section -->
                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <h4 class="font-bold text-[#1c1c1c] mb-4 flex items-center">
                                    <i class="fas fa-share-alt text-[#ed292a] mr-3"></i>
                                    Chia sẻ khóa học:
                                </h4>
                                <div class="grid grid-cols-4 gap-3">
                                    <button class="bg-blue-600 text-white py-3 rounded-xl text-sm hover:bg-blue-700 transition-colors duration-300 hover:scale-105">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button class="bg-blue-400 text-white py-3 rounded-xl text-sm hover:bg-blue-500 transition-colors duration-300 hover:scale-105">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="bg-blue-700 text-white py-3 rounded-xl text-sm hover:bg-blue-800 transition-colors duration-300 hover:scale-105">
                                        <i class="fab fa-linkedin-in"></i>
                                    </button>
                                    <button class="bg-gray-600 text-white py-3 rounded-xl text-sm hover:bg-gray-700 transition-colors duration-300 hover:scale-105">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Course Content Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Enhanced Tabs Navigation -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-2 mb-8" x-data="{ activeTab: 'overview' }">
                        <nav class="flex space-x-2">
                            <button @click="activeTab = 'overview'"
                                    :class="activeTab === 'overview' ? 'bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white shadow-lg' : 'text-gray-600 hover:text-[#ed292a] hover:bg-gray-50'"
                                    class="flex-1 py-4 px-6 rounded-xl font-semibold text-sm transition-all duration-300">
                                <i class="fas fa-info-circle mr-2"></i>
                                Tổng quan
                            </button>
                            <button @click="activeTab = 'curriculum'"
                                    :class="activeTab === 'curriculum' ? 'bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white shadow-lg' : 'text-gray-600 hover:text-[#ed292a] hover:bg-gray-50'"
                                    class="flex-1 py-4 px-6 rounded-xl font-semibold text-sm transition-all duration-300">
                                <i class="fas fa-list mr-2"></i>
                                Nội dung khóa học
                            </button>
                            <button @click="activeTab = 'reviews'"
                                    :class="activeTab === 'reviews' ? 'bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white shadow-lg' : 'text-gray-600 hover:text-[#ed292a] hover:bg-gray-50'"
                                    class="flex-1 py-4 px-6 rounded-xl font-semibold text-sm transition-all duration-300">
                                <i class="fas fa-star mr-2"></i>
                                Đánh giá ({{ $course->reviews_count }})
                            </button>
                        </nav>

                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" class="mt-8 p-6">
                            <div class="prose max-w-none">
                                <h3 class="text-3xl font-bold text-[#1c1c1c] mb-6 flex items-center">
                                    <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                                    Mô tả khóa học
                                </h3>
                                <div class="text-gray-700 leading-relaxed text-lg">
                                    {!! nl2br(e($course->description)) !!}
                                </div>
                            </div>

                            <!-- What You'll Learn -->
                            @if($course->tags && count($course->tags) > 0)
                                <div class="mt-12 bg-gradient-to-r from-[#ed292a]/5 to-[#7e0202]/5 rounded-2xl p-8 border border-[#ed292a]/20">
                                    <h3 class="text-3xl font-bold text-[#1c1c1c] mb-6 flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-xl flex items-center justify-center mr-4">
                                            <i class="fas fa-lightbulb text-white text-xl"></i>
                                        </div>
                                        Bạn sẽ học được gì
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($course->tags as $tag)
                                            <div class="flex items-start bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                                                <div class="w-6 h-6 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-full flex items-center justify-center mr-4 mt-0.5">
                                                    <i class="fas fa-check text-white text-sm"></i>
                                                </div>
                                                <span class="text-gray-700 font-medium">{{ $tag }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Curriculum Tab -->
                        <div x-show="activeTab === 'curriculum'" class="mt-8 p-6">
                            <h3 class="text-3xl font-bold text-[#1c1c1c] mb-8 flex items-center">
                                <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                                Nội dung khóa học
                            </h3>

                            <div class="space-y-6">
                                @foreach($course->sections as $index => $section)
                                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" x-data="{ expanded: {{ $index === 0 ? 'true' : 'false' }} }">
                                        <button @click="expanded = !expanded"
                                                class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors duration-300">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-xl flex items-center justify-center mr-4">
                                                    <i class="fas fa-folder text-white"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-xl font-bold text-[#1c1c1c] mb-1">{{ $section->title }}</h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $section->lessons->count() + $section->quizzes->count() }} bài học
                                                        @if($section->lessons->sum('video_duration'))
                                                            • {{ $section->lessons->sum('video_duration') }} phút
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-sm text-gray-500 mr-4">
                                                    {{ $section->lessons->count() + $section->quizzes->count() }} mục
                                                </span>
                                                <i class="fas fa-chevron-down transition-transform duration-300 text-[#ed292a]"
                                                   :class="expanded ? 'transform rotate-180' : ''"></i>
                                            </div>
                                        </button>

                                        <div x-show="expanded"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                                             x-transition:enter-end="opacity-100 transform translate-y-0"
                                             class="border-t border-gray-200">
                                            <div class="p-6 bg-gray-50">
                                                <div class="space-y-3">
                                                    <!-- Lessons -->
                                                    @foreach($section->lessons as $lesson)
                                                        <div class="flex items-center justify-between py-4 px-6 bg-white hover:bg-gray-50 rounded-xl transition-colors duration-300 border border-gray-200">
                                                            <div class="flex items-center">
                                                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                                                    <i class="fas fa-play text-blue-600 text-sm"></i>
                                                                </div>
                                                                <div>
                                                                    <span class="text-gray-800 font-medium">{{ $lesson->title }}</span>
                                                                    @if($lesson->is_preview)
                                                                        <span class="ml-3 text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                                                            <i class="fas fa-eye mr-1"></i>
                                                                            Xem trước miễn phí
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center space-x-4">
                                                                @if($lesson->video_duration)
                                                                    <span class="text-sm text-gray-500 flex items-center">
                                                                        <i class="fas fa-clock mr-1"></i>
                                                                        {{ $lesson->video_duration }} phút
                                                                    </span>
                                                                @endif
                                                                @if($lesson->is_preview)
                                                                    <button class="text-[#ed292a] hover:text-[#7e0202] transition-colors duration-300">
                                                                        <i class="fas fa-play-circle"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- Quizzes -->
                                                    @foreach($section->quizzes as $quiz)
                                                        <div class="flex items-center justify-between py-4 px-6 bg-white hover:bg-gray-50 rounded-xl transition-colors duration-300 border border-gray-200">
                                                            <div class="flex items-center">
                                                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                                                                    <i class="fas fa-question-circle text-orange-600 text-sm"></i>
                                                                </div>
                                                                <span class="text-gray-800 font-medium">{{ $quiz->title }}</span>
                                                            </div>
                                                            <span class="text-sm text-gray-500 flex items-center">
                                                                <i class="fas fa-question mr-1"></i>
                                                                {{ $quiz->questions->count() }} câu hỏi
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" class="mt-8 p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                                <h3 class="text-3xl font-bold text-[#1c1c1c] mb-4 md:mb-0 flex items-center">
                                    <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                                    Đánh giá từ học viên
                                </h3>

                                @auth
                                    @if($canReview)
                                        <a href="{{ route('courses.review.create', $course->slug) }}"
                                           class="inline-flex items-center bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-6 py-3 rounded-xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-semibold transition-all duration-300 hover:scale-105">
                                            <i class="fas fa-star mr-2"></i>
                                            Viết đánh giá
                                        </a>
                                    @elseif($userReview)
                                        <div class="flex space-x-3">
                                            <a href="{{ route('courses.review.edit', $course->slug) }}"
                                               class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 font-semibold transition-all duration-300">
                                                <i class="fas fa-edit mr-2"></i>
                                                Sửa đánh giá
                                            </a>
                                        </div>
                                    @elseif(!$isEnrolled)
                                        <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-xl">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Bạn cần đăng ký khóa học để đánh giá
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                       class="inline-flex items-center bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-6 py-3 rounded-xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-semibold transition-all duration-300 hover:scale-105">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Đăng nhập để đánh giá
                                    </a>
                                @endauth
                            </div>

                            <!-- User's Review (if exists) -->
                            @if($userReview)
                                <div class="bg-gradient-to-r from-[#ed292a]/5 to-[#7e0202]/5 border-2 border-[#ed292a]/20 rounded-2xl p-6 mb-8">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-3">
                                                <div class="w-3 h-3 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-full mr-3"></div>
                                                <h4 class="font-bold text-[#1c1c1c] mr-4">Đánh giá của bạn</h4>
                                                <div class="flex text-amber-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $userReview->rating)
                                                            <i class="fas fa-star text-lg"></i>
                                                        @else
                                                            <i class="far fa-star text-lg"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-gray-600 ml-3">{{ $userReview->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($userReview->review)
                                                <p class="text-gray-800 leading-relaxed">{{ $userReview->review }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('courses.review.edit', $course->slug) }}"
                                           class="text-[#ed292a] hover:text-[#7e0202] transition-colors duration-300 ml-4">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Enhanced Rating Summary -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 mb-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                    <div class="text-center">
                                        <div class="text-6xl font-bold text-[#1c1c1c] mb-4">{{ number_format($course->rating, 1) }}</div>
                                        <div class="flex justify-center text-amber-400 mb-4">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($course->rating))
                                                    <i class="fas fa-star text-2xl"></i>
                                                @elseif($i <= $course->rating)
                                                    <i class="fas fa-star-half-alt text-2xl"></i>
                                                @else
                                                    <i class="far fa-star text-2xl"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="text-lg text-gray-600 font-medium">{{ number_format($course->reviews_count) }} đánh giá</div>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach($ratingBreakdown as $stars => $data)
                                            <div class="flex items-center">
                                                <span class="text-sm font-medium text-gray-700 w-16">{{ $stars }} sao</span>
                                                <div class="flex-1 mx-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                                                    <div class="bg-gradient-to-r from-[#ed292a] to-[#7e0202] h-3 rounded-full transition-all duration-500"
                                                         style="width: {{ $data['percentage'] }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-700 w-12">{{ $data['percentage'] }}%</span>
                                                <span class="text-sm text-gray-500 w-12 ml-2">({{ $data['count'] }})</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Reviews List -->
                            <div id="reviewsList">
                                @if($course->reviews->count() > 0)
                                    <div class="space-y-6">
                                        @foreach($course->reviews as $review)
                                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-300">
                                                <div class="flex items-start space-x-4">
                                                    <div class="relative">
                                                        <img src="{{ $review->student->avatar_url }}"
                                                             alt="{{ $review->student->name }}"
                                                             class="w-14 h-14 rounded-full border-2 border-gray-200">
                                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#ed292a] rounded-full flex items-center justify-center">
                                                            <i class="fas fa-check text-white text-xs"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-3">
                                                            <h5 class="font-bold text-[#1c1c1c] text-lg">{{ $review->student->name }}</h5>
                                                            <div class="flex items-center space-x-2">
                                                                <div class="flex text-amber-400">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $review->rating)
                                                                            <i class="fas fa-star"></i>
                                                                        @else
                                                                            <i class="far fa-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                                @if($review->updated_at && $review->updated_at != $review->created_at)
                                                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">(đã chỉnh sửa)</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($review->review)
                                                            <p class="text-gray-700 leading-relaxed">{{ $review->review }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Load More Reviews -->
                                    @if($course->reviews_count > 5)
                                        <div class="text-center mt-8">
                                            <button onclick="loadMoreReviews()"
                                                    id="loadMoreBtn"
                                                    class="inline-flex items-center bg-white border-2 border-gray-200 text-gray-700 px-8 py-4 rounded-xl hover:border-[#ed292a] hover:text-[#ed292a] font-semibold transition-all duration-300 hover:scale-105">
                                                <i class="fas fa-chevron-down mr-3"></i>
                                                Xem thêm đánh giá ({{ $course->reviews_count - 5 }} còn lại)
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
                                        <div class="w-24 h-24 bg-gradient-to-r from-[#ed292a]/10 to-[#7e0202]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <i class="fas fa-star text-[#ed292a] text-3xl"></i>
                                        </div>
                                        <h4 class="text-2xl font-bold text-[#1c1c1c] mb-3">Chưa có đánh giá nào</h4>
                                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Hãy là người đầu tiên chia sẻ trải nghiệm của bạn về khóa học này!</p>
                                        @if($canReview)
                                            <a href="{{ route('courses.review.create', $course->slug) }}"
                                               class="inline-flex items-center bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-8 py-4 rounded-xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-semibold transition-all duration-300 hover:scale-105">
                                                <i class="fas fa-star mr-3"></i>
                                                Viết đánh giá đầu tiên
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Related Courses -->
                    @if($relatedCourses->count() > 0)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
                            <h3 class="text-2xl font-bold text-[#1c1c1c] mb-6 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                                Khóa học liên quan
                            </h3>
                            <div class="space-y-4">
                                @foreach($relatedCourses as $relatedCourse)
                                    <div class="group bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-all duration-300 border border-gray-200 hover:border-[#ed292a]/30">
                                        <div class="flex items-start space-x-4">
                                            <div class="relative">
                                                <img src="{{ $relatedCourse->thumbnail ? asset('storage/' . $relatedCourse->thumbnail) : 'https://via.placeholder.com/100x60?text=Course' }}"
                                                     alt="{{ $relatedCourse->title }}"
                                                     class="w-20 h-12 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-300"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-bold text-[#1c1c1c] line-clamp-2 mb-2 group-hover:text-[#ed292a] transition-colors duration-300">
                                                    <a href="{{ route('student.courses.show', $relatedCourse->slug) }}">
                                                        {{ $relatedCourse->title }}
                                                    </a>
                                                </h4>
                                                <p class="text-xs text-gray-600 mb-2 flex items-center">
                                                    <i class="fas fa-user mr-1"></i>
                                                    {{ $relatedCourse->instructor->name }}
                                                </p>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center text-xs text-gray-500">
                                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                                        {{ number_format($relatedCourse->rating, 1) }}
                                                    </div>
                                                    <div class="text-sm font-bold text-[#ed292a]">
                                                        @if($relatedCourse->is_free)
                                                            Miễn phí
                                                        @else
                                                            {{ number_format($relatedCourse->discount_price ?: $relatedCourse->price) }}đ
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Enhanced Course Tags -->
                    @if($course->tags && count($course->tags) > 0)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                            <h3 class="text-xl font-bold text-[#1c1c1c] mb-6 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tags text-white"></i>
                                </div>
                                Từ khóa liên quan
                            </h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($course->tags as $tag)
                                    <span class="inline-block bg-gradient-to-r from-[#ed292a]/10 to-[#7e0202]/10 text-[#1c1c1c] text-sm px-4 py-2 rounded-xl border border-[#ed292a]/20 hover:bg-gradient-to-r hover:from-[#ed292a] hover:to-[#7e0202] hover:text-white font-medium transition-all duration-300 cursor-pointer">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function addToCart(courseId) {
            // TODO: Implement add to cart functionality
            showNotification('Tính năng giỏ hàng sẽ được phát triển trong phần tiếp theo!', 'info');
        }

        function buyNow(courseId) {
            // TODO: Implement buy now functionality
            showNotification('Tính năng thanh toán sẽ được phát triển trong phần tiếp theo!', 'info');
        }

        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transition-all duration-300 transform translate-x-full`;

            const colors = {
                success: 'bg-green-500 text-white',
                error: 'bg-red-500 text-white',
                info: 'bg-blue-500 text-white',
                warning: 'bg-yellow-500 text-black'
            };

            notification.className += ` ${colors[type] || colors.info}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-3"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Smooth scroll for tabs
        document.addEventListener('DOMContentLoaded', function() {
            const urlHash = window.location.hash;
            if (urlHash) {
                const tabButton = document.querySelector(`[x-data] button[onclick*="${urlHash.substring(1)}"]`);
                if (tabButton) {
                    tabButton.click();
                }
            }
        });

        let currentPage = 1;
        let isLoading = false;

        function loadMoreReviews() {
            if (isLoading) return;

            isLoading = true;
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Đang tải...';

            fetch(`{{ route('api.courses.reviews', $course->slug) }}?page=${currentPage + 1}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.reviews.length > 0) {
                        appendReviews(data.reviews);
                        currentPage = data.pagination.current_page;

                        if (currentPage >= data.pagination.last_page) {
                            loadMoreBtn.style.display = 'none';
                        } else {
                            loadMoreBtn.innerHTML = `<i class="fas fa-chevron-down mr-3"></i>Xem thêm đánh giá`;
                        }
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading reviews:', error);
                    loadMoreBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-3"></i>Lỗi tải đánh giá';
                    showNotification('Có lỗi xảy ra khi tải đánh giá', 'error');
                })
                .finally(() => {
                    isLoading = false;
                });
        }

        function appendReviews(reviews) {
            const reviewsList = document.querySelector('#reviewsList .space-y-6');

            reviews.forEach(review => {
                const reviewElement = createReviewElement(review);
                reviewsList.appendChild(reviewElement);
            });
        }

        function createReviewElement(review) {
            const div = document.createElement('div');
            div.className = 'bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-300';

            const stars = Array.from({length: 5}, (_, i) => {
                const starClass = i < review.rating ? 'fas fa-star' : 'far fa-star';
                return `<i class="${starClass}"></i>`;
            }).join('');

            const updatedText = review.updated_at && review.updated_at !== review.created_at
                ? '<span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">(đã chỉnh sửa)</span>'
                : '';

            const reviewContent = review.review
                ? `<p class="text-gray-700 leading-relaxed">${review.review}</p>`
                : '';

            div.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="relative">
                        <img src="${review.student.avatar_url}"
                             alt="${review.student.name}"
                             class="w-14 h-14 rounded-full border-2 border-gray-200">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#ed292a] rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-3">
                            <h5 class="font-bold text-[#1c1c1c] text-lg">${review.student.name}</h5>
                            <div class="flex items-center space-x-2">
                                <div class="flex text-amber-400">
                                    ${stars}
                                </div>
                                <span class="text-sm text-gray-500">${timeAgo(review.created_at)}</span>
                                ${updatedText}
                            </div>
                        </div>
                        ${reviewContent}
                    </div>
                </div>
            `;

            return div;
        }

        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);

            const intervals = [
                { label: 'năm', seconds: 31536000 },
                { label: 'tháng', seconds: 2592000 },
                { label: 'tuần', seconds: 604800 },
                { label: 'ngày', seconds: 86400 },
                { label: 'giờ', seconds: 3600 },
                { label: 'phút', seconds: 60 }
            ];

            for (const interval of intervals) {
                const count = Math.floor(diffInSeconds / interval.seconds);
                if (count > 0) {
                    return `${count} ${interval.label} trước`;
                }
            }

            return 'Vừa xong';
        }

        // Check if user can review when page loads
        document.addEventListener('DOMContentLoaded', function() {
            @auth
            checkCanReview();
            @endauth
        });

        @auth
        function checkCanReview() {
            fetch(`{{ route('api.courses.can-review', $course->slug) }}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    updateReviewButton(data.can_review, data.reason);
                })
                .catch(error => {
                    console.error('Error checking review status:', error);
                });
        }

        function updateReviewButton(canReview, reason) {
            const reviewButtonContainer = document.querySelector('.review-button-container');
            if (!reviewButtonContainer) return;

            if (canReview) {
                reviewButtonContainer.innerHTML = `
                    <a href="{{ route('courses.review.create', $course->slug) }}"
                       class="inline-flex items-center bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-6 py-3 rounded-xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-semibold transition-all duration-300 hover:scale-105">
                        <i class="fas fa-star mr-2"></i>
                        Viết đánh giá
                    </a>
                `;
            } else {
                let buttonText = '';
                switch (reason) {
                    case 'not_enrolled':
                        buttonText = 'Bạn cần đăng ký khóa học để đánh giá';
                        break;
                    case 'already_reviewed':
                        buttonText = 'Bạn đã đánh giá khóa học này';
                        break;
                    default:
                        buttonText = 'Không thể đánh giá';
                }

                reviewButtonContainer.innerHTML = `
                    <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-xl">
                        <i class="fas fa-info-circle mr-2"></i>
                        ${buttonText}
                    </div>
                `;
            }
        }
        @endauth

        // Enhanced scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.bg-white, .bg-gradient-to-r');
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        @font-face {
            font-family: 'CustomTitle';
            src: url('{{ asset("assets/fonts/title2.otf") }}') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .prose {
            max-width: none;
        }

        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #1c1c1c;
            font-weight: 700;
            margin-top: 2em;
            margin-bottom: 1em;
        }

        .prose p {
            margin-bottom: 1.25em;
            line-height: 1.8;
        }

        .prose ul, .prose ol {
            margin: 1.25em 0;
            padding-left: 2em;
        }

        .prose li {
            margin: 0.75em 0;
        }

        .prose strong {
            font-weight: 700;
            color: #1c1c1c;
        }

        .prose a {
            color: #ed292a;
            text-decoration: underline;
            font-weight: 600;
        }

        .prose a:hover {
            color: #7e0202;
            text-decoration: none;
        }

        /* Custom gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced shadows */
        .shadow-glow {
            box-shadow: 0 0 30px rgba(237, 41, 42, 0.15);
        }

        .shadow-glow-lg {
            box-shadow: 0 0 60px rgba(237, 41, 42, 0.2);
        }

        /* Smooth animations */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced hover effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #7e0202, #ed292a);
        }

        /* Rating stars animation */
        .rating-stars i {
            transition: all 0.2s ease;
        }

        .rating-stars:hover i {
            transform: scale(1.1);
        }

        /* Progress bar animation */
        .progress-bar {
            background: linear-gradient(90deg, #ed292a, #7e0202);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Button hover effects */
        .btn-primary {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(237, 41, 42, 0.15);
        }

        /* Backdrop blur fallback */
        @supports not (backdrop-filter: blur(10px)) {
            .backdrop-blur-fallback {
                background-color: rgba(255, 255, 255, 0.9);
            }
        }

        /* Enhanced mobile responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                line-height: 1.2;
            }

            .course-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .instructor-info {
                flex-direction: column;
                text-align: center;
            }

            .sidebar-sticky {
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 640px) {
            .hero-title {
                font-size: 2rem;
            }

            .course-stats {
                grid-template-columns: 1fr;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .auto-dark {
                background-color: #1c1c1c;
                color: white;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .high-contrast {
                border: 2px solid currentColor;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush
