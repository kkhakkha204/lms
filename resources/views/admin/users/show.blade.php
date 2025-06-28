@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')
@section('page-title', 'Chi tiết người dùng')

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

        .info-grid {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: inset 2px 2px 4px rgba(28, 28, 28, 0.05),
            inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
        }

        .avatar-frame {
            border-radius: 50%;
            box-shadow: 8px 8px 16px rgba(28, 28, 28, 0.1),
            -8px -8px 16px rgba(255, 255, 255, 0.9);
            padding: 4px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
        }

        .status-badge {
            border-radius: 20px;
            box-shadow: 2px 2px 4px rgba(28, 28, 28, 0.1),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
        }

        .stat-item {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 12px;
            box-shadow: 2px 2px 4px rgba(28, 28, 28, 0.1),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.15),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .gradient-text {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .course-item, .review-item {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            box-shadow: 3px 3px 6px rgba(28, 28, 28, 0.1),
            -3px -3px 6px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.03);
            transition: all 0.3s ease;
        }

        .course-item:hover, .review-item:hover {
            transform: translateY(-2px);
            box-shadow: 5px 5px 10px rgba(28, 28, 28, 0.15),
            -5px -5px 10px rgba(255, 255, 255, 0.9);
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

        .edit-button {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            box-shadow: 4px 4px 8px rgba(0, 123, 255, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .edit-button:hover {
            background: linear-gradient(135deg, #0056b3, #007bff);
            box-shadow: 6px 6px 12px rgba(0, 123, 255, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }

        .toggle-button {
            background: linear-gradient(135deg, #fd7e14, #e55100);
            color: white;
            box-shadow: 4px 4px 8px rgba(253, 126, 20, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .toggle-button.unlock {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 4px 4px 8px rgba(40, 167, 69, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .toggle-button:hover {
            box-shadow: 6px 6px 12px rgba(253, 126, 20, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }

        .toggle-button.unlock:hover {
            box-shadow: 6px 6px 12px rgba(40, 167, 69, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }

        .delete-button {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            box-shadow: 4px 4px 8px rgba(220, 53, 69, 0.3),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .delete-button:hover {
            background: linear-gradient(135deg, #c82333, #dc3545);
            box-shadow: 6px 6px 12px rgba(220, 53, 69, 0.4),
            -6px -6px 12px rgba(255, 255, 255, 0.9);
        }
    </style>
@endpush

@section('content')
    <div class="space-y-8 p-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.users.index') }}"
               class="back-button inline-flex items-center px-6 py-3 font-semibold transition-all duration-300">
                <i class="fas fa-arrow-left mr-3"></i>Quay lại danh sách
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Info Card -->
            <div class="lg:col-span-1">
                <div class="neumorphic-card p-8">
                    <div class="text-center">
                        <div class="avatar-frame mx-auto w-36 h-36 mb-6">
                            <img class="h-32 w-32 rounded-full object-cover mx-auto"
                                 src="{{ $user->avatar_url }}"
                                 alt="{{ $user->name }}">
                        </div>

                        <h3 class="text-2xl font-bold gradient-text mb-2">{{ $user->name }}</h3>
                        <p class="text-gray-600 text-lg mb-4">{{ $user->email }}</p>

                        <!-- Role Badge -->
                        <div class="mb-4">
                            @if($user->role === 'admin')
                                <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                      style="background: linear-gradient(135deg, #6f42c1, #8A2BE2); color: white;">
                                    <i class="fas fa-shield-alt mr-2"></i>Quản trị viên
                                </span>
                            @else
                                <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                      style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                    <i class="fas fa-user-graduate mr-2"></i>Học viên
                                </span>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <div class="mb-6">
                            @if($user->is_active)
                                <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                      style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                                    <i class="fas fa-check-circle mr-2"></i>Hoạt động
                                </span>
                            @else
                                <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                      style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                                    <i class="fas fa-times-circle mr-2"></i>Bị khóa
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="neumorphic-button edit-button w-full flex justify-center items-center px-6 py-3 font-semibold rounded-xl transition-all duration-300">
                            <i class="fas fa-edit mr-3"></i>Chỉnh sửa thông tin
                        </a>

                        @if($user->id !== auth()->id())
                            <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                    class="neumorphic-button toggle-button {{ $user->is_active ? '' : 'unlock' }} w-full flex justify-center items-center px-6 py-3 font-semibold rounded-xl transition-all duration-300">
                                <i class="fas fa-{{ $user->is_active ? 'lock' : 'unlock' }} mr-3"></i>
                                {{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}
                            </button>

                            <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                    class="neumorphic-button delete-button w-full flex justify-center items-center px-6 py-3 font-semibold rounded-xl transition-all duration-300">
                                <i class="fas fa-trash mr-3"></i>Xóa người dùng
                            </button>
                        @endif
                    </div>
                </div>

                <!-- User Stats -->
                @if($user->role === 'student')
                    <div class="neumorphic-card p-8 mt-8">
                        <h4 class="text-xl font-bold gradient-text mb-6">Thống kê học tập</h4>
                        <div class="space-y-4">
                            <div class="stat-item p-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-book text-blue-600"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">Khóa học đã đăng ký</span>
                                    </div>
                                    <span class="font-bold text-xl text-blue-600">{{ $userStats['total_courses'] }}</span>
                                </div>
                            </div>

                            <div class="stat-item p-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-dollar-sign text-green-600"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">Tổng thanh toán</span>
                                    </div>
                                    <span class="font-bold text-xl text-green-600">{{ number_format($userStats['total_payments']) }} VNĐ</span>
                                </div>
                            </div>

                            <div class="stat-item p-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-star text-yellow-600"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">Đánh giá đã viết</span>
                                    </div>
                                    <span class="font-bold text-xl text-yellow-600">{{ $userStats['total_reviews'] }}</span>
                                </div>
                            </div>

                            @if($userStats['avg_rating'])
                                <div class="stat-item p-4">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-chart-line text-orange-600"></i>
                                            </div>
                                            <span class="text-gray-700 font-medium">Điểm trung bình</span>
                                        </div>
                                        <span class="font-bold text-xl text-orange-600">{{ number_format($userStats['avg_rating'], 1) }}/5</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detailed Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Information -->
                <div class="neumorphic-card">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h4 class="text-2xl font-bold gradient-text">Thông tin cơ bản</h4>
                    </div>
                    <div class="p-8">
                        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Họ và tên</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $user->name }}</dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Email</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $user->email }}</dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Số điện thoại</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $user->phone ?: 'Chưa cập nhật' }}</dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Vai trò</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $user->role === 'admin' ? 'Quản trị viên' : 'Học viên' }}
                                </dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Trạng thái tài khoản</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    <span class="text-{{ $user->is_active ? 'green' : 'red' }}-600">
                                        {{ $user->is_active ? 'Hoạt động' : 'Bị khóa' }}
                                    </span>
                                </dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Xác thực email</dt>
                                <dd class="text-lg font-semibold">
                                    @if($user->email_verified_at)
                                        <span class="text-green-600">Đã xác thực</span>
                                        <div class="text-sm text-gray-500 mt-1">{{ $user->email_verified_at->format('d/m/Y H:i') }}</div>
                                    @else
                                        <span class="text-red-600">Chưa xác thực</span>
                                    @endif
                                </dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Ngày tạo tài khoản</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
                            </div>

                            <div class="info-grid p-4">
                                <dt class="text-sm font-bold text-gray-500 mb-2">Lần đăng nhập cuối</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập' }}
                                </dd>
                            </div>

                            @if($user->bio)
                                <div class="sm:col-span-2 info-grid p-4">
                                    <dt class="text-sm font-bold text-gray-500 mb-2">Tiểu sử</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $user->bio }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Enrolled Courses (For Students) -->
                @if($user->role === 'student' && $user->enrollments->count() > 0)
                    <div class="neumorphic-card">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h4 class="text-2xl font-bold gradient-text">Khóa học đã đăng ký</h4>
                        </div>
                        <div class="p-8">
                            <div class="space-y-6">
                                @foreach($user->enrollments as $enrollment)
                                    <div class="course-item p-6">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h5 class="text-xl font-bold text-gray-900 mb-2">{{ $enrollment->course->title }}</h5>
                                                <p class="text-gray-600 mb-4">
                                                    <i class="fas fa-calendar-alt mr-2"></i>
                                                    Đăng ký: {{ $enrollment->created_at->format('d/m/Y') }}
                                                </p>
                                                <div>
                                                    @if($enrollment->status === 'active')
                                                        <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                                              style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                                                            <i class="fas fa-play mr-2"></i>Đang học
                                                        </span>
                                                    @elseif($enrollment->status === 'completed')
                                                        <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                                              style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                                            <i class="fas fa-check-circle mr-2"></i>Hoàn thành
                                                        </span>
                                                    @else
                                                        <span class="status-badge inline-flex items-center px-4 py-2 text-sm font-bold"
                                                              style="background: linear-gradient(135deg, #6c757d, #495057); color: white;">
                                                            {{ ucfirst($enrollment->status) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right ml-6">
                                                <div class="text-2xl font-bold gradient-text">
                                                    {{ number_format($enrollment->course->price) }} VNĐ
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Reviews -->
                @if($user->reviews->count() > 0)
                    <div class="neumorphic-card">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h4 class="text-2xl font-bold gradient-text">Đánh giá gần đây</h4>
                        </div>
                        <div class="p-8">
                            <div class="space-y-6">
                                @foreach($user->reviews->take(5) as $review)
                                    <div class="review-item p-6">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h5 class="text-xl font-bold text-gray-900 mb-3">{{ $review->course->title ?? 'Khóa học đã bị xóa' }}</h5>
                                                <div class="flex items-center mb-3">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400 text-lg mr-1"></i>
                                                    @endfor
                                                    <span class="ml-3 text-lg font-semibold text-gray-700">{{ $review->rating }}/5</span>
                                                </div>
                                                @if($review->comment)
                                                    <p class="text-gray-700 mb-3 text-lg leading-relaxed">{{ $review->comment }}</p>
                                                @endif
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-clock mr-2"></i>{{ $review->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-0 border-0 w-96 shadow-2xl rounded-2xl bg-white" style="box-shadow: 12px 12px 24px rgba(28, 28, 28, 0.2), -12px -12px 24px rgba(255, 255, 255, 0.9);">
            <div class="p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6" style="background: linear-gradient(135deg, #dc3545, #c82333); box-shadow: 4px 4px 8px rgba(220, 53, 69, 0.3), -4px -4px 8px rgba(255, 255, 255, 0.9);">
                    <i id="modalIcon" class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold gradient-text mb-4" id="modalTitle">Xác nhận thao tác</h3>
                <p class="text-gray-600 mb-8 text-lg" id="modalMessage">Bạn có chắc chắn muốn thực hiện thao tác này?</p>
                <div class="flex justify-center space-x-4">
                    <button id="cancelBtn"
                            class="neumorphic-button secondary-button px-8 py-3 font-semibold rounded-xl transition-all duration-300">
                        Hủy
                    </button>
                    <button id="confirmBtn"
                            class="neumorphic-button primary-button px-8 py-3 font-semibold rounded-xl transition-all duration-300">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 backdrop-blur-sm">
        <div class="neumorphic-card p-8 rounded-2xl">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-t-red-600 mr-4"></div>
                <span class="text-gray-700 text-lg font-semibold">Đang xử lý...</span>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // File user-management.js đã được load trong layout
        // Chỉ cần các event listeners specific cho trang này nếu có
    </script>
@endpush
