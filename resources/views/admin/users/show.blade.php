@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')
@section('page-title', 'Chi tiết người dùng')

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <img class="mx-auto h-32 w-32 rounded-full object-cover"
                             src="{{ $user->avatar_url }}"
                             alt="{{ $user->name }}">
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>

                        <!-- Role Badge -->
                        <div class="mt-3">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-shield-alt mr-2"></i>Quản trị viên
                            </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user-graduate mr-2"></i>Học viên
                            </span>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <div class="mt-2">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Hoạt động
                            </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>Bị khóa
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="w-full flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Chỉnh sửa thông tin
                        </a>

                        @if($user->id !== auth()->id())
                            <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                    class="w-full flex justify-center items-center px-4 py-2 bg-{{ $user->is_active ? 'orange' : 'green' }}-600 text-white rounded-md hover:bg-{{ $user->is_active ? 'orange' : 'green' }}-700 focus:outline-none focus:ring-2 focus:ring-{{ $user->is_active ? 'orange' : 'green' }}-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-{{ $user->is_active ? 'lock' : 'unlock' }} mr-2"></i>
                                {{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}
                            </button>

                            <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                    class="w-full flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Xóa người dùng
                            </button>
                        @endif
                    </div>
                </div>

                <!-- User Stats -->
                @if($user->role === 'student')
                    <div class="bg-white rounded-lg shadow p-6 mt-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Thống kê học tập</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Khóa học đã đăng ký:</span>
                                <span class="font-semibold text-blue-600">{{ $userStats['total_courses'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tổng thanh toán:</span>
                                <span class="font-semibold text-green-600">{{ number_format($userStats['total_payments']) }} VNĐ</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Đánh giá đã viết:</span>
                                <span class="font-semibold text-yellow-600">{{ $userStats['total_reviews'] }}</span>
                            </div>
                            @if($userStats['avg_rating'])
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Điểm đánh giá trung bình:</span>
                                    <span class="font-semibold text-yellow-600">{{ number_format($userStats['avg_rating'], 1) }}/5</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detailed Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900">Thông tin cơ bản</h4>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Họ và tên</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?: 'Chưa cập nhật' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Vai trò</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->role === 'admin' ? 'Quản trị viên' : 'Học viên' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Trạng thái tài khoản</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->is_active ? 'Hoạt động' : 'Bị khóa' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Xác thực email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($user->email_verified_at)
                                        <span class="text-green-600">Đã xác thực</span>
                                        <div class="text-xs text-gray-500">{{ $user->email_verified_at->format('d/m/Y H:i') }}</div>
                                    @else
                                        <span class="text-red-600">Chưa xác thực</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ngày tạo tài khoản</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Lần đăng nhập cuối</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập' }}
                                </dd>
                            </div>

                            @if($user->bio)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Tiểu sử</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->bio }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Enrolled Courses (For Students) -->
                @if($user->role === 'student' && $user->enrollments->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900">Khóa học đã đăng ký</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($user->enrollments as $enrollment)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900">{{ $enrollment->course->title }}</h5>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Đăng ký: {{ $enrollment->created_at->format('d/m/Y') }}
                                                </p>
                                                <div class="mt-2">
                                                    @if($enrollment->status === 'active')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Đang học
                                            </span>
                                                    @elseif($enrollment->status === 'completed')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Hoàn thành
                                            </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-medium text-gray-900">
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
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900">Đánh giá gần đây</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($user->reviews->take(5) as $review)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900">{{ $review->course->title ?? 'Khóa học đã bị xóa' }}</h5>
                                                <div class="flex items-center mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400 text-sm"></i>
                                                    @endfor
                                                    <span class="ml-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                                                </div>
                                                @if($review->comment)
                                                    <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-2">{{ $review->created_at->format('d/m/Y H:i') }}</p>
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

    <!-- Include the same confirmation modal from index.blade.php -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i id="modalIcon" class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2" id="modalTitle">Xác nhận thao tác</h3>
                <p class="text-sm text-gray-500 mb-4" id="modalMessage">Bạn có chắc chắn muốn thực hiện thao tác này?</p>
                <div class="flex justify-center space-x-3">
                    <button id="cancelBtn"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Hủy
                    </button>
                    <button id="confirmBtn"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mr-3"></div>
                <span class="text-gray-700">Đang xử lý...</span>
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
