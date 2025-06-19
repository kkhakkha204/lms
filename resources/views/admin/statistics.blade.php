@extends('layouts.app')

@section('title', 'Thống kê')

@section('content')
    <div class="min-h-screen bg-gray-50/30">
        <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Thống kê Dashboard</h1>
                        <p class="text-sm text-gray-500 mt-1">Tổng quan hiệu suất hệ thống</p>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="mb-8">
                <div class="bg-white rounded-lg border border-gray-100 p-4">
                    <form action="{{ route('admin.statistics') }}" method="GET" class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Bộ lọc thời gian:</span>
                        </div>
                        <select name="filter" onchange="this.form.submit()"
                                class="px-3 py-2 text-sm border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors duration-200">
                            <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>Theo ngày</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>Theo tuần</option>
                            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Theo tháng</option>
                        </select>
                        <div class="flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-md text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Tự động cập nhật
                        </div>
                    </form>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="mb-8">
                <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Biểu đồ doanh thu</h2>
                                <p class="text-sm text-gray-500 mt-1">Xu hướng doanh thu theo thời gian</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <!-- Revenue Summary -->
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ number_format(collect($revenueData)->sum('total_revenue'), 0, ',', '.') }}₫
                                    </div>
                                    <div class="text-xs text-gray-500">Tổng doanh thu</div>
                                </div>
                                <div class="w-2 h-12 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="relative">
                            <canvas id="revenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Courses Section -->
            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Top 5 khóa học bán chạy</h2>
                            <p class="text-sm text-gray-500 mt-1">Những khóa học có nhiều đăng ký nhất</p>
                        </div>
                        <div class="flex items-center space-x-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>Hiệu suất cao</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden">
                    @forelse ($topCourses as $index => $course)
                        <div class="flex items-center p-6 border-b border-gray-50 last:border-b-0 hover:bg-gray-50/50 transition-colors duration-200">
                            <!-- Ranking -->
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' :
                                           ($index === 1 ? 'bg-gray-100 text-gray-700' :
                                           ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700')) }}">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            <!-- Course Image -->
                            <div class="flex-shrink-0 mr-4">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                         alt="{{ $course->title }}"
                                         class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Course Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 truncate">{{ $course->title }}</h3>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                                    <span>{{ $course->category->name ?? 'Chưa phân loại' }}</span>
                                    @if($course->price)
                                        <span>{{ number_format($course->price, 0, ',', '.') }}₫</span>
                                    @else
                                        <span class="text-emerald-600">Miễn phí</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Enrollment Stats -->
                            <div class="flex-shrink-0 text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ number_format($course->enrollment_count) }}</div>
                                <div class="text-xs text-gray-500">đăng ký</div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="flex-shrink-0 ml-6 w-20">
                                @php
                                    $maxEnrollments = $topCourses->max('enrollment_count');
                                    $percentage = $maxEnrollments > 0 ? ($course->enrollment_count / $maxEnrollments) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-gradient-to-r
                                            {{ $index === 0 ? 'from-yellow-400 to-yellow-600' :
                                               ($index === 1 ? 'from-gray-400 to-gray-600' :
                                               ($index === 2 ? 'from-orange-400 to-orange-600' : 'from-blue-400 to-blue-600')) }}"
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 text-center">{{ round($percentage) }}%</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-medium text-gray-900 mb-2">Chưa có dữ liệu</h3>
                            <p class="text-sm text-gray-500">Chưa có khóa học nào được đăng ký.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Additional Stats Cards -->
            @if(isset($additionalStats))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-white rounded-lg border border-gray-100 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-semibold text-gray-900">{{ number_format($additionalStats['total_students'] ?? 0) }}</div>
                                <div class="text-sm text-gray-500">Tổng học viên</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-100 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-semibold text-gray-900">{{ number_format($additionalStats['total_courses'] ?? 0) }}</div>
                                <div class="text-sm text-gray-500">Tổng khóa học</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-100 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-semibold text-gray-900">{{ number_format($additionalStats['completion_rate'] ?? 0, 1) }}%</div>
                                <div class="text-sm text-gray-500">Tỷ lệ hoàn thành</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Gradient for the chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');

            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [@foreach ($revenueData as $data) '{{ $data['date'] }}', @endforeach],
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: [@foreach ($revenueData as $data) {{ $data['total_revenue'] }}, @endforeach],
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
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
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
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
                                    size: 12
                                }
                            },
                            grid: {
                                display: false
                            },
                            border: {
                                color: '#E5E7EB'
                            },
                            ticks: {
                                color: '#6B7280',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Doanh thu (VND)',
                                color: '#6B7280',
                                font: {
                                    size: 12
                                }
                            },
                            beginAtZero: true,
                            grid: {
                                color: '#F3F4F6'
                            },
                            border: {
                                color: '#E5E7EB'
                            },
                            ticks: {
                                color: '#6B7280',
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', {
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value) + '₫';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
