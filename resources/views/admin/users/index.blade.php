@extends('layouts.admin')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')

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

        .stat-icon {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.1),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .table-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(28, 28, 28, 0.1),
            -8px -8px 16px rgba(255, 255, 255, 0.9);
            overflow: hidden;
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .avatar-frame {
            border-radius: 50%;
            box-shadow: 4px 4px 8px rgba(28, 28, 28, 0.1),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
            padding: 2px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
        }

        .status-badge {
            border-radius: 20px;
            box-shadow: 2px 2px 4px rgba(28, 28, 28, 0.1),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
        }

        .action-button {
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 2px 2px 4px rgba(28, 28, 28, 0.1),
            -2px -2px 4px rgba(255, 255, 255, 0.9);
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 3px 3px 6px rgba(28, 28, 28, 0.15),
            -3px -3px 6px rgba(255, 255, 255, 0.9);
        }

        .gradient-text {
            background: linear-gradient(135deg, #ed292a, #7e0202);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .search-form {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: inset 4px 4px 8px rgba(28, 28, 28, 0.1),
            inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .form-input {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: inset 2px 2px 4px rgba(28, 28, 28, 0.1),
            inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: inset 3px 3px 6px rgba(237, 41, 42, 0.2),
            inset -3px -3px 6px rgba(255, 255, 255, 0.9);
            border-color: #ed292a;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-8 p-6">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-2" style="font-family: 'CustomTitle', sans-serif; ">Quản lý người dùng</h1>
            <p class="text-gray-600">Theo dõi và quản lý toàn bộ người dùng trong hệ thống</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="neumorphic-card p-8 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Tổng người dùng</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    </div>
                    <div class="stat-icon p-4">
                        <i class="fas fa-users text-2xl" style="color: #ed292a;"></i>
                    </div>
                </div>
            </div>

            <div class="neumorphic-card p-8 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Đang hoạt động</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['active_users']) }}</p>
                    </div>
                    <div class="stat-icon p-4">
                        <i class="fas fa-user-check text-2xl" style="color: #28a745;"></i>
                    </div>
                </div>
            </div>

            <div class="neumorphic-card p-8 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Học viên</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['student_users']) }}</p>
                    </div>
                    <div class="stat-icon p-4">
                        <i class="fas fa-user-graduate text-2xl" style="color: #ffc107;"></i>
                    </div>
                </div>
            </div>

            <div class="neumorphic-card p-8 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Quản trị viên</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['admin_users']) }}</p>
                    </div>
                    <div class="stat-icon p-4">
                        <i class="fas fa-user-shield text-2xl" style="color: #6f42c1;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-form p-8">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">Tìm kiếm</label>
                        <input type="text" name="search" id="search"
                               value="{{ request('search') }}"
                               placeholder="Tên hoặc email..."
                               class="form-input w-[90%] px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none">
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-3">Vai trò</label>
                        <select name="role" id="role"
                                class="form-input w-[90%] px-4 py-3 text-gray-900 focus:outline-none">
                            <option value="">Tất cả vai trò</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                            <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Học viên</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-3">Trạng thái</label>
                        <select name="status" id="status"
                                class="form-input w-[90%] px-4 py-3 text-gray-900 focus:outline-none">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Bị khóa</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-4">
                        <button type="submit"
                                class="neumorphic-button primary-button px-4 py-3 text-[15px] font-medium rounded-xl transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="neumorphic-button secondary-button px-4 py-3 text-[15px] font-medium rounded-xl transition-all duration-300">
                            <i class="fas fa-refresh mr-2"></i>Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold gradient-text">
                        Danh sách người dùng
                    </h3>
                    <p class="text-gray-600 mt-1">{{ $users->total() }} người dùng được tìm thấy</p>
                </div>
                <a href="{{ route('admin.users.export', request()->query()) }}"
                   class="neumorphic-button px-6 py-3 font-semibold rounded-xl transition-all duration-300"
                   style="background: linear-gradient(135deg, #28a745, #20c997); color: white; box-shadow: 4px 4px 8px rgba(40, 167, 69, 0.3), -4px -4px 8px rgba(255, 255, 255, 0.9);">
                    <i class="fas fa-download mr-2"></i>Xuất Excel
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead style="background: linear-gradient(135deg, #f8f9fa, #ffffff);">
                    <tr>
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Người dùng
                        </th>
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Vai trò
                        </th>
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Ngày tạo
                        </th>
                        <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Đăng nhập cuối
                        </th>
                        <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 avatar-frame">
                                        <img class="h-12 w-12 rounded-full object-cover"
                                             src="{{ $user->avatar_url }}"
                                             alt="{{ $user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-sm text-gray-400">{{ $user->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($user->role === 'admin')
                                    <span class="status-badge inline-flex items-center px-4 py-2 text-xs font-bold"
                                          style="background: linear-gradient(135deg, #6f42c1, #8A2BE2); color: white;">
                                        <i class="fas fa-shield-alt mr-2"></i>Quản trị viên
                                    </span>
                                @else
                                    <span class="status-badge inline-flex items-center px-4 py-2 text-xs font-bold"
                                          style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                        <i class="fas fa-user-graduate mr-2"></i>Học viên
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="space-y-2">
                                    @if($user->is_active)
                                        <span class="status-badge inline-flex items-center px-4 py-2 text-xs font-bold"
                                              style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                                            <i class="fas fa-check-circle mr-2"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="status-badge inline-flex items-center px-4 py-2 text-xs font-bold"
                                              style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                                            <i class="fas fa-times-circle mr-2"></i>Bị khóa
                                        </span>
                                    @endif

                                    @if($user->email_verified_at)
                                        <div>
                                            <span class="status-badge inline-flex items-center px-3 py-1 text-xs font-medium"
                                                  style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                                                <i class="fas fa-check mr-1"></i>Đã xác thực
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <span class="status-badge inline-flex items-center px-3 py-1 text-xs font-medium"
                                                  style="background: linear-gradient(135deg, #ffc107, #e0a800); color: white;">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Chưa xác thực
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-900">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-gray-500">Chưa đăng nhập</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="action-button p-3 transition-all duration-300"
                                       style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;"
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="action-button p-3 transition-all duration-300"
                                       style="background: linear-gradient(135deg, #ffc107, #e0a800); color: white;"
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Toggle Status Button -->
                                    @if($user->id !== auth()->id())
                                        <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                                class="action-button p-3 transition-all duration-300"
                                                style="background: linear-gradient(135deg, {{ $user->is_active ? '#fd7e14, #e55100' : '#28a745, #20c997' }}); color: white;"
                                                title="{{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'lock' : 'unlock' }}"></i>
                                        </button>
                                    @endif

                                    <!-- Delete Button -->
                                    @if($user->id !== auth()->id())
                                        <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                class="action-button p-3 transition-all duration-300"
                                                style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;"
                                                title="Xóa người dùng">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <div class="stat-icon p-6 mb-4">
                                        <i class="fas fa-users text-gray-400 text-5xl"></i>
                                    </div>
                                    <p class="text-xl font-semibold text-gray-600">Không tìm thấy người dùng nào</p>
                                    <p class="text-gray-400 mt-2">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-8 py-6 border-t border-gray-100">
                    <div class="flex justify-center">
                        {{ $users->links() }}
                    </div>
                </div>
            @endif
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
