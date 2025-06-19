<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') - LMS</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .auth-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .pattern-bg {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0);
            background-size: 20px 20px;
        }
    </style>

    @stack('styles')
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-4">
<!-- Background Pattern -->
<div class="absolute inset-0 pattern-bg opacity-30"></div>

<!-- Auth Container -->
<div class="w-full max-w-md relative z-10">
    <!-- Logo -->
    <div class="text-center mb-8">
        <a href="{{ url('/') }}" class="inline-flex items-center">
            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
            </div>
            <span class="text-3xl font-bold text-white">LMS</span>
        </a>
        <p class="text-white/80 mt-2">Hệ thống quản lý học tập</p>
    </div>

    <!-- Auth Card -->
    <div class="bg-white rounded-lg shadow-2xl p-8">
        <!-- Page Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                @yield('auth-title', 'Xác thực')
            </h2>
            <p class="text-gray-600 mt-2">
                @yield('auth-subtitle', 'Vui lòng đăng nhập để tiếp tục')
            </p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                 role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('status'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative"
                 role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-cloak
                 class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <div class="font-medium">Có lỗi xảy ra:</div>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Auth Form Content -->
        @yield('content')

        <!-- Auth Links -->
        <div class="mt-6 text-center">
            @yield('auth-links')
        </div>
    </div>

    <!-- Additional Links -->
    <div class="text-center mt-6">
        <a href="{{ url('/') }}" class="text-white/80 hover:text-white transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại trang chủ
        </a>
    </div>
</div>

<!-- Floating Elements -->
<div class="fixed top-10 left-10 w-20 h-20 bg-white/10 rounded-full glass-effect animate-pulse"></div>
<div class="fixed bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full glass-effect animate-bounce"></div>
<div class="fixed top-1/3 right-20 w-8 h-8 bg-white/10 rounded-full glass-effect"></div>
<div class="fixed bottom-1/3 left-20 w-12 h-12 bg-white/5 rounded-full glass-effect"></div>

<!-- Scripts -->
<script>
    // Form validation helpers
    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        if (!field) return;

        const errorElement = field.parentNode.querySelector('.error-message');

        field.classList.add('border-red-500');
        field.classList.remove('border-gray-300');

        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function clearFieldError(fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return;

        const errorElement = field.parentNode.querySelector('.error-message');

        field.classList.remove('border-red-500');
        field.classList.add('border-gray-300');

        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    // Password strength indicator
    function checkPasswordStrength(password) {
        let strength = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        Object.values(checks).forEach(check => {
            if (check) strength++;
        });

        return {
            score: strength,
            checks: checks,
            level: strength < 2 ? 'weak' : strength < 4 ? 'medium' : 'strong'
        };
    }

    // Auto-hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(message => {
                if (message.style.display !== 'none') {
                    message.style.transition = 'opacity 0.3s, transform 0.3s';
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 300);
                }
            });
        }, 5000);
    });

    // CSRF Token setup for AJAX requests
    if (typeof window.Laravel === 'undefined') {
        window.Laravel = {};
    }
    window.Laravel.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

@stack('scripts')
</body>
</html>
