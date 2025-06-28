@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
    <style>
        /* Neumorphism Styles */
        .neu-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow:
                20px 20px 40px rgba(0, 0, 0, 0.08),
                -20px -20px 40px rgba(255, 255, 255, 0.8),
                inset 0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .neu-card-small {
            background: #ffffff;
            border-radius: 16px;
            box-shadow:
                12px 12px 24px rgba(0, 0, 0, 0.06),
                -12px -12px 24px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .neu-button {
            background: #ffffff;
            border-radius: 12px;
            box-shadow:
                8px 8px 16px rgba(0, 0, 0, 0.06),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .neu-button:hover {
            box-shadow:
                4px 4px 8px rgba(0, 0, 0, 0.08),
                -4px -4px 8px rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .neu-button:active {
            box-shadow:
                inset 4px 4px 8px rgba(0, 0, 0, 0.08),
                inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            transform: translateY(0);
        }

        .neu-input {
            background: #ffffff;
            border-radius: 12px;
            box-shadow:
                inset 6px 6px 12px rgba(0, 0, 0, 0.05),
                inset -6px -6px 12px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .neu-input:focus {
            box-shadow:
                inset 6px 6px 12px rgba(126, 2, 2, 0.1),
                inset -6px -6px 12px rgba(255, 255, 255, 0.9),
                0 0 0 3px rgba(237, 41, 42, 0.1);
            border: 1px solid rgba(237, 41, 42, 0.3);
        }

        .neu-icon-container {
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            border-radius: 12px;
            box-shadow:
                6px 6px 12px rgba(0, 0, 0, 0.06),
                -6px -6px 12px rgba(255, 255, 255, 0.8);
        }

        .primary-gradient {
            background: linear-gradient(135deg, #7e0202, #ed292a);
        }

        .secondary-gradient {
            background: linear-gradient(135deg, #1c1c1c, #2a2a2a);
        }

        .success-gradient {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .warning-gradient {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }

        .purple-gradient {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow:
                24px 24px 48px rgba(0, 0, 0, 0.12),
                -24px -24px 48px rgba(255, 255, 255, 0.9);
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, #7e0202, #ed292a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-gradient-dark {
            background: linear-gradient(135deg, #1c1c1c, #374151);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .animated-underline {
            position: relative;
        }

        .animated-underline::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(135deg, #7e0202, #ed292a);
            transition: width 0.3s ease;
        }

        .animated-underline:hover::after {
            width: 100%;
        }

        body {
            background: #fafafa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
        <div class="container mx-auto px-6">
            <!-- Header Section -->
            <div class="neu-card p-8 mb-8 hover-lift">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold mb-4" style="font-family: 'CustomTitle', sans-serif; ">Quản lý giao dịch thanh toán</h1>
                        <p class="text-gray-600 text-lg">Quản lý tất cả giao dịch thanh toán tại đây.</p>
                    </div>
                    <div class="flex space-x-4">
                        <button onclick="exportPayments()" class="neu-button primary-gradient text-white px-6 py-3 font-semibold flex items-center space-x-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Xuất dữ liệu</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Revenue Card -->
                <div class="neu-card-small p-6 hover-lift group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="neu-icon-container w-14 h-14 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-gradient-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Tổng doanh thu</p>
                            <p class="text-2xl font-bold text-gradient-dark">{{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400 mt-1">VND</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders Card -->
                <div class="neu-card-small p-6 hover-lift group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="neu-icon-container w-14 h-14 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Giao dịch thành công</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_payments'] }}</p>
                            <p class="text-xs text-green-600 mt-1">Thành công</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders Card -->
                <div class="neu-card-small p-6 hover-lift group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="neu-icon-container w-14 h-14 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Đơn hàng đang chờ xử lý</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_payments'] }}</p>
                            <p class="text-xs text-yellow-600 mt-1">Đang xử lý</p>
                        </div>
                    </div>
                </div>

                <!-- Average Order Value Card -->
                <div class="neu-card-small p-6 hover-lift group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="neu-icon-container w-14 h-14 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Giá trị đơn hàng trung bình</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['average_order_value'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400 mt-1">VND</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="neu-card p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bộ lọc nâng cao</h3>
                <form method="GET" action="{{ route('admin.payments.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Mã giao dịch, Học viên, Khóa học..."
                                   class="neu-input w-full px-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                            <select name="status" class="neu-input w-full px-4 py-3 text-gray-900 focus:outline-none">
                                <option value="all">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Method Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                            <select name="payment_method" class="neu-input w-full px-4 py-3 text-gray-900 focus:outline-none">
                                <option value="all">Tất cả phương thức</option>
                                <option value="stripe" {{ request('payment_method') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="neu-input w-full px-4 py-3 text-gray-900 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="neu-input w-full px-4 py-3 text-gray-900 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button type="submit" class="neu-button primary-gradient text-white px-6 py-3 font-semibold">
                            Áp dụng bộ lọc
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="neu-button text-gray-700 px-6 py-3 font-semibold">
                            Xóa bộ lọc
                        </a>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="neu-card overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Giao Dịch Thanh Toán</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'transaction_id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="animated-underline hover:text-gray-800">
                                    Mã Giao Dịch
                                    @if(request('sort_by') === 'transaction_id')
                                        <span class="ml-1 text-red-600">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Học Viên</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Khóa Học</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'final_amount', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="animated-underline hover:text-gray-800">
                                    Số Tiền
                                    @if(request('sort_by') === 'final_amount')
                                        <span class="ml-1 text-red-600">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phương Thức</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Trạng Thái</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="animated-underline hover:text-gray-800">
                                    Ngày
                                    @if(request('sort_by') === 'created_at')
                                        <span class="ml-1 text-red-600">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thao Tác</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $payment->transaction_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full secondary-gradient flex items-center justify-center text-white font-semibold text-sm mr-3">
                                            {{ strtoupper(substr($payment->student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $payment->student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $payment->student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ Str::limit($payment->course->title, 30) }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $payment->course->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ number_format($payment->final_amount, 0, ',', '.') }} {{ $payment->currency }}</div>
                                    @if($payment->discount_amount > 0)
                                        <div class="text-sm text-green-600 font-medium">-{{ number_format($payment->discount_amount, 0, ',', '.') }} VND</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="neu-card-small inline-flex items-center px-3 py-1 text-xs font-semibold text-gray-700">
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'warning-gradient text-white',
                                            'completed' => 'success-gradient text-white',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'refunded' => 'bg-orange-100 text-orange-800',
                                            'cancelled' => 'bg-gray-100 text-gray-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyles[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="font-medium">{{ $payment->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $payment->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="viewPaymentDetails({{ $payment->id }})"
                                                class="neu-button text-blue-600 hover:text-blue-800 px-3 py-1 text-xs">
                                            Xem
                                        </button>
                                        @if(in_array($payment->status, ['pending', 'failed']))
                                            <button onclick="updatePaymentStatus({{ $payment->id }}, 'completed')"
                                                    class="neu-button text-green-600 hover:text-green-800 px-3 py-1 text-xs">
                                                Complete
                                            </button>
                                        @endif
                                        @if($payment->status === 'completed')
                                            <button onclick="updatePaymentStatus({{ $payment->id }}, 'refunded')"
                                                    class="neu-button text-orange-600 hover:text-orange-800 px-3 py-1 text-xs">
                                                Hoàn tiền
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Không tìm thấy giao dịch thanh toán nào</p>
                                        <p class="text-gray-400 text-sm">Hãy thử điều chỉnh bộ lọc để xem thêm kết quả</p>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 max-w-4xl">
            <div class="neu-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gradient-primary">Chi tiết thanh toán</h3>
                    <button onclick="closeModal()" class="neu-button text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="paymentDetails">
                    <!-- Payment details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-20 mx-auto p-0 border-0 w-96">
            <div class="neu-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gradient-primary">Cập nhật trạng thái thanh toán</h3>
                    <button onclick="closeStatusModal()" class="neu-button text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="statusUpdateForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái mới</label>
                        <select id="newStatus" class="neu-input w-full px-4 py-3 text-gray-900 focus:outline-none">
                            <option value="pending">Đang chờ xử lý</option>
                            <option value="completed">Hoàn tất</option>
                            <option value="failed">Thất bại</option>
                            <option value="refunded">Đã hoàn tiền</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lý do (Không bắt buộc)</label>
                        <textarea id="statusReason" rows="3" placeholder="Nhập lý do thay đổi trạng thái..."
                                  class="neu-input w-full px-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none resize-none"></textarea>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 neu-button primary-gradient text-white px-6 py-3 font-semibold">
                            Cập nhật trạng thái
                        </button>
                        <button type="button" onclick="closeStatusModal()" class="flex-1 neu-button text-gray-700 px-6 py-3 font-semibold">
                            Hủy
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let currentPaymentId = null;

        function viewPaymentDetails(paymentId) {
            fetch(`/admin/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    displayPaymentDetails(data);
                    document.getElementById('paymentModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading payment details');
                });
        }

        function displayPaymentDetails(data) {
            const payment = data.payment;
            const timeline = data.timeline;
            const paymentDetails = data.formatted_payment_details;

            const html = `
<div class="space-y-6">
    <!-- Thông tin cơ bản -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="neu-card-small p-6">
            <h4 class="font-bold text-gray-900 mb-4 text-lg">Thông tin giao dịch</h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Mã giao dịch:</span>
                    <span class="font-semibold text-gray-900">${payment.transaction_id}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Trạng thái:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(payment.status)}">
                        ${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Phương thức thanh toán:</span>
                    <span class="font-semibold text-gray-900">${payment.payment_method.charAt(0).toUpperCase() + payment.payment_method.slice(1)}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="font-medium text-gray-600">Tiền tệ:</span>
                    <span class="font-semibold text-gray-900">${payment.currency}</span>
                </div>
            </div>
        </div>
        <div class="neu-card-small p-6">
            <h4 class="font-bold text-gray-900 mb-4 text-lg">Chi tiết số tiền</h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Số tiền gốc:</span>
                    <span class="font-semibold text-gray-900">${formatCurrency(payment.amount)} ${payment.currency}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Giảm giá:</span>
                    <span class="font-semibold text-green-600">-${formatCurrency(payment.discount_amount)} ${payment.currency}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="font-medium text-gray-600">Số tiền cuối cùng:</span>
                    <span class="text-xl font-bold text-gradient-primary">${formatCurrency(payment.final_amount)} ${payment.currency}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin học viên -->
    <div class="neu-card-small p-6">
        <h4 class="font-bold text-gray-900 mb-4 text-lg">Thông tin học viên</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full secondary-gradient flex items-center justify-center text-white font-bold text-lg">
                    ${payment.student.name.charAt(0).toUpperCase()}
                </div>
                <div>
                    <div class="font-semibold text-gray-900">${payment.student.name}</div>
                    <div class="text-sm text-gray-500">${payment.student.email}</div>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div><span class="font-medium text-gray-600">Số điện thoại:</span> ${payment.student.phone || 'Không có'}</div>
                <div><span class="font-medium text-gray-600">Trạng thái:</span>
                    <span class="${payment.student.is_active ? 'text-green-600' : 'text-red-600'} font-medium">
                        ${payment.student.is_active ? 'Đang hoạt động' : 'Ngừng hoạt động'}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin khóa học -->
    <div class="neu-card-small p-6">
        <h4 class="font-bold text-gray-900 mb-4 text-lg">Thông tin khóa học</h4>
        <div class="space-y-3 text-sm">
            <div><span class="font-medium text-gray-600">Tiêu đề:</span> <span class="font-semibold text-gray-900">${payment.course.title}</span></div>
            <div><span class="font-medium text-gray-600">Giá:</span> <span class="font-semibold text-gray-900">${formatCurrency(payment.course.price)} ${payment.currency}</span></div>
            <div><span class="font-medium text-gray-600">Trình độ:</span> <span class="font-semibold text-gray-900">${payment.course.level.charAt(0).toUpperCase() + payment.course.level.slice(1)}</span></div>
            <div><span class="font-medium text-gray-600">Trạng thái:</span> <span class="font-semibold text-gray-900">${payment.course.status.charAt(0).toUpperCase() + payment.course.status.slice(1)}</span></div>
        </div>
    </div>

    <!-- Mốc thời gian thanh toán -->
    ${timeline.length > 0 ? `
    <div class="neu-card-small p-6">
        <h4 class="font-bold text-gray-900 mb-4 text-lg">Dòng thời gian thanh toán</h4>
        <div class="space-y-4">
            ${timeline.map(item => `
                <div class="flex items-start space-x-4">
                    <div class="w-4 h-4 rounded-full mt-1 ${getTimelineColor(item.status)}"></div>
                    <div class="flex-1">
                        <div class="font-semibold text-sm text-gray-900">${item.title}</div>
                        <div class="text-xs text-gray-600 mt-1">${item.description}</div>
                        <div class="text-xs text-gray-400 mt-1">${formatDate(item.date)}</div>
                    </div>
                </div>
            `).join('')}
        </div>
    </div>
    ` : ''}

    <!-- Chi tiết cổng thanh toán -->
    ${paymentDetails.length > 0 ? `
    <div class="neu-card-small p-6">
        <h4 class="font-bold text-gray-900 mb-4 text-lg">Chi tiết cổng thanh toán</h4>
        <div class="max-h-40 overflow-y-auto">
            <div class="space-y-2 text-sm">
                ${paymentDetails.map(detail => `
                    <div class="flex justify-between items-center py-1 border-b border-gray-50">
                        <span class="font-medium text-gray-600">${detail.key}:</span>
                        <span class="text-gray-900">${detail.value}</span>
                    </div>
                `).join('')}
            </div>
        </div>
    </div>
    ` : ''}

    <!-- Lý do thất bại -->
    ${payment.failure_reason ? `
    <div class="neu-card-small p-6 border-l-4 border-red-400">
        <h4 class="font-bold text-red-800 mb-2 text-lg">Lý do thất bại</h4>
        <p class="text-sm text-red-700 bg-red-50 p-3 rounded-lg">${payment.failure_reason}</p>
    </div>
    ` : ''}
</div>
`;


            document.getElementById('paymentDetails').innerHTML = html;
        }

        function updatePaymentStatus(paymentId, newStatus) {
            currentPaymentId = paymentId;
            document.getElementById('newStatus').value = newStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newStatus = document.getElementById('newStatus').value;
            const reason = document.getElementById('statusReason').value;

            fetch(`/admin/payments/${currentPaymentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus,
                    reason: reason
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment status updated successfully');
                        location.reload();
                    } else {
                        alert('Error updating payment status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating payment status');
                });
        });

        function exportPayments() {
            const url = new URL(window.location);
            url.pathname = '/admin/payments/export';
            window.location.href = url.toString();
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('statusReason').value = '';
        }

        // Utility functions
        function getStatusColor(status) {
            const colors = {
                'pending': 'warning-gradient text-white',
                'completed': 'success-gradient text-white',
                'failed': 'bg-red-100 text-red-800',
                'refunded': 'bg-orange-100 text-orange-800',
                'cancelled': 'bg-gray-100 text-gray-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }

        function getTimelineColor(status) {
            const colors = {
                'info': 'bg-blue-400',
                'success': 'bg-green-400',
                'error': 'bg-red-400',
                'warning': 'bg-yellow-400'
            };
            return colors[status] || 'bg-gray-400';
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleString('vi-VN');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const paymentModal = document.getElementById('paymentModal');
            const statusModal = document.getElementById('statusModal');

            if (event.target === paymentModal) {
                closeModal();
            }
            if (event.target === statusModal) {
                closeStatusModal();
            }
        }

        // Add smooth scrolling and animation effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add entrance animations
            const cards = document.querySelectorAll('.neu-card, .neu-card-small');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection
