@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="min-h-screen relative flex items-center justify-center p-4 login-background py-32">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/backgrounds/login.jpg') }}');">
            <!-- Dark overlay for better readability -->
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Background Pattern Overlay -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 20px 20px;"></div>
        </div>

        <!-- Login Container -->
        <div class="relative w-full max-w-md">
            <!-- Decorative Elements -->
            <div class="absolute -top-10 -left-10 w-20 h-20 bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full opacity-20 blur-xl"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-full opacity-10 blur-2xl"></div>

            <!-- Main Card -->
            <div class="bg-[#1c1c1c] border border-white/10 rounded-2xl shadow-2xl p-8 relative overflow-hidden">
                <!-- Top Border Accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#7e0202] via-[#ed292a] to-[#7e0202]"></div>

                <!-- Header -->
                <div class="text-center mb-8">

                    <h2 class="text-3xl font-bold text-white mb-2 tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">Chào mừng trở lại</h2>
                    <p class="text-gray-100">Đăng nhập để tiếp tục hành trình học tập</p>
                </div>

                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-400 text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-300">
                            Địa chỉ email
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
                                   class="w-full pl-10 pr-4 py-2 text-sm bg-white/5 border border-white/20 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-200 @error('email') border-red-500/50 @enderror"
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

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">
                            Mật khẩu
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
                                   placeholder="Nhập mật khẩu"
                                   required>
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300 transition-colors duration-200">
                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="remember"
                                   id="remember"
                                   class="w-4 h-4 text-[#ed292a] bg-white/5 border-white/20 rounded focus:ring-[#ed292a] focus:ring-2">
                            <span class="ml-2 text-sm text-gray-300">Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-[#ed292a] hover:text-[#7e0202] transition-colors duration-200 font-medium">
                            Quên mật khẩu?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full flex items-center justify-center py-3 px-4 bg-gradient-to-r from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] text-white font-medium rounded-xl shadow-lg shadow-[#ed292a]/25 hover:shadow-[#ed292a]/40 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:ring-offset-2 focus:ring-offset-[#1c1c1c] transition-all duration-200 transform hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Đăng nhập
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-[#1c1c1c] text-gray-400">Hoặc</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-200 text-sm">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}"
                           class="font-medium text-[#ed292a] hover:text-[#7e0202] transition-colors duration-200 ml-1">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </div>

            <!-- Bottom Accent -->
            <div class="mt-8 text-center">
                <p class="text-gray-300 text-xs">
                    © 2024 LMS Platform. Nền tảng học trực tuyến hàng đầu.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

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

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effects to inputs
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-[1.02]');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-[1.02]');
                });
            });
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
    </style>
@endsection
