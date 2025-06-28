@extends('layouts.app')

@section('title', 'Chỉnh sửa người dùng')
@section('page-title', 'Chỉnh sửa người dùng')

@push('styles')
    <style>
        .neumorphic-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(28, 28, 28, 0.1),
            -8px -8px 16px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .neumorphic-inset {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: inset 4px 4px 8px rgba(28, 28, 28, 0.1),
            inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .neumorphic-button {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.1),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
            transition: all 0.3s ease;
        }

        .neumorphic-button:hover {
            box-shadow: 6px 6px 12px rgba(28, 28, 28, 0.15),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .neumorphic-button:active {
            box-shadow: inset 2px 2px 4px rgba(28, 28, 28, 0.1),
            inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            transform: translateY(0);
        }

        .primary-button {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            color: white;
            box-shadow: 4px 4px 8px rgba(237, 41, 42, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .primary-button:hover {
            background: linear-gradient(135deg, #7e0202, #ed292a);
            box-shadow: 6px 6px 12px rgba(237, 41, 42, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }

        .secondary-button {
            background: linear-gradient(135deg, #1c1c1c, #2d2d2d);
            color: white;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .secondary-button:hover {
            background: linear-gradient(135deg, #2d2d2d, #1c1c1c);
            box-shadow: 6px 6px 12px rgba(28, 28, 28, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }

        .form-input {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: inset 2px 2px 4px rgba(28, 28, 28, 0.1),
            inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
            transition: all 0.3s ease;
            padding: 12px 16px;
            font-size: 16px;
        }

        .form-input:focus {
            box-shadow: inset 3px 3px 6px rgba(237, 41, 42, 0.2),
            inset -3px -3px 6px rgba(255, 255, 255, 0.9);
            border-color: #ed292a;
            outline: none;
        }

        .form-input.error {
            border-color: #dc3545;
            box-shadow: inset 3px 3px 6px rgba(220, 53, 69, 0.2),
            inset -3px -3px 6px rgba(255, 255, 255, 0.9);
        }

        .gradient-text {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .avatar-frame {
            border-radius: 50%;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.1),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            padding: 2px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
        }

        .form-section {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: inset 1px 1px 2px rgba(28, 28, 28, 0.05),
            inset -1px -1px 2px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
        }

        .info-card {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-radius: 16px;
            box-shadow: 4px 4px 8px rgba(255, 193, 7, 0.2),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .checkbox-container {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 12px;
            box-shadow: 2px 2px 4px rgba(28, 28, 28, 0.1),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
        }

        .custom-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: #ffffff;
            box-shadow: inset 2px 2px 4px rgba(28, 28, 28, 0.1),
            inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.1);
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-checkbox:checked {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            box-shadow: 2px 2px 4px rgba(237, 41, 42, 0.3),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .back-button {
            background: linear-gradient(135deg, #1c1c1c, #2d2d2d);
            color: white;
            border-radius: 12px;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #2d2d2d, #1c1c1c);
            box-shadow: 6px 6px 12px rgba(28, 28, 28, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .user-info-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.1),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
        }
    </style>
@endpush

@section('content')
    <div class="space-y-8 p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.users.show', $user) }}"
               class="back-button inline-flex items-center px-6 py-3 font-semibold transition-all duration-300">
                <i class="fas fa-arrow-left mr-3"></i>Quay lại chi tiết
            </a>

            <div class="user-info-card p-4">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">Đang chỉnh sửa:</span>
                    <div class="flex items-center">
                        <div class="avatar-frame mr-3">
                            <img class="h-10 w-10 rounded-full object-cover"
                                 src="{{ $user->avatar_url }}"
                                 alt="{{ $user->name }}">
                        </div>
                        <span class="font-bold text-lg gradient-text">{{ $user->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="neumorphic-card">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-2xl font-bold gradient-text">Thông tin người dùng</h3>
                <p class="text-gray-600 mt-2">Cập nhật thông tin cá nhân và cài đặt tài khoản</p>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-8">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="form-section p-6 mb-8">
                    <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-3"></i>
                        Thông tin cơ bản
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-3">
                                Họ và tên <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   class="form-input w-full @error('name') error @enderror">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-3">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   class="form-input w-full @error('email') error @enderror">
                            @error('email')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-3">
                                Số điện thoại
                            </label>
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="Nhập số điện thoại"
                                   class="form-input w-full @error('phone') error @enderror">
                            @error('phone')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-3">
                                Vai trò <span class="text-red-500">*</span>
                            </label>
                            <select name="role"
                                    id="role"
                                    required
                                    class="form-input w-full @error('role') error @enderror">
                                <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>
                                    👨‍🎓 Học viên
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    🛡️ Quản trị viên
                                </option>
                            </select>
                            @error('role')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="md:col-span-2">
                            <label for="bio" class="block text-sm font-bold text-gray-700 mb-3">
                                Tiểu sử
                            </label>
                            <textarea name="bio"
                                      id="bio"
                                      rows="4"
                                      placeholder="Nhập tiểu sử người dùng..."
                                      class="form-input w-full resize-none @error('bio') error @enderror">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="md:col-span-2">
                            <div class="checkbox-container p-4">
                                <div class="flex items-start space-x-4">
                                    <input type="checkbox"
                                           name="is_active"
                                           id="is_active"
                                           value="1"
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                           class="custom-checkbox mt-1">
                                    <div>
                                        <label for="is_active" class="block text-sm font-bold text-gray-900">
                                            Tài khoản hoạt động
                                        </label>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Bỏ tick để khóa tài khoản người dùng và ngăn họ đăng nhập vào hệ thống
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="form-section p-6 mb-8">
                    <div class="mb-6">
                        <h4 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-lock text-purple-600 mr-3"></i>
                            Đổi mật khẩu
                        </h4>
                        <p class="text-gray-600 mt-2">Để trống nếu không muốn thay đổi mật khẩu hiện tại</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-3">
                                Mật khẩu mới
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)"
                                   class="form-input w-full @error('password') error @enderror">
                            @error('password')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-3">
                                Xác nhận mật khẩu
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Nhập lại mật khẩu mới"
                                   class="form-input w-full">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.users.show', $user) }}"
                       class="neumorphic-button secondary-button px-8 py-3 font-semibold rounded-xl transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>Hủy
                    </a>

                    <button type="submit"
                            class="neumorphic-button primary-button px-8 py-3 font-semibold rounded-xl transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Information -->
        <div class="info-card p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-yellow-800 mb-3">Lưu ý quan trọng khi chỉnh sửa</h3>
                    <div class="text-yellow-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-alt text-yellow-600 mr-2"></i>
                                    <span class="font-medium">Thay đổi vai trò người dùng có thể ảnh hưởng đến quyền truy cập</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-lock text-yellow-600 mr-2"></i>
                                    <span class="font-medium">Khóa tài khoản sẽ ngăn người dùng đăng nhập</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-key text-yellow-600 mr-2"></i>
                                    <span class="font-medium">Mật khẩu mới phải có ít nhất 8 ký tự</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-yellow-600 mr-2"></i>
                                    <span class="font-medium">Email phải là duy nhất trong hệ thống</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Form validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const confirmPassword = document.getElementById('password_confirmation');

            if (password.length > 0 && password.length < 8) {
                this.setCustomValidity('Mật khẩu phải có ít nhất 8 ký tự');
            } else {
                this.setCustomValidity('');
            }

            // Check password confirmation
            if (confirmPassword.value && confirmPassword.value !== password) {
                confirmPassword.setCustomValidity('Mật khẩu xác nhận không khớp');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password && confirmPassword !== password) {
                this.setCustomValidity('Mật khẩu xác nhận không khớp');
            } else {
                this.setCustomValidity('');
            }
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, ''); // Remove non-digits

            // Limit to 11 digits (Vietnamese phone numbers)
            if (value.length > 11) {
                value = value.slice(0, 11);
            }

            // Format: 0xxx xxx xxx or 0xxx xxxx xxxx
            if (value.length >= 10) {
                if (value.length === 10) {
                    value = value.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
                } else {
                    value = value.replace(/(\d{4})(\d{3})(\d{4})/, '$1 $2 $3');
                }
            }

            this.value = value;
        });

        // Enhanced form submission confirmation
        document.querySelector('form').addEventListener('submit', function(e) {
            const roleSelect = document.getElementById('role');
            const isActiveCheckbox = document.getElementById('is_active');

            // Check if making significant changes
            const originalRole = '{{ $user->role }}';
            const originalIsActive = {{ $user->is_active ? 'true' : 'false' }};

            let warnings = [];

            if (roleSelect.value !== originalRole) {
                warnings.push('🔄 Bạn đang thay đổi vai trò của người dùng');
            }

            if (isActiveCheckbox.checked !== originalIsActive) {
                if (!isActiveCheckbox.checked) {
                    warnings.push('🔒 Bạn đang khóa tài khoản người dùng');
                } else {
                    warnings.push('🔓 Bạn đang mở khóa tài khoản người dùng');
                }
            }

            if (warnings.length > 0) {
                const confirmMessage = warnings.join('\n') + '\n\n⚠️ Bạn có chắc chắn muốn tiếp tục?';
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            }
        });

        // Real-time form validation feedback
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('error');
                } else {
                    this.classList.add('error');
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('error') && this.checkValidity()) {
                    this.classList.remove('error');
                }
            });
        });

        // Custom checkbox animation
        const checkbox = document.getElementById('is_active');
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            }
        });

        // Auto-save draft functionality (optional)
        let saveTimer;
        const formInputs = document.querySelectorAll('input, textarea, select');

        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(() => {
                    // Could implement auto-save draft here
                    console.log('Auto-saving draft...');
                }, 2000);
            });
        });
    </script>
@endpush
