@extends('layouts.admin')

@section('title', 'Thống kê')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex items-center justify-between">
                    <div class="relative">
                        <div class="relative ">
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">
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
                            <span class="font-semibold">{{ now()->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="mb-10">
                <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50">
                    <form action="{{ route('admin.statistics') }}" method="GET" class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center shadow-[4px_4px_8px_#d1d9e6,-4px_-4px_8px_#ffffff]">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                    </svg>
                                </div>
                                <span class="text-lg font-semibold text-gray-700">Bộ lọc thời gian</span>
                            </div>
                            <select name="filter" onchange="this.form.submit()"
                                    class="px-6 py-3 text-gray-700 font-medium bg-white rounded-xl shadow-[inset_4px_4px_8px_#d1d9e6,inset_-4px_-4px_8px_#ffffff] border border-gray-200/50 focus:outline-none focus:shadow-[inset_6px_6px_12px_#d1d9e6,inset_-6px_-6px_12px_#ffffff] transition-all duration-300">
                                <option value="day" {{ ($filter ?? 'day') === 'day' ? 'selected' : '' }}>📅 Theo ngày</option>
                                <option value="week" {{ ($filter ?? 'day') === 'week' ? 'selected' : '' }}>📊 Theo tuần</option>
                                <option value="month" {{ ($filter ?? 'day') === 'month' ? 'selected' : '' }}>📈 Theo tháng</option>
                            </select>
                        </div>
                        <div class="flex items-center px-5 py-3 bg-gradient-to-r from-green-50 to-emerald-50 text-emerald-700 rounded-xl shadow-[4px_4px_8px_#d1d9e6,-4px_-4px_8px_#ffffff] border border-emerald-100">
                            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="font-semibold">Tự động cập nhật</span>
                        </div>
                    </form>
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
                                    <p class="text-gray-500 mt-1 font-medium">Xu hướng doanh thu theo thời gian</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-6 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                                    <div class="text-3xl font-bold text-white">
                                        {{ number_format(collect($revenueData)->sum('total_revenue'), 0, ',', '.') }}₫
                                    </div>
                                    <div class="text-red-100 text-sm font-medium mt-1">Tổng doanh thu</div>
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

            <!-- Top Courses Section -->
            <div class="bg-white rounded-3xl shadow-[20px_20px_40px_#d1d9e6,-20px_-20px_40px_#ffffff] border border-white/50 overflow-hidden mb-12">
                <div class="p-8 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Top 5 Khóa Học Bán Chạy</h2>
                                <p class="text-gray-500 mt-1 font-medium">Những khóa học có nhiều đăng ký nhất</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700 rounded-2xl shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border border-emerald-200/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="font-semibold">Hiệu suất cao</span>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    @forelse ($topCourses as $index => $course)
                        <div class="mb-4 last:mb-0">
                            <div class="bg-white rounded-2xl p-6 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] border border-white/50 hover:shadow-[16px_16px_32px_#d1d9e6,-16px_-16px_32px_#ffffff] transition-all duration-300">
                                <div class="flex items-center">
                                    <!-- Ranking Badge -->
                                    <div class="flex-shrink-0 mr-6">
                                        @php
                                            $rankColors = [
                                                0 => 'from-yellow-400 to-yellow-600',
                                                1 => 'from-gray-400 to-gray-600',
                                                2 => 'from-orange-400 to-orange-600'
                                            ];
                                            $defaultColor = 'from-red-600 to-red-700';
                                        @endphp
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $rankColors[$index] ?? $defaultColor }} flex items-center justify-center shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] text-white font-bold text-lg">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>

                                    <!-- Course Image -->
                                    <div class="flex-shrink-0 mr-6">
                                        <div class="relative">
                                            @if ($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                     alt="{{ $course->title }}"
                                                     class="w-20 h-20 object-cover rounded-2xl shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border-2 border-white">
                                            @else
                                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff] border-2 border-white">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-r from-red-600 to-red-700 rounded-full flex items-center justify-center shadow-[4px_4px_8px_#d1d9e6,-4px_-4px_8px_#ffffff]">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Course Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-lg text-gray-800 truncate mb-2">{{ $course->title }}</h3>
                                        <div class="flex items-center space-x-6 text-sm">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
                                                <span class="text-gray-600 font-medium">{{ $course->category ? $course->category->name : 'Chưa phân loại' }}</span>
                                            </div>
                                            @if($course->is_free)
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full"></div>
                                                    <span class="text-emerald-600 font-semibold">Miễn phí</span>
                                                </div>
                                            @else
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-3 h-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full"></div>
                                                    <span class="text-gray-600 font-semibold">{{ number_format($course->display_price, 0, ',', '.') }}₫</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="flex-shrink-0">
                                        <!-- Enrollment Stats -->
                                        <div class="text-center">
                                            <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl px-4 py-2 shadow-[6px_6px_12px_#d1d9e6,-6px_-6px_12px_#ffffff]">
                                                <div class="text-xl font-bold text-white">{{ number_format($course->enrollment_count) }}</div>
                                                <div class="text-red-100 text-xs font-medium">đăng ký</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-200 to-gray-300 rounded-3xl flex items-center justify-center shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff]">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700 mb-3">Chưa có dữ liệu</h3>
                            <p class="text-gray-500 font-medium">Chưa có khóa học nào được đăng ký.</p>
                        </div>
                    @endforelse
                </div>
            </div>


        </div>
    </div>

    <!-- Enhanced Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        pointShadowColor: 'rgba(126, 2, 2, 0.3)',
                        pointShadowBlur: 10
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
                                    return 'Ngày: ' + context[0].label;
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
                                padding: 10
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
        });

        // Add some interactive enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Animate statistics cards on scroll
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

            // Add hover effects for enhanced interactivity
            const courseCards = document.querySelectorAll('[class*="shadow-"]');
            courseCards.forEach(card => {
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
        /* Additional custom styles for enhanced neumorphism */
        .shadow-neumorphism {
            box-shadow: 20px 20px 40px #d1d9e6, -20px -20px 40px #ffffff;
        }

        .shadow-neumorphism-inset {
            box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
        }

        .shadow-neumorphism-hover:hover {
            box-shadow: 25px 25px 50px #d1d9e6, -25px -25px 50px #ffffff;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        /* Custom gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #7e0202 0%, #ed292a 100%);
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

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

        /* Progress bar animation */
        @keyframes progressLoad {
            from {
                width: 0%;
            }
        }

        .animate-progress {
            animation: progressLoad 1.5s ease-out;
        }
    </style>
@endsection
