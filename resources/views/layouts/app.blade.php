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
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
<!-- Header -->
<header class="bg-white shadow-sm border-b">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">LMS</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition-colors">
                    Trang chủ
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                    Khóa học
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                    Giới thiệu
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                    Liên hệ
                </a>
            </div>

            <!-- Auth Links -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center text-gray-700 hover:text-gray-900">
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down ml-1 text-sm"></i>
                        </button>

                        <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.statistics') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Admin Panel
                                </a>
                            @endif
                            @if(auth()->user()->role === 'student')
                                <a href="{{ route('student.courses.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-book mr-2"></i>Khóa học của tôi
                                </a>
                            @endif
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Hồ sơ
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Cài đặt
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition-colors">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        Đăng ký
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">
                    Trang chủ
                </a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:text-blue-600">
                    Khóa học
                </a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:text-blue-600">
                    Giới thiệu
                </a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:text-blue-600">
                    Liên hệ
                </a>
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-blue-600 font-medium">
                        Đăng ký
                    </a>
                @endguest
            </div>
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="min-h-screen">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </span>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold">LMS</span>
                </div>
                <p class="text-gray-300 mb-4">
                    Hệ thống quản lý học tập trực tuyến hiện đại, giúp bạn học tập hiệu quả và thuận tiện.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Liên kết</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Về chúng tôi</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Khóa học</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Giảng viên</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Liên hệ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Hỗ trợ</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Trung tâm trợ giúp</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Chính sách bảo mật</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; 2024 LMS. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('userMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        if (!event.target.closest('[onclick="toggleUserMenu()"]')) {
            userMenu?.classList.add('hidden');
        }

        if (!event.target.closest('[onclick="toggleMobileMenu()"]')) {
            mobileMenu?.classList.add('hidden');
        }
    });

    // CSRF Token setup
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
    };
</script>

@stack('scripts')
</body>
</html>
