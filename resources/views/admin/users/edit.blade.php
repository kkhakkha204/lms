@extends('layouts.app')

@section('title', 'Chỉnh sửa người dùng')
@section('page-title', 'Chỉnh sửa người dùng')

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.users.show', $user) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại chi tiết
            </a>

            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Chỉnh sửa:</span>
                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full object-cover mr-2"
                         src="{{ $user->avatar_url }}"
                         alt="{{ $user->name }}">
                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Thông tin người dùng</h3>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Số điện thoại
                        </label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="Nhập số điện thoại"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Vai trò <span class="text-red-500">*</span>
                        </label>
                        <select name="role"
                                id="role"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                            <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Học viên</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                        </select>
                        @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Tiểu sử
                        </label>
                        <textarea name="bio"
                                  id="bio"
                                  rows="4"
                                  placeholder="Nhập tiểu sử người dùng..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Tài khoản hoạt động
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Bỏ tick để khóa tài khoản người dùng
                        </p>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Đổi mật khẩu</h4>
                    <p class="text-sm text-gray-600 mb-4">Để trống nếu không muốn thay đổi mật khẩu</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Mật khẩu mới
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Xác nhận mật khẩu
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Nhập lại mật khẩu mới"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    <a href="{{ route('admin.users.show', $user) }}"
                       class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Hủy
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save mr-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Information -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Lưu ý khi chỉnh sửa</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Thay đổi vai trò người dùng có thể ảnh hưởng đến quyền truy cập của họ</li>
                            <li>Khóa tài khoản sẽ ngăn người dùng đăng nhập vào hệ thống</li>
                            <li>Mật khẩu mới phải có ít nhất 8 ký tự</li>
                            <li>Email phải là duy nhất trong hệ thống</li>
                        </ul>
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

        // Form submission confirmation
        document.querySelector('form').addEventListener('submit', function(e) {
            const roleSelect = document.getElementById('role');
            const isActiveCheckbox = document.getElementById('is_active');

            // Check if making significant changes
            const originalRole = '{{ $user->role }}';
            const originalIsActive = {{ $user->is_active ? 'true' : 'false' }};

            let warnings = [];

            if (roleSelect.value !== originalRole) {
                warnings.push('Bạn đang thay đổi vai trò của người dùng');
            }

            if (isActiveCheckbox.checked !== originalIsActive) {
                if (!isActiveCheckbox.checked) {
                    warnings.push('Bạn đang khóa tài khoản người dùng');
                } else {
                    warnings.push('Bạn đang mở khóa tài khoản người dùng');
                }
            }

            if (warnings.length > 0) {
                const confirmMessage = warnings.join('\n') + '\n\nBạn có chắc chắn muốn tiếp tục?';
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            }
        });
    </script>
@endpush
