<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tech.era')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1c1c1c;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ffffff;
            border-radius: 4px;
            border: none;
            transition: all 0.3s ease;
        }

        @font-face {
            font-family: 'CustomTitle';
            src: url('{{ asset("assets/fonts/title2.otf") }}') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        [x-cloak] { display: none !important; }

        .font-quicksand {
            font-family: 'Quicksand', sans-serif;
        }

        /* Floating Navbar Animation */
        .navbar-floating {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }

        .navbar-visible {
            transform: translateY(0);
            opacity: 1;
        }

        /* Gradient Animation for Register Button */
        .gradient-button {
            background: linear-gradient(45deg, #7e0202, #ef2b2c, #ef2b2c, #7e0202);
            background-size: 300% 300%;
            animation: gradientShift 3s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .gradient-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: left 0.5s;
        }

        .gradient-button:hover::before {
            left: 100%;
        }

        @keyframes gradientShift {
            0% { background-position: 0 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0 50%; }
        }

        /* Navigation Items Hover Effect */
        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-item:hover::after,
        .nav-item.active::after {
            width: 100%;
        }

        /* Logo Animation */
        .logo-container {
            transition: transform 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        /* Backdrop Blur Effect */
        .backdrop-blur-navbar {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
<!-- Floating Navbar -->
<nav
    x-data="navbar()"
    x-init="init()"
    x-bind:class="{ 'navbar-hidden': hidden, 'navbar-visible': !hidden }"
    class="navbar-floating fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-[1440px] px-4 font-quicksand"
>
    <div class="backdrop-blur-navbar bg-black/90 border-2 border-white/80 rounded-[100px] shadow-2xl">
        <div class="flex items-center px-6 py-2">
            <!-- Logo -->
            <div class="logo-container w-1/4">
                <a href="{{ route('home') }}" class="block">
                    <img
                        src="{{ asset('assets/logos/techera.png') }}"
                        alt="LMS Logo"
                        class="h-10 w-auto object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                    >
                    <div class="hidden text-white font-bold text-xl">
                        LMS
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center justify-center w-1/2">
                <div class="flex items-center text-[16px] bg-white/20 backdrop-blur-sm rounded-3xl px-1 py-1 border border-white/25">
                    <a href="{{ route('home') }}"
                       class="nav-item px-5 py-2 rounded-3xl transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white text-black' : 'text-white' }}">
                        Trang chủ
                    </a>
                    <a href="{{ route('courses.index') }}"
                       class="nav-item px-5 py-2 rounded-3xl transition-all duration-300 {{ request()->routeIs('courses') ? 'bg-white text-black' : 'text-white' }}">
                        Khóa học
                    </a>
                </div>
            </div>

            <!-- Desktop Auth Buttons -->
            <div class="hidden lg:flex items-center justify-end space-x-3 w-1/4">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 text-text-[15px] text-white/90 hover:text-white transition-all duration-300 hover:scale-105">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}"
                       class="gradient-button text-[15px] px-6 py-2 text-white rounded-3xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Đăng ký
                    </a>
                @else
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-3 px-4 py-2.5 text-white/90 hover:text-white hover:bg-white/10 backdrop-blur-sm rounded-full border border-transparent hover:border-white/20 transition-all duration-300 group">
                            <!-- Avatar -->
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full mr-2">

                            <!-- Name -->
                            <span class="font-medium text-sm">{{ Auth::user()->name }}</span>
                            <!-- Chevron -->
                            <svg class="w-4 h-4 transition-transform duration-300 opacity-70 group-hover:opacity-100"
                                 x-bind:class="{ 'rotate-180': open }"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-1 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-1 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-100/50 py-2 z-50">

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.statistics') }}"
                                   class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50/80 transition-colors duration-200 group">
                                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-100 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-sm">Quản trị</span>
                                </a>
                            @endif

                            <a href="{{ route('student.dashboard') }}"
                               class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50/80 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-100 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>

                            <a href="{{ route('profile.show') }}"
                               class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50/80 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-100 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-sm">Hồ sơ</span>
                            </a>

                            <a href="{{ route('certificates.index') }}"
                               class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50/80 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-amber-100 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-sm">Chứng chỉ</span>
                            </a>

                            <!-- Divider -->
                            <div class="my-2 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mx-4"></div>

                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center px-5 py-3 text-red-600 hover:bg-red-50/80 transition-colors duration-200 group">
                                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-100 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-sm">Đăng xuất</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{--<!-- ChatBot Component - Hiển thị trên tất cả trang -->--}}
{{--@auth--}}
{{--    @include('components.chatbot')--}}
{{--@else--}}
{{--    <!-- ChatBot cho guest users -->--}}
{{--    @include('components.chatbot-guest')--}}
{{--@endauth--}}
<!-- Main Content -->
<main class="font-quicksand">
    @yield('content')
</main>

<!-- Footer -->
<!-- Footer Component -->
<!-- Footer Component -->
<footer style="background-color: #1c1c1c" class="text-white font-quicksand">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Company Info -->
                <div class="lg:col-span-1 space-y-6">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-4">Tech.era</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Nền tảng học trực tuyến hàng đầu, mang đến trải nghiệm học tập chất lượng cao với các khóa học đa dạng.
                        </p>
                    </div>

                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-white">Liên kết nhanh</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Trang chủ</a></li>
                        <li><a href="/courses" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Khóa học</a></li>
                        <li><a href="/dashboard" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Dashboard</a></li>
                        <li><a href="/certificates/verify" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Xác thực chứng chỉ</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-white">Liên hệ</h4>
                    <div class="space-y-3">
                        <p class="text-gray-300 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            techera@gmail.com
                        </p>
                        <p class="text-gray-300 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +84 123 456 789
                        </p>
                        <p class="text-gray-300 text-sm flex items-start">
                            <svg class="w-4 h-4 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            250 Trinh Dinh Cuu, Hoang Mai, Ha Noi
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-gray-400 text-sm">
                    © 2024 Techera. Bảo lưu mọi quyền.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Chính sách bảo mật</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Điều khoản sử dụng</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Hỗ trợ</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Action Buttons -->
<div class="fixed bottom-6 right-6 z-50" x-data="floatingButtons()">
    <!-- Back to Top Button -->
    <button @click="scrollToTop()"
            x-show="showBackToTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-1 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-1 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
            class="w-14 h-14 bg-gray-800 hover:bg-gray-700 rounded-2xl shadow-xl hover:shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-105 group backdrop-blur-sm border border-gray-600">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
        <div class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            Lên đầu trang
        </div>
    </button>
</div>

<!-- Scripts -->
<script>
    // CSRF Token setup
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
    };

    // Navbar Alpine.js Component
    function navbar() {
        return {
            hidden: false,
            lastScrollY: 0,
            mobileMenuOpen: false,

            init() {
                this.lastScrollY = window.scrollY;

                window.addEventListener('scroll', () => {
                    const currentScrollY = window.scrollY;

                    // Hide navbar when scrolling down, show when scrolling up
                    if (currentScrollY > this.lastScrollY && currentScrollY > 100) {
                        this.hidden = true;
                    } else if (currentScrollY < this.lastScrollY || currentScrollY <= 100) {
                        this.hidden = false;
                    }

                    this.lastScrollY = currentScrollY;
                });
            }
        }
    }

    // Floating Buttons Alpine.js Component
    function floatingButtons() {
        return {
            contactOpen: false,
            showBackToTop: false,

            init() {
                // Show/hide back to top button based on scroll position
                window.addEventListener('scroll', () => {
                    this.showBackToTop = window.scrollY > 400;
                });
            },

            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    }
</script>

@stack('scripts')
</body>
</html>
