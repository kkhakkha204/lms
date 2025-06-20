@extends('layouts.student')

@section('title', 'Khóa học ' . $category->name . ' - LMS')
@section('description', 'Khám phá các khóa học ' . $category->name . ' chất lượng cao từ các chuyên gia hàng đầu')

@section('content')
    <!-- Category Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Breadcrumb -->
                <nav class="flex items-center justify-center space-x-2 text-sm mb-6">
                    <a href="{{ route('student.courses.index') }}" class="text-blue-200 hover:text-white">
                        Tất cả khóa học
                    </a>
                    <i class="fas fa-chevron-right text-blue-300"></i>
                    <span class="text-white">{{ $category->name }}</span>
                </nav>

                <!-- Category Info -->
                <div class="flex items-center justify-center mb-6">
                    @if($category->image)
                        <img src="{{ $category->image_url }}"
                             alt="{{ $category->name }}"
                             class="w-20 h-20 rounded-lg object-cover mr-4">
                    @else
                        <div class="w-20 h-20 rounded-lg flex items-center justify-center mr-4"
                             style="background-color: {{ $category->color ?: '#ffffff' }}20;">
                            <i class="fas fa-folder text-3xl" style="color: {{ $category->color ?: '#ffffff' }};"></i>
                        </div>
                    @endif
                    <div class="text-left">
                        <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $category->name }}</h1>
                        <p class="text-xl text-blue-100">{{ $courses->total() }} khóa học</p>
                    </div>
                </div>

                @if($category->description)
                    <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                        {{ $category->description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Courses List -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters & Sort -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
                <!-- Filter Options -->
                <div class="flex flex-wrap items-center space-x-4">
                    <span class="text-gray-700 font-medium">Lọc theo:</span>

                    <!-- Level Filter -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50">
                            <span>Mức độ</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                            <a href="{{ request()->fullUrlWithQuery(['level' => '']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ !request('level') ? 'bg-blue-50 text-blue-600' : '' }}">
                                Tất cả
                            </a>
                            @foreach(['beginner' => 'Cơ bản', 'intermediate' => 'Trung cấp', 'advanced' => 'Nâng cao'] as $level => $label)
                                <a href="{{ request()->fullUrlWithQuery(['level' => $level]) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('level') == $level ? 'bg-blue-50 text-blue-600' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50">
                            <span>Giá</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                            <a href="{{ request()->fullUrlWithQuery(['price_type' => '']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ !request('price_type') ? 'bg-blue-50 text-blue-600' : '' }}">
                                Tất cả
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_type' => 'free']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('price_type') == 'free' ? 'bg-blue-50 text-blue-600' : '' }}">
                                Miễn phí
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_type' => 'paid']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('price_type') == 'paid' ? 'bg-blue-50 text-blue-600' : '' }}">
                                Có phí
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center space-x-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50">
                        <span>Sắp xếp theo</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                        @php
                            $sortOptions = [
                                'latest' => 'Mới nhất',
                                'popular' => 'Phổ biến',
                                'rating' => 'Đánh giá cao',
                                'price_low' => 'Giá thấp nhất',
                                'price_high' => 'Giá cao nhất'
                            ];
                        @endphp

                        @foreach($sortOptions as $value => $label)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort', 'latest') == $value ? 'bg-blue-50 text-blue-600' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Course Grid -->
            @if($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                            <!-- Course Thumbnail -->
                            <div class="relative">
                                <a href="{{ route('student.courses.show', $course->slug) }}">
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x225?text=Course+Image' }}"
                                         alt="{{ $course->title }}"
                                         class="w-full h-48 object-cover">
                                </a>

                                <!-- Price Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($course->is_free)
                                        <span class="bg-green-500 text-white px-2 py-1 rounded text-sm font-medium">
                                        Miễn phí
                                    </span>
                                    @else
                                        <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm font-medium">
                                        {{ number_format($course->discount_price ?: $course->price) }}đ
                                    </span>
                                    @endif
                                </div>

                                <!-- Level Badge -->
                                <div class="absolute top-3 left-3">
                                    @php
                                        $levelColors = [
                                            'beginner' => 'bg-green-100 text-green-800',
                                            'intermediate' => 'bg-yellow-100 text-yellow-800',
                                            'advanced' => 'bg-red-100 text-red-800'
                                        ];
                                        $levelLabels = [
                                            'beginner' => 'Cơ bản',
                                            'intermediate' => 'Trung cấp',
                                            'advanced' => 'Nâng cao'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $levelColors[$course->level] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $levelLabels[$course->level] ?? ucfirst($course->level) }}
                                </span>
                                </div>
                            </div>

                            <!-- Course Content -->
                            <div class="p-6">
                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('student.courses.show', $course->slug) }}"
                                       class="hover:text-blue-600">
                                        {{ $course->title }}
                                    </a>
                                </h3>

                                <!-- Short Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $course->short_description }}
                                </p>

                                <!-- Instructor -->
                                <div class="flex items-center mb-4">
                                    <img src="{{ $course->instructor->avatar_url }}"
                                         alt="{{ $course->instructor->name }}"
                                         class="w-8 h-8 rounded-full mr-2">
                                    <span class="text-sm text-gray-700">{{ $course->instructor->name }}</span>
                                </div>

                                <!-- Course Stats -->
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        {{ number_format($course->rating, 1) }}
                                    </span>
                                        <span class="flex items-center">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ number_format($course->enrolled_count) }}
                                    </span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('student.courses.show', $course->slug) }}"
                                   class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $courses->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy khóa học</h3>
                    <p class="text-gray-600 mb-6">
                        Không có khóa học nào trong danh mục "{{ $category->name }}" phù hợp với bộ lọc hiện tại.
                    </p>
                    <a href="{{ route('student.courses.category', $category->slug) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Xem tất cả khóa học {{ $category->name }}
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
