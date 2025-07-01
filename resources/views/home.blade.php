@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-[650px] overflow-hidden bg-white">

        <!-- Hero Content -->
        <div class="relative z-10 flex items-center justify-center h-full px-4">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Badge -->
                <div class="inline-flex items-center justify-center mb-6 animate-fade-in-up">
                    <span class="bg-gradient-to-r from-[#7e0202] via-[#ed292a] to-[#ed292a] text-white text-sm font-medium px-4 py-2 rounded-full shadow-lg">
                        Tìm hiểu về Tech.era
                    </span>
                </div>

                <!-- Main Slogan -->
                <h1 class="text-3xl md:text-4xl lg:text-[48px] leading-relaxed mb-6 animate-fade-in-up animation-delay-200" style="font-family: 'CustomTitle', sans-serif; ">
                    <span class="text-gray-800 block mb-1 ">Đột phá kiến thức,</span>
                    <span class="text-gray-800 block mb-1">dẫn dắt kỷ nguyên mới</span>
                    <span class="bg-gradient-to-r from-[#7e0202] via-[#ed292a] to-[#ed292a] bg-clip-text text-transparent block">
                        Tech.era
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-sm md:text-[18px] text-[#1c1c1c] mb-8 animate-fade-in-up animation-delay-400 max-w-xl mx-auto font-normal font-quicksand">
                    Khám phá thế giới công nghệ với những khóa học chất lượng cao<br/>từ các chuyên gia hàng đầu
                </p>

                <!-- CTA Button -->
                <div class="flex justify-center animate-fade-in-up animation-delay-600 font-quicksand">
                    <a href="#courses"
                       class="group bg-gray-900 text-white hover:bg-gray-800
                              font-medium  pl-6 py-[4px] pr-[4px] rounded-[40px] text-[16px] transition-all duration-300
                              hover:shadow-lg flex items-center gap-3">
                        <span>Bắt đầu học</span>
                        <div class="bg-white rounded-[40px] p-[12px] transition-transform duration-300 group-hover:translate-x-0.5">
                            <svg class="w-[16px] h-[16px] text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Divider -->
    <section class="bg-gray-900 py-8 overflow-hidden">
        <div class="whitespace-nowrap">
            <!-- Từ khóa cuộn -->
            <div class="inline-flex animate-scroll items-center gap-8 text-white/80 font-quicksand">
                <!-- Lần hiển thị đầu -->
                <span class="text-lg font-normal">Phát triển Website</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Thiết kế Ứng dụng Di động</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Thiết kế UI/UX</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Khoa học Dữ liệu</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Học Máy</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Điện toán Đám mây</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">An ninh mạng</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">DevOps</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Blockchain</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Trí tuệ Nhân tạo</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <!-- Bản sao để cuộn liên tục -->
                <span class="text-lg font-normal">Phát triển Website</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Thiết kế Ứng dụng Di động</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Thiết kế UI/UX</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Khoa học Dữ liệu</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Học Máy</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Điện toán Đám mây</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">An ninh mạng</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">DevOps</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Blockchain</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>

                <span class="text-lg font-normal">Trí tuệ Nhân tạo</span>
                <div class="w-2 h-2 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full"></div>
            </div>
        </div>
    </section>


    <!-- About Us Section -->
    <section class="relative py-20 overflow-hidden">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#7e0202] via-[#c10708] to-[#ed292a]"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-[#7e0202]/20 to-[#ed292a]/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-gradient-to-l from-[#ed292a]/10 to-[#7e0202]/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Content Column -->
                <div class="space-y-8 fade-in-left">
                    <!-- Badge -->
                    <div class="inline-flex items-center">
                        <span class="bg-black  text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                            Về Tech.era
                        </span>
                    </div>

                    <!-- Title -->
                    <div class="space-y-4">
                        <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight" style="font-family: 'CustomTitle', sans-serif;">
                            Tiên phong
                            <span class="text-white">
                                <br/>giáo dục công nghệ
                            </span>
                        </h2>
                    </div>

                    <!-- Description -->
                    <div class="space-y-6 text-gray-300 text-[16px] leading-relaxed font-quicksand">
                        <p>
                            Chúng tôi là những người đam mê công nghệ, tin rằng giáo dục là chìa khóa để mở ra tương lai.
                            Với kinh nghiệm nhiều năm trong ngành, đội ngũ Tech.era cam kết mang đến những khóa học
                            chất lượng cao nhất.
                        </p>
                        <p>
                            Từ những chuyên gia hàng đầu đến các nhà phát triển tài năng, chúng tôi xây dựng một
                            cộng đồng học tập mạnh mẽ, nơi mọi người có thể phát triển kỹ năng và thực hiện ước mơ
                            công nghệ của mình.
                        </p>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-4">
                        <a href="#team"
                           class="group inline-flex items-center gap-3 bg-white text-gray-900 hover:bg-gray-100
                                  font-medium py-[4px] pl-8 pr-[4px] rounded-[40px] text-[16px] transition-all duration-300
                                  hover:shadow-2xl">
                            <span>Tìm hiểu thêm</span>
                            <div class="bg-gray-900 text-white rounded-[40px] p-[12px] transition-transform duration-300 group-hover:translate-x-0.5">
                                <svg class="w-[16px] h-[16px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Image Column -->
                <div class="relative fade-in-right font-quicksand">
                    <!-- Main Team Image Container -->
                    <div class="relative">
                        <!-- Large Team Photo -->
                        <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl">
                            <img src="https://images2.thanhnien.vn/528068263637045248/2023/12/18/anh-1-huyen-tran-1702873758596491079558.jpg"
                                 alt="Team collaboration"
                                 class="w-full h-[400px] object-cover">
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>

                        <!-- Floating Team Cards -->
                        <div class="absolute -top-8 -left-8 z-20 animate-float">
                            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-white/20">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/homepages/quan.png') }}"
                                         alt="Team member"
                                         class="w-12 h-12 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Lương Thế Quân</p>
                                        <p class="text-gray-600 text-xs">Lead Developer</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -right-6 z-20 animate-float-delayed">
                            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-white/20">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/homepages/linh.png') }}"
                                         alt="Team member"
                                         class="w-12 h-12 rounded-full object-cover object-top">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Đặng Hồng Linh</p>
                                        <p class="text-gray-600 text-xs">UX Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div class="absolute top-1/2 -left-12 z-20 animate-pulse-slow">
                            <div class="bg-black text-white rounded-2xl p-6 shadow-2xl">
                                <div class="text-center">
                                    <p class="text-3xl font-bold font-CustomTitle" style="font-family: 'CustomTitle', sans-serif; ">15+</p>
                                    <p class="text-sm opacity-90">Chuyên gia</p>
                                </div>
                            </div>
                        </div>

                        <!-- Background Decoration -->
                        <div class="absolute -inset-3 bg-black/70 rounded-[35px] -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16 fade-in-up">
                <!-- Badge -->
                <div class="inline-flex items-center justify-center mb-6">
                    <span class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                        Khóa học nổi bật
                    </span>
                </div>

                <!-- Title -->
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6" style="font-family: 'CustomTitle', sans-serif;">
                    Khóa học được
                    <span class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] bg-clip-text text-transparent">
                        yêu thích nhất
                    </span>
                </h2>

                <!-- Description -->
                <p class="text-lg text-gray-600 max-w-2xl mx-auto font-quicksand">
                    Khám phá những khóa học được đông đảo học viên lựa chọn và đánh giá cao nhất tại Tech.era
                </p>
            </div>

            <!-- Courses Carousel -->
            <div class="relative fade-in-up max-w-5xl mx-auto font-quicksand" data-delay="200">
                <div class="courses-carousel-container relative overflow-hidden">
                    <div class="courses-carousel flex transition-transform duration-500 ease-in-out" id="coursesCarousel">
                        @foreach($featuredCourses as $index => $course)
                            <div class="course-slide flex-none w-full md:w-1/2 lg:w-1/3 px-3 pb-12">
                                <div class="bg-white rounded-[32px] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group p-2">
                                    <!-- Course Thumbnail -->
                                    <div class="relative w-full aspect-[4/3] overflow-hidden rounded-3xl">
                                        <img src="{{ $course->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                             alt="{{ $course->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                        <!-- Level Badge -->
                                        <div class="absolute top-3 left-3">
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full backdrop-blur-sm
                                                @if($course->level === 'beginner') bg-white text-[#1c1c1c]
                                                @elseif($course->level === 'intermediate') bg-white text-[#1c1c1c]
                                                @else bg-white text-[#1c1c1c] @endif">
                                                @if($course->level === 'beginner') Cơ bản
                                                @elseif($course->level === 'intermediate') Trung cấp
                                                @else Nâng cao @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Course Content -->
                                    <div class="p-5">
                                        <!-- Course Title -->
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#ed292a] transition-colors leading-snug">
                                            {{ $course->title }}
                                        </h3>

                                        <!-- Course Meta -->
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-4 h-4 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                                </div>
                                                <span>{{ $course->duration_hours }}h</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-4 h-4 rounded-full bg-green-100 flex items-center justify-center">
                                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                </div>
                                                <span>{{ $course->enrolled_count }} học viên</span>
                                            </div>
                                        </div>

                                        <!-- Rating -->
                                        <div class="flex items-center gap-2 mb-4">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <div class="w-3.5 h-3.5 {{ $i <= $course->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-full h-full">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    </div>
                                                @endfor
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ number_format($course->rating, 1) }}</span>
                                            <span class="text-sm text-gray-400">({{ $course->reviews_count }})</span>
                                        </div>

                                        <!-- Price and CTA Row -->
                                        <div class="flex items-center justify-between">
                                            <!-- Price -->
                                            <div class="flex items-baseline gap-2">
                                                @if($course->is_free)
                                                    <span class="text-[18px] font-semibold text-[#1c1c1c]">Miễn phí</span>
                                                @else
                                                    @if($course->has_discount)
                                                        <span class="text-[18px] font-semibold text-[#1c1c1c]">
                                                            {{ number_format($course->discount_price, 0, ',', '.') }}đ
                                                        </span>
                                                        <span class="text-sm text-gray-400 line-through">
                                                            {{ number_format($course->price, 0, ',', '.') }}đ
                                                        </span>
                                                    @else
                                                        <span class="text-[18px] font-semibold text-[#1c1c1c]">
                                                            {{ number_format($course->price, 0, ',', '.') }}đ
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- CTA Button -->
                                            <a href="{{ route('student.courses.show', $course->slug) }}"
                                               class="inline-flex items-center gap-2 bg-[#1c1c1c] text-white px-3 py-3 rounded-3xl text-sm font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">

                                                <div class="w-5 h-5">
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-full h-full">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button class="carousel-prev absolute -left-14 top-[45%] -translate-y-1/2 -translate-x-4 bg-[#1c1c1c] rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 z-10 hover:bg-gray-50" id="prevBtn">
                    <svg class="w-6 h-6 text-white hover:text-[#1c1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <button class="carousel-next absolute -right-14 top-[45%] -translate-y-1/2 translate-x-4 bg-[#1c1c1c] rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 z-10 hover:bg-gray-50" id="nextBtn">
                    <svg class="w-6 h-6 text-white hover:text-[#1c1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 gap-2" id="dotsContainer">
                    <!-- Dots will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white font-quicksand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16 fade-in-up">
                <!-- Badge -->
                <div class="inline-flex items-center justify-center mb-6">
                    <span class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                        Phản hồi học viên
                    </span>
                </div>

                <!-- Title -->
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6" style="font-family: 'CustomTitle', sans-serif;">
                    Câu chuyện
                    <span class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] bg-clip-text text-transparent">
                        thành công
                    </span>
                </h2>

                <!-- Description -->
                <p class="text-lg text-gray-600 max-w-2xl mx-auto font-quicksand">
                    Hàng ngàn học viên đã thay đổi cuộc sống và sự nghiệp của họ nhờ các khóa học tại Tech.era
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid lg:grid-cols-2 gap-5 fade-in-up" data-delay="200">

                <!-- Column 1 -->
                <div class="flex flex-col justify-between gap-5">
                    <!-- Testimonial Card 1 -->
                    <div class="testimonial-card h-[350px] bg-[#1c1c1c] border border-gray-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">
                                Khóa học Web Development thay đổi cuộc đời tôi
                            </h3>

                            <!-- Quote Icon -->
                            <div class="mb-6">
                                <svg class="w-10 h-10 text-[#ed292a] opacity-80" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zM22 8c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/>
                                </svg>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-100 leading-relaxed font-quicksand">
                                Sau khi hoàn thành khóa học, tôi đã có thể tự tin ứng tuyển vào các công ty công nghệ lớn.
                                Kiến thức thực tế và dự án thực hành đã giúp tôi làm chủ được kỹ năng lập trình.
                            </p>
                        </div>

                        <!-- Student Info -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="font-semibold text-gray-100">Nguyễn Văn An</p>
                            <p class="text-sm text-gray-200">Frontend Developer tại VNG</p>
                        </div>
                    </div>

                    <!-- Testimonial Card 2 -->
                    <div class="testimonial-card h-[350px] bg-gradient-to-br from-[#ed292a] via-[#7e0202] to-[#7e0202] border border-gray-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">
                                Data Science mở ra cơ hội mới
                            </h3>

                            <!-- Quote Icon -->
                            <div class="mb-6">
                                <svg class="w-10 h-10 text-[#1c1c1c]" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zM22 8c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/>
                                </svg>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-100 leading-relaxed font-quicksand">
                                Từ một người không có nền tảng về lập trình, giờ tôi đã trở thành Data Scientist.
                                Cách giảng dạy dễ hiểu và nhiều bài tập thực hành đã giúp tôi tiến bộ nhanh chóng.
                            </p>
                        </div>

                        <!-- Student Info -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="font-semibold text-gray-100">Trần Thị Mai</p>
                            <p class="text-sm text-gray-200">Data Scientist tại Shopee</p>
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="flex flex-col justify-between gap-5">
                    <!-- Testimonial Card 3 -->
                    <div class="testimonial-card h-[350px] bg-[#1c1c1c] border border-gray-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <h3 class="text-xl font-bold text-white mb-4">
                            UI/UX Design từ con số 0
                        </h3>

                        <!-- Quote Icon -->
                        <div class="mb-6">
                            <svg class="w-10 h-10 text-[#ed292a] opacity-80" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zM22 8c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/>
                            </svg>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-100 leading-relaxed mb-6 font-quicksand">
                            Khóa học UI/UX đã giúp tôi chuyển đổi nghề nghiệp thành công.
                            Từ kế toán, giờ tôi là UX Designer tại một startup. Giáo trình cập nhật và thực tế.
                        </p>

                        <!-- Student Info -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="font-semibold text-gray-100">Lê Thị Hương</p>
                            <p class="text-sm text-gray-200">UX Designer tại Tiki</p>
                        </div>
                    </div>

                    <!-- Bottom Row with 2 cards side by side -->
                    <div class="grid md:grid-cols-2 gap-5">
                        <!-- Testimonial Card 4 -->
                        <div class="testimonial-card h-[350px] bg-[#1c1c1c] border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between ">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-3">
                                    Mobile App tuyệt vời
                                </h3>

                                <!-- Quote Icon -->
                                <div class="mb-4">
                                    <svg class="w-8 h-8 text-[#ed292a] opacity-80" fill="currentColor" viewBox="0 0 32 32">
                                        <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zM22 8c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/>
                                    </svg>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-100 leading-relaxed font-quicksand text-sm">
                                    Khóa học React Native giúp tôi phát triển app đầu tiên và kiếm được thu nhập ổn định.
                                </p>
                            </div>

                            <!-- Student Info -->
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="font-semibold text-gray-100 text-sm">Phạm Minh Đức</p>
                                <p class="text-xs text-gray-200">Mobile Developer</p>
                            </div>
                        </div>

                        <!-- Testimonial Card 5 -->
                        <div class="testimonial-card h-[350px] bg-[#1c1c1c] border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between ">
                            <h3 class="text-lg font-bold text-white mb-3">
                                AI/ML thực tế
                            </h3>

                            <!-- Quote Icon -->
                            <div class="mb-4">
                                <svg class="w-8 h-8 text-[#ed292a] opacity-80" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zM22 8c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/>
                                </svg>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-100 leading-relaxed mb-4 font-quicksand text-sm">
                                Khóa Machine Learning đã trang bị cho tôi kiến thức để làm việc với các dự án AI thực tế.
                            </p>

                            <!-- Student Info -->
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="font-semibold text-gray-100 text-sm">Hoàng Văn Tùng</p>
                                <p class="text-xs text-gray-200">AI Engineer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Custom Styles -->
    <style>
        @font-face {
            font-family: 'CustomTitle';
            src: url('{{ asset("assets/fonts/title2.otf") }}') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes blob-morph {
            0%, 100% {
                transform: rotate(12deg) scale(1);
            }
            33% {
                transform: rotate(8deg) scale(1.1);
            }
            66% {
                transform: rotate(16deg) scale(0.95);
            }
        }

        @keyframes blob-morph-delayed {
            0%, 100% {
                transform: rotate(-12deg) scale(1);
            }
            33% {
                transform: rotate(-8deg) scale(0.95);
            }
            66% {
                transform: rotate(-16deg) scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out forwards;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .text-3xl {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .text-3xl {
                font-size: 1.5rem;
            }
        }
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll {
            animation: scroll 30s linear infinite;
        }

        /* Pause animation on hover */
        .animate-scroll:hover {
            animation-play-state: paused;
        }
        @keyframes fade-in-left {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in-right {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes float-delayed {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-fade-in-left {
            animation: fade-in-left 1s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fade-in-right 1s ease-out 0.3s forwards;
        }

        /* Initial hidden state */
        .fade-in-left, .fade-in-right {
            opacity: 0;
        }

        .fade-in-left {
            transform: translateX(-50px);
        }

        .fade-in-right {
            transform: translateX(50px);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float-delayed 3s ease-in-out infinite 1.5s;
        }

        .animate-pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .absolute.-left-12 {
                left: -2rem;
            }
            .absolute.-right-6 {
                right: -1rem;
            }
        }

        @media (max-width: 768px) {
            .absolute.-top-8.-left-8 {
                top: -1rem;
                left: -1rem;
            }
            .absolute.-bottom-6.-right-6 {
                bottom: -1rem;
                right: -1rem;
            }
        }
        /* Line clamp utility */
        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Carousel specific styles */
        .courses-carousel-container {
            margin: 0 -12px;
        }

        .course-slide {
            min-width: 0;
        }

        /* Aspect ratio for thumbnails */
        .aspect-\[4\/3\] {
            aspect-ratio: 4 / 3;
        }

        /* Dots styles */
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: linear-gradient(to right, #7e0202, #ed292a);
            transform: scale(1.2);
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .carousel-prev, .carousel-next {
                display: none;
            }
        }

        /* Course card improvements */
        .course-slide .group {
            height: fit-content;
        }

        /* Better shadow visibility */
        .course-slide .bg-white {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .course-slide .bg-white:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Fade in animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
        }

        .fade-in-up.animated {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile responsiveness for course cards */
        @media (max-width: 768px) {
            .course-slide .p-5 {
                padding: 1rem;
            }

            .course-slide h3 {
                font-size: 1rem;
                line-height: 1.4;
            }
        }
        /* Testimonial Card Hover Effects */
        .testimonial-card {
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(240, 43, 43, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .testimonial-card:hover::before {
            left: 100%;
        }

        /* Animation Classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
        }

        .fade-in-up.animated {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .testimonial-card {
                padding: 1.5rem;
            }

            .testimonial-card h3 {
                font-size: 1.125rem;
            }
        }

        /* Staggered animation for cards */
        .testimonial-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .testimonial-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .testimonial-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .testimonial-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .testimonial-card:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>
    <script>
        // Intersection Observer for scroll-triggered animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (entry.target.classList.contains('fade-in-left')) {
                            entry.target.classList.add('animate-fade-in-left');
                        }
                        if (entry.target.classList.contains('fade-in-right')) {
                            entry.target.classList.add('animate-fade-in-right');
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe elements
            document.querySelectorAll('.fade-in-left, .fade-in-right').forEach(el => {
                observer.observe(el);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('animated');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });

            // Carousel functionality
            const carousel = document.getElementById('coursesCarousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('dotsContainer');

            if (!carousel) return;

            const slides = carousel.children;
            const totalSlides = slides.length;
            let currentIndex = 0;
            let slidesToShow = 3;

            // Update slides to show based on screen size
            function updateSlidesToShow() {
                if (window.innerWidth < 768) {
                    slidesToShow = 1;
                } else if (window.innerWidth < 1024) {
                    slidesToShow = 2;
                } else {
                    slidesToShow = 3;
                }

                // Calculate max index
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                if (currentIndex > maxIndex) {
                    currentIndex = maxIndex;
                }

                updateCarousel();
                generateDots();
            }

            // Generate dots
            function generateDots() {
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                const dotsCount = maxIndex + 1;

                dotsContainer.innerHTML = '';
                for (let i = 0; i <= maxIndex; i++) {
                    const dot = document.createElement('div');
                    dot.className = `dot ${i === currentIndex ? 'active' : ''}`;
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
            }

            // Update carousel position
            function updateCarousel() {
                const slideWidth = 100 / slidesToShow;
                const translateX = -(currentIndex * slideWidth);
                carousel.style.transform = `translateX(${translateX}%)`;

                // Update dots
                const dots = dotsContainer.children;
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.toggle('active', i === currentIndex);
                }
            }

            // Go to specific slide
            function goToSlide(index) {
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                currentIndex = Math.max(0, Math.min(index, maxIndex));
                updateCarousel();
            }

            // Next slide
            function nextSlide() {
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;
                updateCarousel();
            }

            // Previous slide
            function prevSlide() {
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;
                updateCarousel();
            }

            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);
            window.addEventListener('resize', updateSlidesToShow);

            // Touch/swipe support
            let startX = 0;
            let isDragging = false;

            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
            });

            carousel.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            carousel.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;

                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;

                if (Math.abs(diffX) > 50) {
                    if (diffX > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
            });

            // Initialize
            updateSlidesToShow();
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('animated');

                            // Add staggered animation to testimonial cards
                            const cards = entry.target.querySelectorAll('.testimonial-card');
                            cards.forEach((card, index) => {
                                setTimeout(() => {
                                    card.style.opacity = '0';
                                    card.style.transform = 'translateY(30px)';
                                    card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s forwards`;
                                }, index * 100);
                            });
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endsection
