@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="min-h-screen bg-gray-50/30">
        <div class="container mx-auto px-6 py-8">
            <!-- Back Navigation -->
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Quay lại
                </a>
            </div>

            <!-- Main Course Content -->
            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                <!-- Hero Section -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-0">
                    <!-- Course Image -->
                    <div class="lg:col-span-2 relative">
                        @if ($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-80 lg:h-full object-cover">
                        @else
                            <div class="w-full h-80 lg:h-full bg-gray-50 flex items-center justify-center">
                                <div class="text-center space-y-2">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-400">Chưa có hình ảnh</span>
                                </div>
                            </div>
                        @endif

                        <!-- Level Badge -->
                        <div class="absolute top-4 left-4 px-2 py-1 bg-white/90 backdrop-blur-sm rounded text-xs font-medium text-gray-700">
                            {{ __($course->level) }}
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="lg:col-span-3 p-8">
                        <div class="space-y-6">
                            <!-- Header -->
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                <span class="text-xs font-medium px-2 py-1 bg-blue-50 text-blue-700 rounded">
                                    {{ $course->category->name }}
                                </span>
                                </div>
                                <h1 class="text-2xl font-semibold text-gray-900 leading-tight mb-3">
                                    {{ $course->title }}
                                </h1>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $course->description }}
                                </p>
                            </div>

                            <!-- Course Meta -->
                            <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-100">
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-gray-500">Thời lượng:</span>
                                        <span class="font-medium text-gray-900">{{ $course->duration_hours }} giờ</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                        <span class="text-gray-500">Ngôn ngữ:</span>
                                        <span class="font-medium text-gray-900">{{ $course->language }}</span>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <span class="text-gray-500">Cấp độ:</span>
                                        <span class="font-medium text-gray-900">{{ __($course->level) }}</span>
                                    </div>
                                    @if($course->enrolled_count > 0)
                                        <div class="flex items-center space-x-2 text-sm">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <span class="text-gray-500">Đã tham gia:</span>
                                            <span class="font-medium text-gray-900">{{ number_format($course->enrolled_count) }} học viên</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Price & Action -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div>
                                    @if ($course->is_free)
                                        <span class="text-xl font-semibold text-emerald-600">
                                        Miễn phí
                                    </span>
                                    @else
                                        <div class="flex items-baseline space-x-2">
                                        <span class="text-xl font-semibold text-gray-900">
                                            {{ number_format($course->discount_price ?? $course->price, 0, ',', '.') }}₫
                                        </span>
                                            @if ($course->discount_price && $course->discount_price < $course->price)
                                                <span class="text-sm line-through text-gray-400">
                                                {{ number_format($course->price, 0, ',', '.') }}₫
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    @if ($enrollment)
                                        <a href="{{ route('student.courses.learn', $course) }}"
                                           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                            </svg>
                                            Học ngay
                                        </a>
                                    @else
                                        <form action="{{ route('student.courses.enroll', $course) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Đăng ký khóa học
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Curriculum -->
            <div class="mt-8 bg-white rounded-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Chương trình học</h2>
                    <p class="text-sm text-gray-500 mt-1">Nội dung chi tiết của khóa học</p>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse ($course->sections as $index => $section)
                        <div class="p-6">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-medium">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-medium text-gray-900 mb-3">
                                        {{ $section->title }}
                                    </h3>

                                    <!-- Lessons & Quizzes -->
                                    <div class="space-y-2">
                                        @foreach ($section->lessons as $lesson)
                                            <div class="flex items-center space-x-2 text-sm text-gray-600 pl-4">
                                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $lesson->title }}</span>
                                                <span class="text-xs text-gray-400">• Bài học</span>
                                            </div>
                                        @endforeach

                                        @foreach ($section->quizzes as $quiz)
                                            <div class="flex items-center space-x-2 text-sm text-gray-600 pl-4">
                                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                </svg>
                                                <span>{{ $quiz->title }}</span>
                                                <span class="text-xs text-gray-400">• Kiểm tra</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Chưa có nội dung</h3>
                            <p class="text-xs text-gray-500">Chương trình học sẽ được cập nhật sớm.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
