<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LMS - Hệ thống quản lý học tập')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
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
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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

        /* Mobile Menu Animation */
        .mobile-menu {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
    :class="{ 'navbar-hidden': hidden, 'navbar-visible': !hidden }"
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
                <div class="flex items-center text-[16px] bg-white/5 backdrop-blur-sm rounded-3xl px-1 py-1 border border-white/10">
                    <a href="{{ route('home') }}"
                       class="nav-item px-5 py-2 rounded-3xl transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white text-black' : 'text-white' }}">
                        Trang chủ
                    </a>
                    <a href="{{ route('student.courses.index') }}"
                       class="nav-item px-5 py-2 rounded-3xl transition-all duration-300 {{ request()->routeIs('student.courses.*') ? 'bg-white text-black' : 'text-white' }}">
                        Khóa học
                    </a>
                    <a href="#about"
                       class="nav-item px-5 py-2 text-white rounded-3xl transition-all duration-300">
                        Giới thiệu
                    </a>
                    <a href="#contact"
                       class="nav-item px-5 py-2 text-white rounded-3xl transition-all duration-300">
                        Liên hệ
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
                                 :class="{ 'rotate-180': open }"
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

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-white hover:text-gray-300 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              x-show="!mobileMenuOpen" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              x-show="mobileMenuOpen" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-1 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-1 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="lg:hidden border-t border-white/10 bg-black/90 backdrop-blur-sm">
            <div class="px-6 py-4 space-y-3">
                <a href="{{ route('home') }}"
                   class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                    Trang chủ
                </a>
                <a href="{{ route('student.courses.index') }}"
                   class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                    Khóa học
                </a>
                <a href="#about"
                   class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                    Giới thiệu
                </a>
                <a href="#contact"
                   class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                    Liên hệ
                </a>

                @guest
                    <div class="pt-3 border-t border-white/10 space-y-2">
                        <a href="{{ route('login') }}"
                           class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                           class="block gradient-button px-4 py-2 text-white font-medium rounded-lg">
                            Đăng ký
                        </a>
                    </div>
                @else
                    <div class="pt-3 border-t border-white/10 space-y-2">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.statistics') }}"
                               class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                                Quản trị
                            </a>
                        @endif
                        <a href="{{ route('student.dashboard') }}"
                           class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                            Dashboard
                        </a>
                        <a href="{{ route('profile.show') }}"
                           class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                            Hồ sơ
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-300">
                                Đăng xuất
                            </button>
                        </form>
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

{{--<!-- Floating Call to Action Section -->--}}
{{--<div class="relative">--}}
{{--    <div class="absolute -top-52 left-1/2 transform -translate-x-1/2 z-20 w-full max-w-6xl px-4">--}}
{{--        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-3xl shadow-2xl p-8 md:p-12 backdrop-blur-sm border border-white/20">--}}
{{--            <div class="text-center">--}}
{{--                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">--}}
{{--                    Bắt đầu hành trình học tập của bạn--}}
{{--                </h2>--}}
{{--                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">--}}
{{--                    Khám phá hàng nghìn khóa học chất lượng cao và nâng cao kỹ năng của bạn cùng với những chuyên gia hàng đầu--}}
{{--                </p>--}}
{{--                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">--}}
{{--                    <a href="{{ route('student.courses.index') }}"--}}
{{--                       class="px-8 py-4 bg-white text-purple-700 font-semibold rounded-xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300 shadow-lg">--}}
{{--                        Khám phá khóa học--}}
{{--                    </a>--}}
{{--                    <a href="{{ route('register') }}"--}}
{{--                       class="px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-purple-700 transform hover:scale-105 transition-all duration-300">--}}
{{--                        Đăng ký miễn phí--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Decorative Elements -->--}}
{{--            <div class="absolute top-4 left-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>--}}
{{--            <div class="absolute bottom-4 right-4 w-32 h-32 bg-blue-400/20 rounded-full blur-xl"></div>--}}
{{--            <div class="absolute top-1/2 right-8 w-16 h-16 bg-purple-400/20 rounded-full blur-lg"></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Footer -->
<footer class="bg-gray-900 text-white pt-32 pb-12 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-3">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 60px 60px;"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4">
        <!-- Logo Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center mb-6">
                <img
                    src="{{ asset('assets/logos/techera.png') }}"
                    alt="LMS Logo"
                    class="h-16 w-auto object-contain filter brightness-0 invert opacity-90"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                >
                <div class="hidden text-3xl font-bold text-white">
                    LMS
                </div>
            </div>
            <p class="text-gray-400 text-lg max-w-lg mx-auto leading-relaxed">
                Nền tảng học trực tuyến hiện đại - Nơi kiến thức không giới hạn
            </p>
        </div>

        <!-- Minimalist Content -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
            <!-- Quick Links -->
            <div class="text-center">
                <h3 class="text-sm font-medium mb-6 text-gray-300 uppercase tracking-wider">Khám phá</h3>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Trang chủ</a></li>
                    <li><a href="{{ route('student.courses.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Khóa học</a></li>
                    <li><a href="#about" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Giới thiệu</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="text-center">
                <h3 class="text-sm font-medium mb-6 text-gray-300 uppercase tracking-wider">Danh mục</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Công nghệ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Kinh doanh</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Thiết kế</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="text-center">
                <h3 class="text-sm font-medium mb-6 text-gray-300 uppercase tracking-wider">Hỗ trợ</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Trợ giúp</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">Liên hệ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">FAQ</a></li>
                </ul>
            </div>

            <!-- Social -->
            <div class="text-center">
                <h3 class="text-sm font-medium mb-6 text-gray-300 uppercase tracking-wider">Kết nối</h3>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition-all duration-300 group">
                        <span class="text-xs font-bold group-hover:text-white">f</span>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-sky-500 transition-all duration-300 group">
                        <span class="text-xs font-bold group-hover:text-white">t</span>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-700 transition-all duration-300 group">
                        <span class="text-xs font-bold group-hover:text-white">in</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800">
            <div class="text-gray-500 text-sm mb-4 md:mb-0">
                © {{ date('Y') }} LMS. All rights reserved.
            </div>
            <div class="flex space-x-8 text-sm">
                <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors duration-300">Privacy</a>
                <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors duration-300">Terms</a>
                <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors duration-300">Cookies</a>
            </div>
        </div>
    </div>

    <!-- Subtle Decorative Elements -->
    <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-600/3 rounded-full blur-2xl -translate-x-16 translate-y-16"></div>
    <div class="absolute top-0 right-0 w-48 h-48 bg-purple-600/3 rounded-full blur-3xl translate-x-24 -translate-y-24"></div>
</footer>

<!-- Floating Action Buttons -->
<div class="fixed bottom-6 right-6 z-50" x-data="floatingButtons()">
{{--    <!-- Contact Button with Expandable Options -->--}}
{{--    <div class="relative mb-4">--}}
{{--        <!-- Social Media Options -->--}}
{{--        <div x-show="contactOpen"--}}
{{--             x-transition:enter="transition ease-out duration-300"--}}
{{--             x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"--}}
{{--             x-transition:enter-end="opacity-1 transform translate-y-0 scale-100"--}}
{{--             x-transition:leave="transition ease-in duration-200"--}}
{{--             x-transition:leave-start="opacity-1 transform translate-y-0 scale-100"--}}
{{--             x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"--}}
{{--             class="absolute bottom-16 right-0 flex flex-col space-y-3">--}}

{{--            <!-- Zalo -->--}}
{{--            <a href="#"--}}
{{--               class="w-12 h-12 bg-blue-500 hover:bg-blue-600 rounded-2xl shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 group">--}}
{{--                <span class="text-white text-sm font-bold">Z</span>--}}
{{--                <div class="absolute right-14 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">--}}
{{--                    Zalo--}}
{{--                </div>--}}
{{--            </a>--}}

{{--            <!-- Facebook -->--}}
{{--            <a href="#"--}}
{{--               class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 group">--}}
{{--                <span class="text-white text-sm font-bold">f</span>--}}
{{--                <div class="absolute right-14 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">--}}
{{--                    Facebook--}}
{{--                </div>--}}
{{--            </a>--}}

{{--            <!-- Instagram -->--}}
{{--            <a href="#"--}}
{{--               class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-2xl shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 group">--}}
{{--                <span class="text-white text-sm font-bold">ig</span>--}}
{{--                <div class="absolute right-14 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">--}}
{{--                    Instagram--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <!-- Main Contact Button -->--}}
{{--        <button @click="contactOpen = !contactOpen"--}}
{{--                class="w-14 h-14 bg-gray-800 hover:bg-gray-700 rounded-2xl shadow-xl hover:shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-105 group backdrop-blur-sm border border-gray-600">--}}
{{--            <svg class="w-6 h-6 text-white transition-transform duration-300"--}}
{{--                 :class="{ 'rotate-45': contactOpen }"--}}
{{--                 fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>--}}
{{--            </svg>--}}
{{--            <div class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">--}}
{{--                Liên hệ--}}
{{--            </div>--}}
{{--        </button>--}}
{{--    </div>--}}

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
