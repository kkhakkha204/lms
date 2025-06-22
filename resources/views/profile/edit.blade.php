{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ - E-Learning LMS')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa hồ sơ</h1>
            <p class="mt-2 text-gray-600">Cập nhật thông tin cá nhân và cài đặt tài khoản của bạn.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sidebar Navigation --}}
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <a href="#profile-info"
                       class="profile-nav-link bg-blue-50 border-blue-500 text-blue-700 group border-l-4 px-3 py-2 flex items-center text-sm font-medium"
                       data-target="profile-info">
                        <i class="fas fa-user text-blue-500 mr-3"></i>
                        Thông tin cá nhân
                    </a>
                    <a href="#password"
                       class="profile-nav-link text-gray-900 hover:text-gray-900 hover:bg-gray-50 group border-l-4 border-transparent px-3 py-2 flex items-center text-sm font-medium"
                       data-target="password">
                        <i class="fas fa-lock text-gray-400 group-hover:text-gray-500 mr-3"></i>
                        Đổi mật khẩu
                    </a>
                    <a href="#danger-zone"
                       class="profile-nav-link text-gray-900 hover:text-gray-900 hover:bg-gray-50 group border-l-4 border-transparent px-3 py-2 flex items-center text-sm font-medium"
                       data-target="danger-zone">
                        <i class="fas fa-exclamation-triangle text-gray-400 group-hover:text-gray-500 mr-3"></i>
                        Xóa tài khoản
                    </a>
                </nav>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Profile Information --}}
                <div id="profile-info" class="profile-section">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Thông tin cá nhân</h2>
                            <p class="mt-1 text-sm text-gray-600">Cập nhật thông tin hồ sơ và địa chỉ email của bạn.</p>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                            @csrf
                            @method('PUT')

                            {{-- Avatar Section --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <img id="avatar-preview"
                                             src="{{ $user->avatar_url }}"
                                             alt="{{ $user->name }}"
                                             class="h-20 w-20 rounded-full object-cover border-2 border-gray-200">

                                        {{-- Loading overlay --}}
                                        <div id="avatar-loading" class="hidden absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
                                            <i class="fas fa-spinner fa-spin text-white"></i>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex space-x-2">
                                            <label for="avatar" class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-camera mr-2"></i>
                                                Đổi ảnh
                                            </label>
                                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">

                                            @if($user->avatar)
                                                <button type="button" id="remove-avatar" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition-colors">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Xóa
                                                </button>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500">JPG, PNG hoặc GIF. Tối đa 2MB.</p>
                                    </div>
                                </div>
                                @error('avatar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ tên</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                @if(!$user->email_verified_at)
                                    <p class="mt-1 text-sm text-yellow-600">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Email chưa được xác thực.
                                    </p>
                                @endif
                            </div>

                            {{-- Phone --}}
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Bio --}}
                            <div class="mb-6">
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Giới thiệu</label>
                                <textarea id="bio" name="bio" rows="4" placeholder="Viết vài dòng về bản thân..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Change Password --}}
                <div id="password" class="profile-section hidden">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Đổi mật khẩu</h2>
                            <p class="mt-1 text-sm text-gray-600">Đảm bảo tài khoản của bạn sử dụng mật khẩu mạnh để bảo mật.</p>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" class="p-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="update_type" value="password">

                            {{-- Current Password --}}
                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại</label>
                                <input type="password" id="current_password" name="current_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                                <input type="password" id="password" name="password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-key mr-2"></i>
                                    Cập nhật mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div id="danger-zone" class="profile-section hidden">
                    <div class="bg-white shadow rounded-lg border-red-200 border">
                        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                            <h2 class="text-lg font-medium text-red-900">Vùng nguy hiểm</h2>
                            <p class="mt-1 text-sm text-red-700">Hành động này không thể hoàn tác.</p>
                        </div>

                        <div class="p-6">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Xóa tài khoản vĩnh viễn</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Khi xóa tài khoản, tất cả dữ liệu và thông tin của bạn sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, hãy tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="delete-account-btn" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Xóa tài khoản
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Xác nhận xóa tài khoản</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Nhập mật khẩu để xác nhận</label>
                            <input type="password" id="delete_password" name="password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div class="flex justify-center space-x-3">
                            <button type="button" id="cancel-delete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                Hủy
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Xóa tài khoản
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation
            const navLinks = document.querySelectorAll('.profile-nav-link');
            const sections = document.querySelectorAll('.profile-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('data-target');

                    // Update nav styles
                    navLinks.forEach(nav => {
                        nav.classList.remove('bg-blue-50', 'border-blue-500', 'text-blue-700');
                        nav.classList.add('text-gray-900', 'border-transparent');
                    });

                    this.classList.add('bg-blue-50', 'border-blue-500', 'text-blue-700');
                    this.classList.remove('text-gray-900', 'border-transparent');

                    // Show/hide sections
                    sections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    document.getElementById(targetId).classList.remove('hidden');
                });
            });

            // Avatar preview and upload
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarLoading = document.getElementById('avatar-loading');

            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Show preview immediately
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Upload via AJAX for immediate update
                    uploadAvatar(file);
                }
            });

            function uploadAvatar(file) {
                const formData = new FormData();
                formData.append('avatar', file);
                formData.append('_token', '{{ csrf_token() }}');

                avatarLoading.classList.remove('hidden');

                fetch('{{ route("profile.avatar.update") }}', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            avatarPreview.src = data.avatar_url + '?t=' + Date.now(); // Cache busting
                            LMS.showSuccess(data.message);

                            // Update remove button visibility
                            if (!document.getElementById('remove-avatar') && data.filename) {
                                addRemoveButton();
                            }
                        } else {
                            LMS.showError('Có lỗi xảy ra khi tải ảnh lên.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        LMS.showError('Có lỗi xảy ra khi tải ảnh lên.');
                    })
                    .finally(() => {
                        avatarLoading.classList.add('hidden');
                    });
            }

            function addRemoveButton() {
                const avatarSection = document.querySelector('.flex.space-x-2');
                if (avatarSection && !document.getElementById('remove-avatar')) {
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.id = 'remove-avatar';
                    removeBtn.className = 'bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition-colors';
                    removeBtn.innerHTML = '<i class="fas fa-trash mr-2"></i>Xóa';
                    avatarSection.appendChild(removeBtn);

                    // Add event listener
                    removeBtn.addEventListener('click', function() {
                        if (confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')) {
                            removeAvatar();
                        }
                    });
                }
            }

            // Remove avatar function
            function removeAvatar() {
                avatarLoading.classList.remove('hidden');

                fetch('{{ route("profile.avatar.remove") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            avatarPreview.src = data.avatar_url + '?t=' + Date.now();
                            const removeBtn = document.getElementById('remove-avatar');
                            if (removeBtn) removeBtn.remove();
                            LMS.showSuccess(data.message);
                        } else {
                            LMS.showError('Có lỗi xảy ra khi xóa ảnh đại diện.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        LMS.showError('Có lỗi xảy ra khi xóa ảnh đại diện.');
                    })
                    .finally(() => {
                        avatarLoading.classList.add('hidden');
                    });
            }

            // Remove avatar button event
            const removeAvatarBtn = document.getElementById('remove-avatar');
            if (removeAvatarBtn) {
                removeAvatarBtn.addEventListener('click', function() {
                    if (confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')) {
                        removeAvatar();
                    }
                });
            }

            // Delete account modal
            const deleteBtn = document.getElementById('delete-account-btn');
            const deleteModal = document.getElementById('delete-modal');
            const cancelDelete = document.getElementById('cancel-delete');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    deleteModal.classList.remove('hidden');
                });
            }

            if (cancelDelete) {
                cancelDelete.addEventListener('click', function() {
                    deleteModal.classList.add('hidden');
                });
            }

            // Close modal when clicking outside
            deleteModal?.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
