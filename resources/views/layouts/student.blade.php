<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LMS - Hệ thống học tập trực tuyến')</title>
    <meta name="description" content="@yield('description', 'Hệ thống học tập trực tuyến với nhiều khóa học chất lượng cao')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-gray-50">
<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">LMS</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('student.courses.index') }}"
                   class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('student.courses.*') ? 'text-blue-600' : '' }}">
                    Khóa học
                </a>

                @auth
                    <a href="{{ route('student.dashboard') }}"
                       class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('student.dashboard') ? 'text-blue-600' : '' }}">
                        Học tập của tôi
                    </a>
                @endauth
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex flex-1 max-w-lg mx-8">
                <form action="{{ route('student.courses.index') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm khóa học..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-blue-600 font-medium">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
                        Đăng ký
                    </a>
                @else
                    <!-- Notification -->
                    <button class="relative p-2 text-gray-600 hover:text-blue-600">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="w-8 h-8 rounded-full">
                            <span class="hidden md:block font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">

                            <a href="{{ route('student.dashboard') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Hồ sơ của tôi
                            </a>

                            <a href="{{ route('student.dashboard') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-book mr-2"></i>Khóa học của tôi
                            </a>

                            <div class="border-t border-gray-100"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold">LMS</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Hệ thống học tập trực tuyến với nhiều khóa học chất lượng cao,
                    giúp bạn phát triển kỹ năng và kiến thức một cách hiệu quả.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Liên kết</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('student.courses.index') }}" class="text-gray-400 hover:text-white">Khóa học</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Về chúng tôi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Liên hệ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Hỗ trợ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Hỗ trợ</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Trung tâm trợ giúp</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Điều khoản</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Chính sách</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} LMS. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@stack('scripts')
</body>
</html>
