@extends('layouts.student')

@section('title', $course->title . ' - LMS')
@section('description', $course->short_description)

@section('content')
    <div class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm mb-6">
                        <a href="{{ route('student.courses.index') }}" class="text-blue-400 hover:text-blue-300">
                            Khóa học
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="{{ route('student.courses.category', $course->category->slug) }}" class="text-blue-400 hover:text-blue-300">
                            {{ $course->category->name }}
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="text-gray-300">{{ $course->title }}</span>
                    </nav>

                    <!-- Course Title & Basic Info -->
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $course->title }}</h1>

                    <p class="text-xl text-gray-300 mb-6">{{ $course->short_description }}</p>

                    <!-- Course Stats -->
                    <div class="flex flex-wrap items-center gap-6 mb-6">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($course->rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i <= $course->rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="font-semibold">{{ number_format($course->rating, 1) }}</span>
                            <span class="text-gray-400 ml-2">({{ number_format($course->reviews_count) }} đánh giá)</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-users text-gray-400 mr-2"></i>
                            <span>{{ number_format($course->enrolled_count) }} học viên</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-2"></i>
                            <span>{{ $course->duration_hours }} giờ</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-signal text-gray-400 mr-2"></i>
                            @php
                                $levelLabels = [
                                    'beginner' => 'Cơ bản',
                                    'intermediate' => 'Trung cấp',
                                    'advanced' => 'Nâng cao'
                                ];
                            @endphp
                            <span>{{ $levelLabels[$course->level] ?? ucfirst($course->level) }}</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-globe text-gray-400 mr-2"></i>
                            <span>{{ $course->language == 'vi' ? 'Tiếng Việt' : 'English' }}</span>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    <div class="flex items-center bg-gray-800 rounded-lg p-4 mb-6">
                        <img src="{{ $course->instructor->avatar_url }}"
                             alt="{{ $course->instructor->name }}"
                             class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $course->instructor->name }}</h3>
                            @if($course->instructor->bio)
                                <p class="text-gray-400 text-sm">{{ Str::limit($course->instructor->bio, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Course Purchase Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-24">
                        <!-- Preview Video/Image -->
                        <div class="relative">
                            @if($course->preview_video)
                                <video controls class="w-full h-48 object-cover">
                                    <source src="{{ asset('storage/' . $course->preview_video) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x225?text=Course+Preview' }}"
                                     alt="{{ $course->title }}"
                                     class="w-full h-48 object-cover">
                            @endif

                            @if(!$course->preview_video)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-play text-white text-xl"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <!-- Price -->
                            <div class="mb-6">
                                @if($course->is_free)
                                    <div class="text-3xl font-bold text-green-600">Miễn phí</div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        @if($course->discount_price && $course->discount_price < $course->price)
                                            <span class="text-3xl font-bold text-blue-600">
                                            {{ number_format($course->discount_price) }}đ
                                        </span>
                                            <span class="text-lg text-gray-500 line-through">
                                            {{ number_format($course->price) }}đ
                                        </span>
                                        @else
                                            <span class="text-3xl font-bold text-blue-600">
                                            {{ number_format($course->price) }}đ
                                        </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            @auth
                                @if($isEnrolled)
                                    <a href="{{ route('student.learn', $course->slug) }}"
                                       class="block w-full bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 font-semibold mb-3">
                                        <i class="fas fa-play mr-2"></i>
                                        Tiếp tục học
                                    </a>
                                @else
                                    @if($course->is_free)
                                        <a href="{{ route('payment.checkout', $course->slug) }}"
                                           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 font-semibold mb-3">
                                            <i class="fas fa-plus mr-2"></i>
                                            Đăng ký miễn phí
                                        </a>
                                    @else
                                        <a href="{{ route('payment.checkout', $course->slug) }}"
                                           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 font-semibold mb-3">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Mua khóa học
                                        </a>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 font-semibold mb-3">
                                    Đăng nhập để mua khóa học
                                </a>
                            @endauth

                            <!-- Course Includes -->
                            <div class="border-t pt-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Khóa học này bao gồm:</h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <i class="fas fa-play-circle text-blue-500 w-5 mr-2"></i>
                                        {{ $totalLessons }} bài học video
                                    </li>
                                    @if($totalQuizzes > 0)
                                        <li class="flex items-center">
                                            <i class="fas fa-question-circle text-blue-500 w-5 mr-2"></i>
                                            {{ $totalQuizzes }} bài kiểm tra
                                        </li>
                                    @endif
                                    <li class="flex items-center">
                                        <i class="fas fa-infinity text-blue-500 w-5 mr-2"></i>
                                        Truy cập trọn đời
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-mobile-alt text-blue-500 w-5 mr-2"></i>
                                        Học trên mọi thiết bị
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-certificate text-blue-500 w-5 mr-2"></i>
                                        Chứng chỉ hoàn thành
                                    </li>
                                </ul>
                            </div>

                            <!-- Share -->
                            <div class="border-t pt-4 mt-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Chia sẻ khóa học:</h4>
                                <div class="flex space-x-2">
                                    <button class="flex-1 bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button class="flex-1 bg-blue-400 text-white py-2 rounded text-sm hover:bg-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="flex-1 bg-blue-700 text-white py-2 rounded text-sm hover:bg-blue-800">
                                        <i class="fab fa-linkedin-in"></i>
                                    </button>
                                    <button class="flex-1 bg-gray-600 text-white py-2 rounded text-sm hover:bg-gray-700">
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

    <!-- Course Content -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 mb-8" x-data="{ activeTab: 'overview' }">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'overview'"
                                    :class="activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm">
                                Tổng quan
                            </button>
                            <button @click="activeTab = 'curriculum'"
                                    :class="activeTab === 'curriculum' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm">
                                Nội dung khóa học
                            </button>
                            <button @click="activeTab = 'reviews'"
                                    :class="activeTab === 'reviews' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm">
                                Đánh giá ({{ $course->reviews_count }})
                            </button>
                        </nav>

                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" class="mt-8">
                            <div class="prose max-w-none">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Mô tả khóa học</h3>
                                <div class="text-gray-700 leading-relaxed">
                                    {!! nl2br(e($course->description)) !!}
                                </div>
                            </div>

                            <!-- What You'll Learn -->
                            @if($course->tags && count($course->tags) > 0)
                                <div class="mt-8">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Bạn sẽ học được gì</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($course->tags as $tag)
                                            <div class="flex items-start">
                                                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                                <span class="text-gray-700">{{ $tag }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Curriculum Tab -->
                        <div x-show="activeTab === 'curriculum'" class="mt-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Nội dung khóa học</h3>

                            <div class="space-y-4">
                                @foreach($course->sections as $section)
                                    <div class="border border-gray-200 rounded-lg" x-data="{ expanded: false }">
                                        <button @click="expanded = !expanded"
                                                class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50">
                                            <div class="flex items-center">
                                                <i class="fas fa-folder text-blue-500 mr-3"></i>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $section->title }}</h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $section->lessons->count() + $section->quizzes->count() }} bài học
                                                    </p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-down transition-transform"
                                               :class="expanded ? 'transform rotate-180' : ''"></i>
                                        </button>

                                        <div x-show="expanded" x-transition class="border-t border-gray-200">
                                            <div class="p-4 space-y-2">
                                                <!-- Lessons -->
                                                @foreach($section->lessons as $lesson)
                                                    <div class="flex items-center justify-between py-2 px-3 hover:bg-gray-50 rounded">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-play-circle text-blue-500 mr-3"></i>
                                                            <span class="text-gray-700">{{ $lesson->title }}</span>
                                                            @if($lesson->is_preview)
                                                                <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                                                Xem trước
                                                            </span>
                                                            @endif
                                                        </div>
                                                        @if($lesson->video_duration)
                                                            <span class="text-sm text-gray-500">{{ $lesson->video_duration }}</span>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                <!-- Quizzes -->
                                                @foreach($section->quizzes as $quiz)
                                                    <div class="flex items-center justify-between py-2 px-3 hover:bg-gray-50 rounded">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-question-circle text-orange-500 mr-3"></i>
                                                            <span class="text-gray-700">{{ $quiz->title }}</span>
                                                        </div>
                                                        <span class="text-sm text-gray-500">
                                                        {{ $quiz->questions->count() }} câu hỏi
                                                    </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" class="mt-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Đánh giá từ học viên</h3>

                            <!-- Rating Summary -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <div class="text-4xl font-bold text-gray-900 mb-2">{{ number_format($course->rating, 1) }}</div>
                                        <div class="flex justify-center text-yellow-400 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($course->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i <= $course->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="text-sm text-gray-600">{{ number_format($course->reviews_count) }} đánh giá</div>
                                    </div>

                                    <div class="flex-1 ml-8">
                                        @php
                                            $ratingBreakdown = [
                                                5 => 65,
                                                4 => 20,
                                                3 => 10,
                                                2 => 3,
                                                1 => 2
                                            ];
                                        @endphp
                                        @foreach($ratingBreakdown as $stars => $percentage)
                                            <div class="flex items-center mb-2">
                                                <span class="text-sm text-gray-600 w-12">{{ $stars }} sao</span>
                                                <div class="flex-1 mx-3 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-600 w-8">{{ $percentage }}%</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Reviews -->
                            @if($course->reviews->count() > 0)
                                <div class="space-y-6">
                                    @foreach($course->reviews->take(5) as $review)
                                        <div class="border-b border-gray-200 pb-6">
                                            <div class="flex items-start space-x-4">
                                                <img src="{{ $review->student->avatar_url }}"
                                                     alt="{{ $review->student->name }}"
                                                     class="w-12 h-12 rounded-full">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <h5 class="font-semibold text-gray-900">{{ $review->student->name }}</h5>
                                                        <div class="flex text-yellow-400">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star text-sm"></i>
                                                                @else
                                                                    <i class="far fa-star text-sm"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($course->reviews->count() > 5)
                                        <div class="text-center">
                                            <button class="text-blue-600 hover:text-blue-700 font-medium">
                                                Xem tất cả {{ number_format($course->reviews->count()) }} đánh giá
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-star text-gray-400 text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Chưa có đánh giá</h4>
                                    <p class="text-gray-600">Hãy là người đầu tiên đánh giá khóa học này!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Related Courses -->
                    @if($relatedCourses->count() > 0)
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Khóa học liên quan</h3>
                            <div class="space-y-4">
                                @foreach($relatedCourses as $relatedCourse)
                                    <div class="flex items-start space-x-3">
                                        <img src="{{ $relatedCourse->thumbnail ? asset('storage/' . $relatedCourse->thumbnail) : 'https://via.placeholder.com/100x60?text=Course' }}"
                                             alt="{{ $relatedCourse->title }}"
                                             class="w-16 h-10 object-cover rounded">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">
                                                <a href="{{ route('student.courses.show', $relatedCourse->slug) }}"
                                                   class="hover:text-blue-600">
                                                    {{ $relatedCourse->title }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-gray-600 mb-1">{{ $relatedCourse->instructor->name }}</p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                                    {{ number_format($relatedCourse->rating, 1) }}
                                                </div>
                                                <div class="text-sm font-semibold text-blue-600">
                                                    @if($relatedCourse->is_free)
                                                        Miễn phí
                                                    @else
                                                        {{ number_format($relatedCourse->discount_price ?: $relatedCourse->price) }}đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Course Tags -->
                    @if($course->tags && count($course->tags) > 0)
                        <div class="bg-white rounded-lg border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Từ khóa</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->tags as $tag)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
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
            alert('Tính năng giỏ hàng sẽ được phát triển trong phần tiếp theo!');
        }

        function buyNow(courseId) {
            // TODO: Implement buy now functionality
            alert('Tính năng thanh toán sẽ được phát triển trong phần tiếp theo!');
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
    </script>
@endpush

@push('styles')
    <style>
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
            color: #1f2937;
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }

        .prose p {
            margin-bottom: 1em;
        }

        .prose ul, .prose ol {
            margin: 1em 0;
            padding-left: 1.5em;
        }

        .prose li {
            margin: 0.5em 0;
        }

        .prose strong {
            font-weight: 600;
            color: #1f2937;
        }

        .prose a {
            color: #2563eb;
            text-decoration: underline;
        }

        .prose a:hover {
            color: #1d4ed8;
        }
    </style>
@endpush
