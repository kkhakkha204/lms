@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div class="min-h-screen relative flex items-center justify-center p-4 py-32 login-background">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/backgrounds/login.jpg') }}');">
            <!-- Dark overlay for better readability -->
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Background Pattern Overlay -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 20px 20px;"></div>
        </div>

        <!-- Register Container -->
        <div class="relative w-full max-w-2xl">
            <!-- Decorative Elements -->
            <div class="absolute -top-10 -left-10 w-24 h-24 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full opacity-20 blur-xl"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-full opacity-10 blur-2xl"></div>

            <!-- Main Card -->
            <div class="bg-[#1c1c1c] border border-white/10 rounded-2xl shadow-2xl p-8 relative overflow-hidden">
                <!-- Top Border Accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#7e0202] via-[#ed292a] to-[#7e0202]"></div>

                <!-- Header with Login Link -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2 tracking-wide" style="font-family: 'CustomTitle', sans-serif;">Tạo tài khoản</h2>
                        <p class="text-gray-100">Tham gia hành trình học tập cùng chúng tôi</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-300 text-sm mb-1">Đã có tài khoản?</p>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-[#ed292a] text-white text-sm font-medium rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4 mr-2 group-hover:text-[#ed292a] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Đăng nhập
                        </a>
                    </div>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name and Email Fields - Same Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-200">
                                Họ và tên <span class="text-[#ed292a]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name') }}"
                                       class="w-full pl-10 pr-4 py-2 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200 @error('name') border-red-500/50 @enderror"
                                       placeholder="Nhập họ và tên"
                                       required>
                            </div>
                            @error('name')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-300">
                                Địa chỉ email <span class="text-[#ed292a]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       class="w-full pl-10 pr-4 py-2 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200 @error('email') border-red-500/50 @enderror"
                                       placeholder="example@email.com"
                                       required>
                            </div>
                            @error('email')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Field - Full Width -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-300">
                            Số điện thoại
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full pl-10 pr-4 py-2 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200"
                                   placeholder="0123456789">
                        </div>
                        @error('phone')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password and Confirmation Fields - Same Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-300">
                                Mật khẩu <span class="text-[#ed292a]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="w-full pl-10 pr-12 py-2 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200 @error('password') border-red-500/50 @enderror"
                                       placeholder="Tối thiểu 8 ký tự"
                                       required>
                                <button type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300 transition-colors duration-200">
                                    <svg id="eye-open-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="eye-closed-1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">
                                Xác nhận mật khẩu <span class="text-[#ed292a]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="w-full pl-10 pr-12 py-2 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200"
                                       placeholder="Nhập lại mật khẩu"
                                       required>
                                <button type="button"
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-300 hover:text-gray-300 transition-colors duration-200">
                                    <svg id="eye-open-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="eye-closed-2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Password Requirements - Compact Version -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-2 text-[#ed292a]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium text-gray-200">Yêu cầu:</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-[#ed292a] text-gray-300 rounded-full mr-2"></div>
                                Tối thiểu 8 ký tự
                            </div>
                            <div class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-[#ed292a] text-gray-300 rounded-full mr-2"></div>
                                Chữ hoa & thường
                            </div>
                            <div class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-[#ed292a] text-gray-300 rounded-full mr-2"></div>
                                Số & ký tự đặc biệt
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full flex items-center justify-center py-3 px-4 bg-gradient-to-r from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] text-white font-medium rounded-xl shadow-lg shadow-[#ed292a]/25 hover:shadow-[#ed292a]/40 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:ring-offset-2 focus:ring-offset-[#1c1c1c] transition-all duration-200 transform hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Tạo tài khoản
                    </button>
                </form>
            </div>

            <!-- Bottom Accent -->
            <div class="mt-8 text-center">
                <p class="text-gray-200 text-xs">
                    © 2024 LMS Platform. Nền tảng học trực tuyến hàng đầu.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeOpen = document.getElementById(fieldId === 'password' ? 'eye-open-1' : 'eye-open-2');
            const eyeClosed = document.getElementById(fieldId === 'password' ? 'eye-closed-1' : 'eye-closed-2');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effects to inputs and textareas
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-[1.02]');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-[1.02]');
                });
            });

            // Password strength indicator (optional enhancement)
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    // Add password strength visual feedback here if needed
                });
            }
        });
    </script>

    <style>
        /* Custom scrollbar for better consistency */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #1c1c1c;
        }
        ::-webkit-scrollbar-thumb {
            background: #ed292a;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #7e0202;
        }

        /* Fallback background in case image fails to load */
        .login-background {
            background: linear-gradient(135deg, #1c1c1c 0%, #2a2a2a 50%, #1c1c1c 100%);
        }

        /* Smooth transitions for form elements */
        input, textarea {
            transition: all 0.2s ease-in-out;
        }

        input:focus, textarea:focus {
            transform: translateY(-1px);
        }
    </style>
@endsection
