@extends('layouts.student')

@section('title', 'Danh sách khóa học - LMS')
@section('description', 'Khám phá hàng nghìn khóa học chất lượng cao từ các chuyên gia hàng đầu')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Khám phá hàng nghìn khóa học
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Học từ các chuyên gia hàng đầu, nâng cao kỹ năng và phát triển sự nghiệp của bạn
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('student.courses.index') }}" method="GET">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Tìm kiếm khóa học, chủ đề..."
                                   class="w-full pl-12 pr-4 py-4 text-gray-900 rounded-lg text-lg focus:ring-4 focus:ring-blue-300 focus:outline-none">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                <i class="fas fa-search text-gray-400 text-lg"></i>
                            </div>
                            <button type="submit"
                                    class="absolute inset-y-0 right-0 bg-orange-500 text-white px-6 rounded-r-lg hover:bg-orange-600 font-semibold">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters & Course List -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-semibold mb-4">Lọc khóa học</h3>

                        <form action="{{ route('student.courses.index') }}" method="GET" id="filterForm">
                            <!-- Preserve search query -->
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 mb-3">Danh mục</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value=""
                                               {{ !request('category') ? 'checked' : '' }}
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Tất cả</span>
                                    </label>
                                    @foreach($categories as $category)
                                        <label class="flex items-center">
                                            <input type="radio" name="category" value="{{ $category->id }}"
                                                   {{ request('category') == $category->id ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-gray-700">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Level Filter -->
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 mb-3">Mức độ</h4>
                                <div class="space-y-2">
                                    @foreach(['beginner' => 'Cơ bản', 'intermediate' => 'Trung cấp', 'advanced' => 'Nâng cao'] as $level => $label)
                                        <label class="flex items-center">
                                            <input type="radio" name="level" value="{{ $level }}"
                                                   {{ request('level') == $level ? 'checked' : '' }}
                                                   class="text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 mb-3">Giá</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="price_type" value=""
                                               {{ !request('price_type') ? 'checked' : '' }}
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Tất cả</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_type" value="free"
                                               {{ request('price_type') == 'free' ? 'checked' : '' }}
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Miễn phí</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="price_type" value="paid"
                                               {{ request('price_type') == 'paid' ? 'checked' : '' }}
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">Có phí</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium">
                                Áp dụng bộ lọc
                            </button>

                            <a href="{{ route('student.courses.index') }}"
                               class="block text-center w-full mt-2 text-gray-600 hover:text-blue-600 py-2">
                                Xóa bộ lọc
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Course List -->
                <div class="lg:w-3/4">
                    <!-- Results Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                @if(request('search'))
                                    Kết quả tìm kiếm cho "{{ request('search') }}"
                                @else
                                    Tất cả khóa học
                                @endif
                            </h2>
                            <p class="text-gray-600 mt-1">{{ $courses->total() }} khóa học</p>
                        </div>

                        <!-- Sort Dropdown -->
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
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
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
                                        <!-- Category -->
                                        <div class="flex items-center text-sm text-blue-600 mb-2">
                                            <i class="fas fa-folder mr-1"></i>
                                            <span>{{ $course->category->name }}</span>
                                        </div>

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
                                                @if($course->duration_hours)
                                                    <span class="flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $course->duration_hours }}h
                                                </span>
                                                @endif
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
                        <div class="mt-8">
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
                                @if(request('search'))
                                    Không có khóa học nào phù hợp với từ khóa "{{ request('search') }}"
                                @else
                                    Không có khóa học nào phù hợp với bộ lọc hiện tại
                                @endif
                            </p>
                            <a href="{{ route('student.courses.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Xem tất cả khóa học
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories -->
    @if(!request()->hasAny(['search', 'category', 'level', 'price_type']))
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Danh mục phổ biến</h2>
                    <p class="text-lg text-gray-600">Khám phá các chủ đề học tập được yêu thích nhất</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($categories->take(8) as $category)
                        <a href="{{ route('student.courses.category', $category->slug) }}"
                           class="bg-white rounded-lg p-6 text-center hover:shadow-md transition-shadow duration-300 group">
                            @if($category->image)
                                <img src="{{ $category->image_url }}"
                                     alt="{{ $category->name }}"
                                     class="w-16 h-16 mx-auto mb-3 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 mx-auto mb-3 rounded-lg flex items-center justify-center"
                                     style="background-color: {{ $category->color ?: '#3B82F6' }}20;">
                                    <i class="fas fa-folder text-2xl" style="color: {{ $category->color ?: '#3B82F6' }};"></i>
                                </div>
                            @endif
                            <h3 class="font-semibold text-gray-900 group-hover:text-blue-600">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $category->courses_count ?? 0 }} khóa học</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
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

@push('scripts')
    <script>
        // Auto submit filter form when radio buttons change
        document.querySelectorAll('#filterForm input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
@endpush
