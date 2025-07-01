@extends('layouts.app')

@section('title', 'Danh sách khóa học - LMS')
@section('description', 'Khám phá hàng nghìn khóa học chất lượng cao từ các chuyên gia hàng đầu')

@section('content')
    <!-- Hero Section with Modern Gradient -->
    <section class="relative bg-gradient-to-br from-[#7e0202] via-[#2a2a2a] to-[#1c1c1c] text-white py-40 overflow-hidden font-quicksand">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-32 h-32 bg-[#ed292a] opacity-10 rounded-full blur-xl"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
            <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-[#7e0202] opacity-20 rounded-full blur-lg"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center pb-2">
                        <span class="bg-black  text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                            Về Tech.era
                        </span>
                </div>

                <h1 class="text-5xl md:text-[52px] mb-6 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent" style="font-family: 'CustomTitle', sans-serif;">
                    Khám phá vô vàn
                    <span class=" bg-gradient-to-r from-white  bg-clip-text text-transparent"><br/>khóa học chất lượng</span>
                </h1>
                <!-- Enhanced Search Bar -->
                <div class="max-w-2xl mx-auto pt-8">
                    <form action="{{ route('courses.index') }}" method="GET" class="relative">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-[40px] blur opacity-20 group-hover:opacity-30 transition-opacity"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-[40px] p-1">
                                <div class="flex items-center">
                                    <div class="flex-1 relative">
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               placeholder="Tìm kiếm khóa học, chủ đề, kỹ năng..."
                                               class="w-full pl-4 pr-4 bg-transparent text-white placeholder-gray-300 text-[16px] focus:outline-none">

                                    </div>
                                    <button type="submit"
                                            class="bg-[#1c1c1c] text-white px-4 py-2.5 rounded-3xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-medium transition-all duration-300 hover:scale-105">
                                        <i class="fas fa-search mr-2"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="flex justify-center items-center space-x-8 mt-4 text-sm">
                    <div class="flex items-center text-gray-50">
                        <i class="fas fa-users mr-2 text-gray-50"></i>
                        <span>10,000+ Học viên</span>
                    </div>
                    <div class="flex items-center text-gray-50">
                        <i class="fas fa-book mr-2 text-gray-50"></i>
                        <span>500+ Khóa học</span>
                    </div>
                    <div class="flex items-center text-gray-50">
                        <i class="fas fa-star mr-2 text-gray-50"></i>
                        <span>4.8/5 Đánh giá</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters & Course List -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Enhanced Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-4 sticky top-24">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-md flex items-center justify-center">
                                <i class="fas fa-filter text-white text-sm"></i>
                            </div>

                        </div>

                        <form action="{{ route('courses.index') }}" method="GET" id="filterForm">
                            <!-- Preserve search query -->
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Category Filter -->
                            <div class="mb-8">
                                <h4 class="font-medium text-[#1c1c1c] ml-1 mb-4 flex items-center">
                                    <i class="fas fa-folder mr-2 text-[#1c1c1c]"></i>
                                    Danh mục
                                </h4>
                                <div class="space-y-3 ml-1">
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="category" value=""
                                               {{ !request('category') ? 'checked' : '' }}
                                               class="sr-only">
                                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ !request('category') ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                            @if(!request('category'))
                                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                            @endif
                                        </div>
                                        <span class="text-gray-700 group-hover:text-[#1c1c1c] font-normal">Tất cả danh mục</span>
                                    </label>
                                    @foreach($categories as $category)
                                        <label class="flex items-center group cursor-pointer">
                                            <input type="radio" name="category" value="{{ $category->id }}"
                                                   {{ request('category') == $category->id ? 'checked' : '' }}
                                                   class="sr-only">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ request('category') == $category->id ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                                @if(request('category') == $category->id)
                                                    <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                                @endif
                                            </div>
                                            <span class="text-gray-700 group-hover:text-[#1c1c1c]">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Level Filter -->
                            <div class="mb-8">
                                <h4 class="font-semibold text-[#1c1c1c] mb-4 flex items-center">
                                    <i class="fas fa-layer-group mr-2 text-[#1c1c1c]"></i>
                                    Mức độ
                                </h4>
                                <div class="space-y-3">
                                    @foreach(['beginner' => 'Cơ bản', 'intermediate' => 'Trung cấp', 'advanced' => 'Nâng cao'] as $level => $label)
                                        <label class="flex items-center group cursor-pointer">
                                            <input type="radio" name="level" value="{{ $level }}"
                                                   {{ request('level') == $level ? 'checked' : '' }}
                                                   class="sr-only">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ request('level') == $level ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                                @if(request('level') == $level)
                                                    <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                                @endif
                                            </div>
                                            <span class="text-gray-700 group-hover:text-[#1c1c1c]">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-8">
                                <h4 class="font-semibold text-[#1c1c1c] mb-4 flex items-center">
                                    <i class="fas fa-tag mr-2 text-[#1c1c1c]"></i>
                                    Giá khóa học
                                </h4>
                                <div class="space-y-3">
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="price_type" value=""
                                               {{ !request('price_type') ? 'checked' : '' }}
                                               class="sr-only">
                                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ !request('price_type') ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                            @if(!request('price_type'))
                                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                            @endif
                                        </div>
                                        <span class="text-gray-700 group-hover:text-[#1c1c1c]">Tất cả</span>
                                    </label>
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="price_type" value="free"
                                               {{ request('price_type') == 'free' ? 'checked' : '' }}
                                               class="sr-only">
                                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ request('price_type') == 'free' ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                            @if(request('price_type') == 'free')
                                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                            @endif
                                        </div>
                                        <span class="text-gray-700 group-hover:text-[#1c1c1c]">Miễn phí</span>
                                    </label>
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="price_type" value="paid"
                                               {{ request('price_type') == 'paid' ? 'checked' : '' }}
                                               class="sr-only">
                                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 group-hover:border-[#ed292a] transition-colors {{ request('price_type') == 'paid' ? 'bg-[#ed292a] border-[#ed292a]' : '' }}">
                                            @if(request('price_type') == 'paid')
                                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                            @endif
                                        </div>
                                        <span class="text-gray-700 group-hover:text-[#1c1c1c]">Có phí</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                    class=" w-full bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white py-2 rounded-3xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-medium transition-all duration-300 hover:scale-105">
                                <i class="fas fa-check mr-2"></i>
                                Áp dụng bộ lọc
                            </button>

                            <a href="{{ route('student.courses.index') }}"
                               class="block text-center w-full mt-1 text-gray-600 hover:text-[#ed292a] py-2 font-normal transition-colors">

                                Xóa bộ lọc
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Enhanced Course List -->
                <div class="lg:w-3/4">
                    <!-- Results Header -->
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                        <div>
                            <h2 class="text-4xl font-bold text-[#1c1c1c] mb-2" style="font-family: 'CustomTitle', sans-serif;">
                                @if(request('search'))
                                    Kết quả cho "<span class="text-[#ed292a]">{{ request('search') }}</span>"
                                @else
                                    Tất cả khóa học
                                @endif
                            </h2>
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-book mr-2 text-[#ed292a]"></i>
                                {{ $courses->total() }} khóa học được tìm thấy
                            </p>
                        </div>

                        <!-- Enhanced Sort Dropdown -->
                        <div class="relative mt-4 md:mt-0" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-3 bg-white border-2 border-gray-200 rounded-xl px-6 py-3 hover:border-[#ed292a] hover:bg-gray-50 transition-all duration-300 font-medium">
                                <i class="fas fa-sort text-[#ed292a]"></i>
                                <span class="text-[#1c1c1c]">Sắp xếp theo</span>
                                <i class="fas fa-chevron-down text-sm text-gray-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-20">
                                @php
                                    $sortOptions = [
                                        'latest' => ['label' => 'Mới nhất', 'icon' => 'fas fa-clock'],
                                        'popular' => ['label' => 'Phổ biến nhất', 'icon' => 'fas fa-fire'],
                                        'rating' => ['label' => 'Đánh giá cao nhất', 'icon' => 'fas fa-star'],
                                        'price_low' => ['label' => 'Giá thấp đến cao', 'icon' => 'fas fa-arrow-up'],
                                        'price_high' => ['label' => 'Giá cao đến thấp', 'icon' => 'fas fa-arrow-down']
                                    ];
                                @endphp

                                @foreach($sortOptions as $value => $option)
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
                                       class="flex items-center px-4 py-3 text-sm hover:bg-gray-50 transition-colors {{ request('sort', 'latest') == $value ? 'bg-[#ed292a]/10 text-[#ed292a] border-r-4 border-[#ed292a]' : 'text-gray-700' }}">
                                        <i class="{{ $option['icon'] }} mr-3 w-4"></i>
                                        {{ $option['label'] }}
                                        @if(request('sort', 'latest') == $value)
                                            <i class="fas fa-check ml-auto text-[#ed292a]"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Course Grid -->
                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 font-quicksand">
                            @foreach($courses as $course)
                                <div class="group p-1.5 bg-white rounded-[30px] shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-200 hover:border-[#ed292a]/20 hover:-translate-y-2 flex flex-col h-full">
                                    <!-- Course Thumbnail -->
                                    <div class="relative overflow-hidden">
                                        <a href="{{ route('courses.show', $course->slug) }}">
                                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x225?text=Course+Image' }}"
                                                 alt="{{ $course->title }}"
                                                 class="w-full rounded-3xl h-52 object-cover transition-transform duration-500">
                                        </a>

                                        <!-- Level Badge -->
                                        <div class="absolute top-3 left-3">
                                            @php
                                                $levelConfig = [
                                                    'beginner' => ['bg' => 'bg-white', 'text' => 'text-[#1c1c1c]', 'icon' => 'fas fa-seedling'],
                                                    'intermediate' => ['bg' => 'bg-white', 'text' => 'text-[#1c1c1c]', 'icon' => 'fas fa-tree'],
                                                    'advanced' => ['bg' => 'bg-white', 'text' => 'text-[#1c1c1c]', 'icon' => 'fas fa-mountain']
                                                ];
                                                $levelLabels = [
                                                    'beginner' => 'Cơ bản',
                                                    'intermediate' => 'Trung cấp',
                                                    'advanced' => 'Nâng cao'
                                                ];
                                                $config = $levelConfig[$course->level] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fas fa-book'];
                                            @endphp
                                            <span class="px-3 py-2 rounded-xl text-xs font-bold shadow-lg {{ $config['bg'] }} {{ $config['text'] }}">
                            <i class="{{ $config['icon'] }} mr-1"></i>
                            {{ $levelLabels[$course->level] ?? ucfirst($course->level) }}
                        </span>
                                        </div>

                                        <!-- Quick Action Button -->
                                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <a href="{{ route('student.courses.show', $course->slug) }}"
                                               class="bg-white text-[#ed292a] w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-[#ed292a] hover:text-white transition-all duration-300">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Enhanced Course Content -->
                                    <div class="p-6 flex flex-col flex-grow">

                                        <!-- Title -->
                                        <h3 class="text-xl font-bold text-[#1c1c1c] mb-4 line-clamp-2 group-hover:text-[#ed292a] transition-colors duration-300">
                                            <a href="{{ route('student.courses.show', $course->slug) }}">
                                                {{ $course->title }}
                                            </a>
                                        </h3>

                                        <!-- Enhanced Course Stats -->
                                        <div class="grid grid-cols-3 gap-4 mb-6 flex-grow">
                                            <div class="text-center">
                                                <div class="flex items-center justify-center text-amber-500 mb-1">
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <p class="text-sm font-bold text-[#1c1c1c]">{{ number_format($course->rating, 1) }}</p>
                                            </div>
                                            <div class="text-center">
                                                <div class="flex items-center justify-center text-[#1c1c1c] mb-1">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <p class="text-sm font-bold text-[#1c1c1c]">{{ number_format($course->enrolled_count) }}</p>
                                            </div>
                                            @if($course->duration_hours)
                                                <div class="text-center">
                                                    <div class="flex items-center justify-center text-[#1c1c1c] mb-1">
                                                        <i class="fas fa-clock"></i>
                                                    </div>
                                                    <p class="text-sm font-bold text-[#1c1c1c]">{{ $course->duration_hours }}h</p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Price Badge - Centered -->
                                        <div class="text-center">
                                            @if($course->is_free)
                                                <a href="{{ route('student.courses.show', $course->slug) }}"
                                                   class="inline-block bg-amber-500 text-white px-6 py-2 rounded-3xl text-[18px] font-medium shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                                    Miễn phí
                                                </a>
                                            @else
                                                <a href="{{ route('student.courses.show', $course->slug) }}"
                                                   class="inline-block bg-[#1c1c1c] text-white px-6 py-2 rounded-3xl text-[18px] font-medium shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                                    {{ number_format($course->discount_price ?: $course->price) }} vnd
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Enhanced Pagination -->
                        <div class="mt-12 flex justify-center">
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-4">
                                @include('components.vietnamese-pagination', ['paginator' => $courses->appends(request()->query())])
                            </div>
                        </div>
                    @else
                        <!-- Enhanced No Results -->
                        <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-200">
                            <div class="w-32 h-32 bg-gradient-to-r from-[#ed292a]/10 to-[#7e0202]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-[#ed292a] text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-[#1c1c1c] mb-3">Không tìm thấy khóa học phù hợp</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                @if(request('search'))
                                    Không có khóa học nào phù hợp với từ khóa "<span class="font-semibold text-[#ed292a]">{{ request('search') }}</span>"
                                @else
                                    Không có khóa học nào phù hợp với bộ lọc hiện tại
                                @endif
                            </p>
                            <a href="{{ route('student.courses.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white rounded-xl hover:shadow-lg hover:shadow-[#ed292a]/25 font-semibold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Xem tất cả khóa học
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Popular Categories -->
    @if(!request()->hasAny(['search', 'category', 'level', 'price_type']))
        <section class="py-20 bg-gradient-to-br from-[#1c1c1c] to-[#2a2a2a] relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-40 h-40 bg-[#ed292a] opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-20 right-20 w-32 h-32 bg-white opacity-5 rounded-full blur-xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-[#ed292a] bg-opacity-20 border border-[#ed292a] border-opacity-30 text-[#ed292a] text-sm font-medium mb-6">
                        <i class="fas fa-fire mr-2"></i>
                        Xu hướng học tập
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        Danh mục <span class="text-[#ed292a]">phổ biến nhất</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        Khám phá các chủ đề học tập được yêu thích và tìm kiếm nhiều nhất bởi cộng đồng học viên
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($categories->take(8) as $category)
                        <a href="{{ route('student.courses.category', $category->slug) }}"
                           class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 text-center hover:bg-white/20 hover:border-[#ed292a]/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#ed292a]/10">

                            <!-- Category Icon/Image -->
                            <div class="relative mb-6">
                                @if($category->image)
                                    <img src="{{ $category->image_url }}"
                                         alt="{{ $category->name }}"
                                         class="w-20 h-20 mx-auto rounded-2xl object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#ed292a]/20 to-[#7e0202]/20 group-hover:from-[#ed292a]/30 group-hover:to-[#7e0202]/30 transition-all duration-300"
                                         style="background: linear-gradient(135deg, {{ $category->color ?? '#ed292a' }}20, {{ $category->color ?? '#7e0202' }}20);">
                                        <i class="fas fa-folder text-3xl group-hover:scale-110 transition-transform duration-300"
                                           style="color: {{ $category->color ?? '#ed292a' }};"></i>
                                    </div>
                                @endif

                                <!-- Floating Badge -->
                                <div class="absolute -top-2 -right-2 bg-[#ed292a] text-white rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold">
                                    {{ $category->courses_count ?? 0 }}
                                </div>
                            </div>

                            <!-- Category Info -->
                            <h3 class="font-bold text-lg text-white group-hover:text-[#ed292a] transition-colors duration-300 mb-2">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-300 group-hover:text-gray-200 transition-colors duration-300">
                                {{ $category->courses_count ?? 0 }} khóa học
                            </p>

                            <!-- Hover Arrow -->
                            <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-arrow-right text-[#ed292a] text-lg"></i>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
@endsection

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

        /* Custom Radio Button Styles */
        input[type="radio"]:checked + div {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            border-color: #ed292a;
        }

        /* Smooth Animations */
        .group {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced Shadows */
        .shadow-glow {
            box-shadow: 0 0 30px rgba(237, 41, 42, 0.15);
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination a {
            background: #f8fafc;
            color: #1c1c1c;
            border: 1px solid #e2e8f0;
        }

        .pagination a:hover {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(237, 41, 42, 0.25);
        }

        .pagination .active span {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            color: white;
            box-shadow: 0 4px 12px rgba(237, 41, 42, 0.25);
        }

        .pagination .disabled span {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        /* Backdrop Blur Support */
        @supports (backdrop-filter: blur(10px)) {
            .backdrop-blur-sm {
                backdrop-filter: blur(4px);
            }
        }

        /* Mobile Responsive Improvements */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                line-height: 1.2;
            }

            .course-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto submit filter form when radio buttons change
        document.querySelectorAll('#filterForm input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                // Add loading state
                const form = document.getElementById('filterForm');
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang tải...';
                submitBtn.disabled = true;

                // Submit form
                form.submit();
            });
        });

        // Smooth scroll for category links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation to course cards
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

        // Observe all course cards
        document.querySelectorAll('.group').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Search input enhancements
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                // Add search suggestions logic here if needed
                searchTimeout = setTimeout(() => {
                    // Implement search suggestions
                }, 300);
            });
        }

        // Enhanced sort dropdown animations
        document.addEventListener('alpine:init', () => {
            Alpine.data('sortDropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            }));
        });
    </script>
@endpush
