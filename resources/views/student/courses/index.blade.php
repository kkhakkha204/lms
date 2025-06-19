@extends('layouts.student')

@section('title', 'Danh sách khóa học')

@section('content')
    <div class="min-h-screen bg-gray-50/30">
        <div class="container mx-auto px-6 py-12">
            <!-- Header Section - Refined -->
            <div class="mb-16 text-center">
                <h1 class="text-2xl font-light text-gray-800 mb-2 tracking-wide">
                    Danh sách khóa học
                </h1>
                <div class="w-12 h-px bg-gray-300 mx-auto"></div>
            </div>

            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($courses as $course)
                    <div class="group bg-white rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all duration-300 overflow-hidden">

                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-video">
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                     alt="{{ $course->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Level badge -->
                            <div class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm rounded text-xs font-medium text-gray-700">
                                {{ __($course->level) }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-3">
                            <div>
                                <h3 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2 leading-relaxed">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-gray-500 text-xs leading-relaxed line-clamp-2">
                                    {{ $course->short_description ?? Str::limit($course->description, 80) }}
                                </p>
                            </div>

                            <!-- Course Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $course->category->name }}</span>
                                <span>{{ $course->duration_hours }}h</span>
                            </div>

                            <!-- Price -->
                            <div class="py-1">
                                @if ($course->is_free)
                                    <span class="text-sm font-medium text-emerald-600">
                                    Miễn phí
                                </span>
                                @else
                                    <div class="flex items-baseline space-x-2">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ number_format($course->discount_price ?? $course->price, 0, ',', '.') }}₫
                                    </span>
                                        @if ($course->discount_price && $course->discount_price < $course->price)
                                            <span class="text-xs line-through text-gray-400">
                                            {{ number_format($course->price, 0, ',', '.') }}₫
                                        </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            <div class="pt-2">
                                <a href="{{ route('student.courses.show', $course) }}"
                                   class="inline-flex items-center justify-center w-full px-3 py-2 text-xs font-medium text-gray-700 bg-gray-50 rounded border border-gray-200 hover:bg-gray-100 hover:border-gray-300 transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                    Xem chi tiết
                                    <svg class="w-3 h-3 ml-1 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 space-y-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="text-center space-y-1">
                            <h3 class="text-sm font-medium text-gray-700">Chưa có khóa học nào</h3>
                            <p class="text-xs text-gray-500">Các khóa học sẽ được cập nhật sớm.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
