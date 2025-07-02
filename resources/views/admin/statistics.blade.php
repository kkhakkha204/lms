@extends('layouts.admin')

@section('title', 'Thống kê')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex items-center justify-between">
                    <div class="relative">
                        <div class="relative">
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent tracking-wide" style="font-family: 'CustomTitle', sans-serif;">
                                Dashboard thống kê
                            </h1>
                            <p class="text-gray-500 mt-2 font-medium">Tổng quan hiệu suất hệ thống E-Learning</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl px-6 py-3 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border border-white/50">
                        <div class="flex items-center space-x-3 text-gray-600">
                            <div class="w-2 h-2 bg-gradient-to-r from-red-600 to-red-700 rounded-full animate-pulse"></div>
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-semibold">{{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="mb-10">
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <form action="{{ route('admin.statistics') }}" method="GET" id="filterForm">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                            <!-- Quick Filter -->
                            <div class="lg:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bộ lọc nhanh</label>
                                <select name="filter" id="quickFilter"
                                        class="w-full px-4 py-3 text-gray-700 font-medium bg-white rounded-xl shadow-[inset_4px_4px_8px_#d1d9e6,inset_-4px_-4px_8px_#ffffff] border border-gray-200/50 focus:outline-none focus:shadow-[inset_6px_6px_12px_#d1d9e6,inset_-6px_-6px_12px_#ffffff] transition-all duration-300">
                                    <option value="today" {{ ($filter ?? 'today') === 'today' ? 'selected' : '' }}>📅 Hôm nay</option>
                                    <option value="week" {{ ($filter ?? 'today') === 'week' ? 'selected' : '' }}>📊 Tuần này</option>
                                    <option value="month" {{ ($filter ?? 'today') === 'month' ? 'selected' : '' }}>📈 Tháng này</option>
                                    <option value="custom" {{ ($filter ?? 'today') === 'custom' ? 'selected' : '' }}>🎛️ Tùy chỉnh</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="lg:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Từ ngày</label>
                                <input type="date" name="start_date" id="startDate"
                                       value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 text-gray-700 font-medium bg-white rounded-xl shadow-[inset_4px_4px_8px_#d1d9e6,inset_-4px_-4px_8px_#ffffff] border border-gray-200/50 focus:outline-none focus:shadow-[inset_6px_6px_12px_#d1d9e6,inset_-6px_-6px_12px_#ffffff] transition-all duration-300">
                            </div>

                            <!-- End Date -->
                            <div class="lg:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Đến ngày</label>
                                <input type="date" name="end_date" id="endDate"
                                       value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 text-gray-700 font-medium bg-white rounded-xl shadow-[inset_4px_4px_8px_#d1d9e6,inset_-4px_-4px_8px_#ffffff] border border-gray-200/50 focus:outline-none focus:shadow-[inset_6px_6px_12px_#d1d9e6,inset_-6px_-6px_12px_#ffffff] transition-all duration-300">
                            </div>

                            <!-- Apply Button -->
                            <div class="lg:col-span-3">
                                <button type="submit"
                                        class="w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] hover:shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] transition-all duration-300 hover:from-red-700 hover:to-red-800">
                                    <span class="flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <span>Áp dụng</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tổng doanh thu</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($additionalStats['total_revenue'], 0, ',', '.') }}₫</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tổng đơn hàng</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($additionalStats['total_orders']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Học viên mới</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($additionalStats['total_students']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Average Order -->
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Giá trị TB/đơn</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($additionalStats['average_order'], 0, ',', '.') }}₫</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart Section -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-[20px_20px_40px_#d1d9e6,-20px_-20px_40px_#ffffff] border border-white/50 overflow-hidden">
                    <div class="p-8 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Biểu đồ Doanh Thu</h2>
                                    <p class="text-gray-500 mt-1 font-medium">Xu hướng doanh thu từ {{ $startDate->format('d/m/Y') }} đến {{ $endDate->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 shadow-[inset_8px_8px_16px_#d1d9e6,inset_-8px_-8px_16px_#ffffff]">
                            <canvas id="revenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row with Top Courses and Top Customers -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Top Courses Section -->
                <div class="bg-white rounded-3xl shadow-[20px_20px_40px_#d1d9e6,-20px_-20px_40px_#ffffff] border border-white/50 overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center shadow-[6px_6px_12px_#d1d9e6,-6px_-6px_12px_#ffffff]">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Top 5 Khóa Học</h3>
                                <p class="text-gray-500 text-sm font-medium">Bán chạy nhất</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 max-h-96 overflow-y-auto">
                        @forelse ($topCourses as $index => $course)
                            <div class="mb-3 last:mb-0">
                                <div class="bg-white rounded-xl p-4 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border border-white/50">
                                    <div class="flex items-center">
                                        <!-- Ranking -->
                                        <div class="flex-shrink-0 mr-4">
                                            @php
                                                $rankColors = [
                                                    0 => 'from-yellow-400 to-yellow-600',
                                                    1 => 'from-gray-400 to-gray-600',
                                                    2 => 'from-orange-400 to-orange-600'
                                                ];
                                                $defaultColor = 'from-red-600 to-red-700';
                                            @endphp
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $rankColors[$index] ?? $defaultColor }} flex items-center justify-center text-white font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>

                                        <!-- Course Image -->
                                        <div class="flex-shrink-0 mr-4">
                                            @if ($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                     alt="{{ $course->title }}"
                                                     class="w-12 h-12 object-cover rounded-lg shadow-md border border-white">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center shadow-md border border-white">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Course Info -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 truncate text-sm">{{ $course->title }}</h4>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500 mt-1">
                                                <span>{{ $course->enrollment_count }} đăng ký</span>
                                                @if($course->total_revenue)
                                                    <span>{{ number_format($course->total_revenue, 0, ',', '.') }}₫</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-700 mb-2">Chưa có dữ liệu</h4>
                                <p class="text-gray-500 text-sm">Chưa có khóa học nào được đăng ký.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Top Customers Section -->
                <div class="bg-white rounded-3xl shadow-[20px_20px_40px_#d1d9e6,-20px_-20px_40px_#ffffff] border border-white/50 overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-[6px_6px_12px_#d1d9e6,-6px_-6px_12px_#ffffff]">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Top 5 Khách Hàng</h3>
                                <p class="text-gray-500 text-sm font-medium">Mua nhiều nhất</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 max-h-96 overflow-y-auto">
                        @forelse ($topCustomers as $index => $customer)
                            <div class="mb-3 last:mb-0">
                                <div class="bg-white rounded-xl p-4 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border border-white/50">
                                    <div class="flex items-center">
                                        <!-- Ranking -->
                                        <div class="flex-shrink-0 mr-4">
                                            @php
                                                $rankColors = [
                                                    0 => 'from-yellow-400 to-yellow-600',
                                                    1 => 'from-gray-400 to-gray-600',
                                                    2 => 'from-orange-400 to-orange-600'
                                                ];
                                                $defaultColor = 'from-blue-600 to-blue-700';
                                            @endphp
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $rankColors[$index] ?? $defaultColor }} flex items-center justify-center text-white font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>

                                        <!-- Customer Avatar -->
                                        <div class="flex-shrink-0 mr-4">
                                            @if ($customer->avatar)
                                                <img src="{{ $customer->avatar_url }}"
                                                     alt="{{ $customer->name }}"
                                                     class="w-12 h-12 object-cover rounded-lg shadow-md border border-white">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shadow-md border border-white">
                                                    <span class="text-blue-600 font-semibold text-sm">{{ substr($customer->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Customer Info -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 truncate text-sm">{{ $customer->name }}</h4>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500 mt-1">
                                                <span>{{ $customer->total_orders }} đơn hàng</span>
                                                <span>{{ $customer->courses_purchased }} khóa học</span>
                                            </div>
                                        </div>

                                        <!-- Customer Stats -->
                                        <div class="flex-shrink-0 text-right">
                                            <div class="text-sm font-bold text-gray-800">{{ number_format($customer->total_spent, 0, ',', '.') }}₫</div>
                                            <div class="text-xs text-gray-500">Tổng chi tiêu</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-700 mb-2">Chưa có dữ liệu</h4>
                                <p class="text-gray-500 text-sm">Chưa có khách hàng nào mua hàng.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle quick filter changes
            const quickFilter = document.getElementById('quickFilter');
            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');
            const filterForm = document.getElementById('filterForm');

            quickFilter.addEventListener('change', function() {
                const value = this.value;
                const today = new Date();

                if (value === 'today') {
                    const todayStr = today.toISOString().split('T')[0];
                    startDate.value = todayStr;
                    endDate.value = todayStr;
                    filterForm.submit();
                } else if (value === 'week') {
                    const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                    const endOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                    startDate.value = startOfWeek.toISOString().split('T')[0];
                    endDate.value = endOfWeek.toISOString().split('T')[0];
                    filterForm.submit();
                } else if (value === 'month') {
                    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    startDate.value = startOfMonth.toISOString().split('T')[0];
                    endDate.value = endOfMonth.toISOString().split('T')[0];
                    filterForm.submit();
                }
                // For 'custom', do nothing - let user pick dates manually
            });

            // Revenue Chart
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Create sophisticated gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(126, 2, 2, 0.3)');
            gradient.addColorStop(0.5, 'rgba(237, 41, 42, 0.2)');
            gradient.addColorStop(1, 'rgba(237, 41, 42, 0.05)');

            // Border gradient
            const borderGradient = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);
            borderGradient.addColorStop(0, '#7e0202');
            borderGradient.addColorStop(0.5, '#ed292a');
            borderGradient.addColorStop(1, '#7e0202');

            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [@foreach ($revenueData as $data) '{{ $data['date'] }}', @endforeach],
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: [@foreach ($revenueData as $data) {{ $data['total_revenue'] }}, @endforeach],
                        borderColor: borderGradient,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#ed292a',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#7e0202',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(28, 28, 28, 0.95)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#ed292a',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: false,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13,
                                weight: '500'
                            },
                            padding: 12,
                            caretSize: 8,
                            callbacks: {
                                title: function(context) {
                                    return 'Thời gian: ' + context[0].label;
                                },
                                label: function(context) {
                                    return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + '₫';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Thời gian',
                                color: '#6B7280',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            grid: {
                                display: true,
                                color: 'rgba(209, 217, 230, 0.3)',
                                lineWidth: 1
                            },
                            border: {
                                color: '#E5E7EB',
                                width: 2
                            },
                            ticks: {
                                color: '#6B7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 10,
                                maxRotation: 45
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Doanh thu (VND)',
                                color: '#6B7280',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(209, 217, 230, 0.3)',
                                lineWidth: 1
                            },
                            border: {
                                color: '#E5E7EB',
                                width: 2
                            },
                            ticks: {
                                color: '#6B7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 15,
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', {
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value) + '₫';
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 8
                        },
                        line: {
                            borderJoinStyle: 'round',
                            borderCapStyle: 'round'
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            // Add chart animation on load
            setTimeout(() => {
                revenueChart.update('show');
            }, 300);

            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Apply animation to cards
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });

            // Add hover effects
            const hoverCards = document.querySelectorAll('[class*="shadow-"]');
            hoverCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

    <style>
        /* Enhanced chart container */
        #revenueChart {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        /* Smooth loading animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Custom scrollbar for overflow areas */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
        }
    </style>
@endsection
