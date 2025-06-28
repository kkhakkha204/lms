<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - LMS</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1c1c1c',
                        accent: '#7e0202',
                        danger: '#ed292a',
                        neumorphism: {
                            light: '#f0f0f0',
                            shadow: '#d1d9e6',
                            inset: '#ffffff'
                        }
                    },
                    boxShadow: {
                        'neumorph': '8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff',
                        'neumorph-inset': 'inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff',
                        'neumorph-sm': '4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff',
                        'neumorph-dark': '8px 8px 16px #0a0a0a, -8px -8px 16px #2e2e2e',
                        'neumorph-dark-inset': 'inset 8px 8px 16px #0a0a0a, inset -8px -8px 16px #2e2e2e'
                    }
                }
            }
        }
    </script>

    <style>
        @font-face {
            font-family: 'CustomTitle';
            src: url('{{ asset("assets/fonts/title2.otf") }}') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        .font-quicksand {
            font-family: 'Quicksand', sans-serif;
        }
        [x-cloak] { display: none !important; }

        .sidebar-link.active {
            background: linear-gradient(145deg, #7e0202, #ed292a);
            color: white;
            box-shadow: inset 4px 4px 8px rgba(0,0,0,0.3), inset -4px -4px 8px rgba(255,255,255,0.1);
        }

        .neumorph-button {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #f0f0f0;
            box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
        }

        .neumorph-button:hover {
            transform: translateY(-2px);
            box-shadow: 12px 12px 20px #d1d9e6, -12px -12px 20px #ffffff;
        }

        .neumorph-button:active {
            transform: translateY(0);
            box-shadow: inset 4px 4px 8px #d1d9e6, inset -4px -4px 8px #ffffff;
        }

        .sidebar-toggle {
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff;
        }

        .sidebar-toggle:hover {
            box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
        }

        .logo-glow {
            text-shadow: 0 0 20px rgba(126, 2, 2, 0.5);
        }

        .slide-enter {
            transform: translateX(-100%);
        }

        .slide-enter-active {
            transform: translateX(0);
            transition: transform 0.3s ease-out;
        }

        .slide-leave-active {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in;
        }

        .content-shift {
            transition: margin-left 0.3s ease-out;
        }

        .gradient-text {
            background: linear-gradient(145deg, #7e0202, #ed292a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .notification-badge {
            background: linear-gradient(145deg, #ed292a, #7e0202);
            box-shadow: 0 0 10px rgba(237, 41, 42, 0.5);
        }

        .user-avatar {
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff;
        }

        .dropdown-menu {
            background: #f0f0f0;
            box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
            backdrop-filter: blur(10px);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
<div class="min-h-screen">
    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="h-full bg-gradient-to-b from-gray-50 to-gray-100 shadow-neumorph">
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent to-danger shadow-neumorph-sm flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-bold gradient-text" style="font-family: 'CustomTitle', sans-serif; ">Tech.era</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.statistics') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Thống kê</span>
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('admin.categories.index') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Danh mục khóa học</span>
                    </a>

                    <!-- Courses -->
                    <a href="{{ route('admin.courses.index') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                        <i class="fas fa-book w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Khóa học</span>
                    </a>

                    <!-- Payments -->
                    <a href="{{ route('admin.payments.index') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Thanh toán</span>
                    </a>

                    <!-- Users -->
                    <a href="{{ route('admin.users.index') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Người dùng</span>
                    </a>

                    <!-- Reviews -->
                    <a href="{{ route('admin.reviews.index') }}"
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-neumorph-sm group {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star w-5 h-5 mr-3 group-hover:text-accent transition-colors"></i>
                        <span class="font-medium">Đánh giá</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-full p-4" x-data="{ dropdownOpen: false }">
                <div class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                            class="w-full flex items-center px-4 py-3 bg-white rounded-xl shadow-neumorph-sm hover:shadow-neumorph transition-all duration-200">
                        <div class="user-avatar w-8 h-8 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <i class="fas fa-chevron-up transition-transform" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="dropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         @click.away="dropdownOpen = false"
                         class="dropdown-menu absolute bottom-full mb-2 w-full rounded-xl py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg mx-2 transition-colors">
                            <i class="fas fa-user-cog mr-2"></i>Hồ sơ
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg mx-2 transition-colors">
                            <i class="fas fa-cog mr-2"></i>Cài đặt
                        </a>
                        <hr class="my-2 mx-2 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-danger hover:bg-red-50 rounded-lg mx-2 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class= "content-shift font-quicksand" :class="sidebarOpen ? 'ml-64' : 'ml-0'">
        <!-- Top Header -->
        <header class="bg-white shadow-neumorph-sm h-16 flex items-center justify-between px-6 sticky top-0 z-40">
            <!-- Sidebar Toggle & Title -->
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="sidebar-toggle w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200">
                    <i class="fas fa-bars text-gray-600 text-lg"></i>
                </button>

            </div>

            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative" x-data="{ notificationOpen: false }">
                    <button @click="notificationOpen = !notificationOpen"
                            class="neumorph-button w-10 h-10 rounded-xl flex items-center justify-center relative">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span class="notification-badge absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs text-white font-bold">3</span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notificationOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         @click.away="notificationOpen = false"
                         class="dropdown-menu absolute right-0 mt-2 w-80 rounded-xl py-2 max-h-96 overflow-y-auto">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-800">Thông báo</h3>
                        </div>
                        <div class="py-2">
                            <a href="#" class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-accent rounded-full mt-2 flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-800">Đơn hàng mới</p>
                                        <p class="text-xs text-gray-500">Có đơn hàng mới cần xử lý</p>
                                        <p class="text-xs text-gray-400 mt-1">2 phút trước</p>
                                    </div>
                                </div>
                            </a>
                            <!-- More notifications... -->
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <button class="neumorph-button w-10 h-10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus text-gray-600"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-6">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl shadow-neumorph-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl shadow-neumorph-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-700 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/admin/user-management.js') }}"></script>
<script>
    // CSRF Token setup for AJAX
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
    };

    // Setup AJAX headers
    if (window.fetch) {
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            options.headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...options.headers
            };
            return originalFetch(url, options);
        };
    }

    // Sidebar persistence
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            open: localStorage.getItem('sidebarOpen') !== 'false',
            toggle() {
                this.open = !this.open;
                localStorage.setItem('sidebarOpen', this.open);
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>
