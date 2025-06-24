{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ - E-Learning LMS')

@section('content')
    {{-- Background with gradient and floating elements --}}
    <div class="relative min-h-screen bg-gradient-to-br from-gray-400 via-[#1c1c1c] to-[#1c1c1c] overflow-hidden pt-32">
        {{-- Floating background elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-[#ed292a]/20 to-[#7e0202]/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-1/2 -left-40 w-96 h-96 bg-gradient-to-tr from-[#7e0202]/10 to-[#ed292a]/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute bottom-20 right-1/4 w-64 h-64 bg-gradient-to-bl from-white/5 to-transparent rounded-full blur-2xl animate-pulse delay-2000"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Header with glassmorphism --}}
            <div class="mb-12 text-center">
                <div class="inline-block p-8 rounded-3xl">
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent mb-3" style="font-family: 'CustomTitle', sans-serif; ">
                        Chỉnh sửa hồ sơ
                    </h1>
                    <p class="text-gray-300 text-lg">Cập nhật thông tin cá nhân và cài đặt tài khoản của bạn</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar Navigation with floating design --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <nav class="p-6 rounded-2xl bg-[#1c1c1c] border border-white/40 shadow-2xl">
                            <div class="space-y-2">
                                <a href="#profile-info"
                                   class="profile-nav-link active group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-105"
                                   data-target="profile-info">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-[#ed292a] to-[#7e0202] mr-3 group-hover:shadow-lg group-hover:shadow-[#ed292a]/25">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <span class="text-white">Thông tin cá nhân</span>
                                </a>

                                <a href="#password"
                                   class="profile-nav-link group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:bg-white/5"
                                   data-target="password">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 mr-3 group-hover:bg-white/20 transition-colors">
                                        <i class="fas fa-lock text-gray-300 text-sm"></i>
                                    </div>
                                    <span class="text-gray-300 group-hover:text-white">Đổi mật khẩu</span>
                                </a>

                                <a href="#danger-zone"
                                   class="profile-nav-link group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:bg-white/5"
                                   data-target="danger-zone">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 mr-3 group-hover:bg-red-500/20 transition-colors">
                                        <i class="fas fa-exclamation-triangle text-gray-300 text-sm group-hover:text-red-400"></i>
                                    </div>
                                    <span class="text-gray-300 group-hover:text-white">Xóa tài khoản</span>
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:col-span-3 space-y-8">
                    {{-- Profile Information --}}
                    <div id="profile-info" class="profile-section">
                        <div class="p-8 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl hover:shadow-3xl transition-all duration-300">
                            <div class="flex items-center mb-8">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ed292a] to-[#7e0202] flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-white">Thông tin cá nhân</h2>
                                    <p class="text-gray-300">Cập nhật thông tin hồ sơ và địa chỉ email của bạn</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Avatar Section with floating effect --}}
                                <div class="mb-8">
                                    <label class="block text-sm font-medium text-gray-200 mb-4">Ảnh đại diện</label>
                                    <div class="flex items-center space-x-8">
                                        <div class="relative group">
                                            <div class="absolute -inset-2 bg-gradient-to-r from-[#ed292a] to-[#7e0202] rounded-full opacity-0 group-hover:opacity-100 transition-opacity blur-sm"></div>
                                            <img id="avatar-preview"
                                                 src="{{ $user->avatar_url }}"
                                                 alt="{{ $user->name }}"
                                                 class="relative h-24 w-24 rounded-full object-cover border-4 border-white/20 shadow-xl group-hover:shadow-2xl transition-all duration-300">

                                            {{-- Loading overlay --}}
                                            <div id="avatar-loading" class="hidden absolute inset-0 bg-black/70 rounded-full flex items-center justify-center backdrop-blur-sm">
                                                <i class="fas fa-spinner fa-spin text-white text-lg"></i>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div class="flex space-x-3">
                                                <label for="avatar" class="cursor-pointer bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-6 py-3 rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-[#ed292a]/25 transition-all duration-300 hover:scale-105">
                                                    <i class="fas fa-camera mr-2"></i>
                                                    Đổi ảnh
                                                </label>
                                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">

                                                @if($user->avatar)
                                                    <button type="button" id="remove-avatar" class="bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-red-500/20 hover:shadow-lg transition-all duration-300 hover:scale-105 border border-white/20">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Xóa
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-400">JPG, PNG hoặc GIF. Tối đa 2MB.</p>
                                        </div>
                                    </div>
                                    @error('avatar')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Form fields with glassmorphism inputs --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    {{-- Name --}}
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-200 mb-3">Họ tên</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                        @error('name')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-200 mb-3">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                        @error('email')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror

                                        @if(!$user->email_verified_at)
                                            <div class="mt-2 flex items-center text-sm text-yellow-400">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                Email chưa được xác thực
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="mb-6">
                                    <label for="phone" class="block text-sm font-medium text-gray-200 mb-3">Số điện thoại</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                    @error('phone')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Bio --}}
                                <div class="mb-8">
                                    <label for="bio" class="block text-sm font-medium text-gray-200 mb-3">Giới thiệu</label>
                                    <textarea id="bio" name="bio" rows="4" placeholder="Viết vài dòng về bản thân..."
                                              class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15 resize-none">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-8 py-3 rounded-xl font-medium hover:shadow-lg hover:shadow-[#ed292a]/25 transition-all duration-300 hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>
                                        Lưu thay đổi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Change Password --}}
                    <div id="password" class="profile-section hidden">
                        <div class="p-8 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl hover:shadow-3xl transition-all duration-300">
                            <div class="flex items-center mb-8">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ed292a] to-[#7e0202] flex items-center justify-center mr-4">
                                    <i class="fas fa-lock text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-white">Đổi mật khẩu</h2>
                                    <p class="text-gray-300">Đảm bảo tài khoản của bạn sử dụng mật khẩu mạnh để bảo mật</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="update_type" value="password">

                                <div class="space-y-6 mb-8">
                                    {{-- Current Password --}}
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-200 mb-3">Mật khẩu hiện tại</label>
                                        <input type="password" id="current_password" name="current_password" required
                                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                        @error('current_password')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- New Password --}}
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-200 mb-3">Mật khẩu mới</label>
                                        <input type="password" id="password" name="password" required
                                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                        @error('password')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-3">Xác nhận mật khẩu mới</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300 hover:bg-white/15">
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white px-8 py-3 rounded-xl font-medium hover:shadow-lg hover:shadow-[#ed292a]/25 transition-all duration-300 hover:scale-105">
                                        <i class="fas fa-key mr-2"></i>
                                        Cập nhật mật khẩu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div id="danger-zone" class="profile-section hidden">
                        <div class="p-8 rounded-2xl bg-red-500/10 backdrop-blur-lg border border-red-500/30 shadow-2xl hover:shadow-3xl transition-all duration-300">
                            <div class="flex items-center mb-8">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center mr-4">
                                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-white">Vùng nguy hiểm</h2>
                                    <p class="text-red-300">Hành động này không thể hoàn tác</p>
                                </div>
                            </div>

                            <div class="p-6 rounded-xl bg-red-500/10 border border-red-500/20 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-4">
                                        <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-red-200 mb-2">Xóa tài khoản vĩnh viễn</h3>
                                        <p class="text-red-300 text-sm leading-relaxed">
                                            Khi xóa tài khoản, tất cả dữ liệu và thông tin của bạn sẽ bị xóa vĩnh viễn.
                                            Trước khi xóa tài khoản, hãy tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="delete-account-btn" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-8 py-3 rounded-xl font-medium hover:shadow-lg hover:shadow-red-500/25 transition-all duration-300 hover:scale-105">
                                <i class="fas fa-trash mr-2"></i>
                                Xóa tài khoản
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal with glassmorphism --}}
    <div id="delete-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative p-8 border border-white/20 w-full max-w-md shadow-2xl rounded-2xl bg-white/10 backdrop-blur-lg mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-500/20 mb-6">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Xác nhận xóa tài khoản</h3>
                <p class="text-gray-300 mb-6">
                    Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-6">
                        <label for="delete_password" class="block text-sm font-medium text-gray-200 mb-3">Nhập mật khẩu để xác nhận</label>
                        <input type="password" id="delete_password" name="password" required
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button type="button" id="cancel-delete" class="px-6 py-3 bg-white/10 backdrop-blur-sm text-gray-200 rounded-xl hover:bg-white/20 transition-all duration-300 font-medium border border-white/20">
                            Hủy
                        </button>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-700 text-white rounded-xl hover:shadow-lg hover:shadow-red-500/25 transition-all duration-300 hover:scale-105 font-medium">
                            Xóa tài khoản
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation with smooth animations
            const navLinks = document.querySelectorAll('.profile-nav-link');
            const sections = document.querySelectorAll('.profile-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');

                    // Update nav styles with smooth transitions
                    navLinks.forEach(nav => {
                        nav.classList.remove('active');
                        const icon = nav.querySelector('div');
                        const text = nav.querySelector('span');
                        icon.classList.remove('bg-gradient-to-br', 'from-[#ed292a]', 'to-[#7e0202]', 'shadow-lg', 'shadow-[#ed292a]/25');
                        icon.classList.add('bg-white/10');
                        text.classList.remove('text-white');
                        text.classList.add('text-gray-300');
                    });

                    // Activate current tab
                    this.classList.add('active');
                    const activeIcon = this.querySelector('div');
                    const activeText = this.querySelector('span');
                    activeIcon.classList.remove('bg-white/10');
                    activeIcon.classList.add('bg-gradient-to-br', 'from-[#ed292a]', 'to-[#7e0202]', 'shadow-lg', 'shadow-[#ed292a]/25');
                    activeText.classList.remove('text-gray-300');
                    activeText.classList.add('text-white');

                    // Show/hide sections with fade effect
                    sections.forEach(section => {
                        section.classList.add('hidden');
                        section.style.opacity = '0';
                    });

                    const targetSection = document.getElementById(targetId);
                    targetSection.classList.remove('hidden');

                    // Smooth fade in
                    setTimeout(() => {
                        targetSection.style.opacity = '1';
                        targetSection.style.transition = 'opacity 0.3s ease-in-out';
                    }, 50);
                });
            });

            // Avatar preview and upload with enhanced UX
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarLoading = document.getElementById('avatar-loading');

            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Kích thước file không được vượt quá 2MB');
                        return;
                    }

                    // Show preview immediately
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            avatarPreview.style.transform = 'scale(1)';
                        }, 200);
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
                            avatarPreview.src = data.avatar_url + '?t=' + Date.now();
                            showSuccess(data.message);

                            // Update remove button visibility
                            if (!document.getElementById('remove-avatar') && data.filename) {
                                addRemoveButton();
                            }
                        } else {
                            showError('Có lỗi xảy ra khi tải ảnh lên.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('Có lỗi xảy ra khi tải ảnh lên.');
                    })
                    .finally(() => {
                        avatarLoading.classList.add('hidden');
                    });
            }

            function addRemoveButton() {
                const avatarSection = document.querySelector('.flex.space-x-3');
                if (avatarSection && !document.getElementById('remove-avatar')) {
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.id = 'remove-avatar';
                    removeBtn.className = 'bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-red-500/20 hover:shadow-lg transition-all duration-300 hover:scale-105 border border-white/20';
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
                            showSuccess(data.message);
                        } else {
                            showError('Có lỗi xảy ra khi xóa ảnh đại diện.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('Có lỗi xảy ra khi xóa ảnh đại diện.');
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

            // Delete account modal with enhanced animations
            const deleteBtn = document.getElementById('delete-account-btn');
            const deleteModal = document.getElementById('delete-modal');
            const cancelDelete = document.getElementById('cancel-delete');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    deleteModal.classList.remove('hidden');
                    deleteModal.style.opacity = '0';
                    deleteModal.style.transform = 'scale(0.95)';

                    setTimeout(() => {
                        deleteModal.style.transition = 'all 0.3s ease-out';
                        deleteModal.style.opacity = '1';
                        deleteModal.style.transform = 'scale(1)';
                    }, 10);
                });
            }

            if (cancelDelete) {
                cancelDelete.addEventListener('click', function() {
                    closeModal();
                });
            }

            function closeModal() {
                deleteModal.style.opacity = '0';
                deleteModal.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 300);
            }

            // Close modal when clicking outside
            deleteModal?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Enhanced notification functions
            function showSuccess(message) {
                createNotification(message, 'success');
            }

            function showError(message) {
                createNotification(message, 'error');
            }

            function createNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl backdrop-blur-lg border transition-all duration-300 transform translate-x-full opacity-0 ${
                    type === 'success'
                        ? 'bg-green-500/20 border-green-500/30 text-green-200'
                        : 'bg-red-500/20 border-red-500/30 text-red-200'
                }`;

                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3"></i>
                        <span>${message}</span>
                        <button class="ml-4 text-gray-300 hover:text-white" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                    notification.style.opacity = '1';
                }, 100);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateX(full)';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            // Form validation with visual feedback
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const inputs = form.querySelectorAll('input, textarea');

                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        validateField(this);
                    });

                    input.addEventListener('input', function() {
                        if (this.classList.contains('border-red-500')) {
                            validateField(this);
                        }
                    });
                });

                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    inputs.forEach(input => {
                        if (!validateField(input)) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        showError('Vui lòng kiểm tra lại thông tin đã nhập.');
                    }
                });
            });

            function validateField(field) {
                const value = field.value.trim();
                const type = field.type;
                const required = field.hasAttribute('required');
                let isValid = true;

                // Remove previous error styling
                field.classList.remove('border-red-500', 'focus:ring-red-500');
                field.classList.add('border-white/20', 'focus:ring-[#ed292a]');

                if (required && !value) {
                    isValid = false;
                } else if (type === 'email' && value && !isValidEmail(value)) {
                    isValid = false;
                } else if (field.name === 'password' && value && value.length < 8) {
                    isValid = false;
                } else if (field.name === 'password_confirmation') {
                    const passwordField = document.querySelector('input[name="password"]');
                    if (passwordField && value !== passwordField.value) {
                        isValid = false;
                    }
                }

                if (!isValid) {
                    field.classList.remove('border-white/20', 'focus:ring-[#ed292a]');
                    field.classList.add('border-red-500', 'focus:ring-red-500');
                }

                return isValid;
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Enhanced hover effects for interactive elements
            const interactiveElements = document.querySelectorAll('button, .cursor-pointer, input[type="file"] + label');
            interactiveElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });

                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Initialize tooltips for better UX
            const tooltipElements = document.querySelectorAll('[title]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function(e) {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-black/80 rounded-lg backdrop-blur-sm pointer-events-none';
                    tooltip.textContent = this.getAttribute('title');
                    tooltip.style.top = (e.pageY - 40) + 'px';
                    tooltip.style.left = (e.pageX - 50) + 'px';
                    document.body.appendChild(tooltip);

                    this.setAttribute('data-tooltip-id', Date.now());
                    tooltip.setAttribute('data-tooltip-for', this.getAttribute('data-tooltip-id'));
                });

                element.addEventListener('mouseleave', function() {
                    const tooltipId = this.getAttribute('data-tooltip-id');
                    const tooltip = document.querySelector(`[data-tooltip-for="${tooltipId}"]`);
                    if (tooltip) {
                        tooltip.remove();
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #ed292a, #7e0202);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #7e0202, #ed292a);
        }

        /* Enhanced animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(237, 41, 42, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(237, 41, 42, 0.5);
            }
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-duration: 0.3s;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom focus styles */
        input:focus, textarea:focus, button:focus {
            outline: none;
            transform: translateY(-1px);
        }

        /* Glass morphism enhancements */
        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Custom gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endpush
