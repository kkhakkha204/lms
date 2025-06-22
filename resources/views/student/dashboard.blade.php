{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - E-Learning LMS')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-2 text-gray-600">Chào mừng {{ Auth::user()->name }} trở lại! Theo dõi tiến độ học tập của bạn.</p>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Courses --}}
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tổng khóa học</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Completed Courses --}}
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Đã hoàn thành</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_courses'] }}</p>
                    </div>
                </div>
            </div>

            {{-- In Progress --}}
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Đang học</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress_courses'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Certificates --}}
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-certificate text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Chứng chỉ</p>
                        <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->certificates()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content - My Courses --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Khóa học của tôi</h2>
                            <div class="flex space-x-2">
                                <button class="filter-btn active px-3 py-1 text-sm rounded-md bg-blue-600 text-white" data-filter="all">
                                    Tất cả
                                </button>
                                <button class="filter-btn px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="in-progress">
                                    Đang học
                                </button>
                                <button class="filter-btn px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="completed">
                                    Hoàn thành
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($enrollments->count() > 0)
                            <div class="space-y-4" id="courses-list">
                                @foreach($enrollments as $enrollment)
                                    @php
                                        $course = $enrollment->course;
                                        $status = 'not-started';
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                        $statusText = 'Chưa bắt đầu';
                                        $actionText = 'Bắt đầu học';
                                        $actionClass = 'text-blue-600 hover:text-blue-700';
                                        $progressColor = 'bg-gray-400';

                                        if ($enrollment->progress_percentage >= 100) {
                                            $status = 'completed';
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusText = 'Hoàn thành';
                                            $actionText = 'Xem chứng chỉ';
                                            $actionClass = 'text-purple-600 hover:text-purple-700';
                                            $progressColor = 'bg-green-500';
                                        } elseif ($enrollment->progress_percentage > 0) {
                                            $status = 'in-progress';
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            $statusText = 'Đang học';
                                            $actionText = 'Tiếp tục học';
                                            $actionClass = 'text-blue-600 hover:text-blue-700';
                                            $progressColor = 'bg-blue-600';
                                        }
                                    @endphp

                                    <div class="course-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" data-status="{{ $status }}">
                                        <div class="flex items-start space-x-4">
                                            <img src="{{ $course->thumbnail_url ?: 'https://via.placeholder.com/80x60/3B82F6/ffffff?text=' . substr($course->title, 0, 1) }}"
                                                 alt="{{ $course->title }}"
                                                 class="w-20 h-15 rounded-lg object-cover flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                            {{ $course->title }}
                                                        </h3>
                                                        <p class="text-sm text-gray-600 mt-1">Instructor: {{ $course->instructor->name }}</p>
                                                        <div class="flex items-center mt-2 space-x-4">
                                                        <span class="text-xs text-gray-500">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            @if($enrollment->completed_at)
                                                                Hoàn thành: {{ $enrollment->completed_at->format('d/m/Y') }}
                                                            @else
                                                                Đăng ký: {{ $enrollment->enrolled_at->format('d/m/Y') }}
                                                            @endif
                                                        </span>
                                                            <span class="text-xs text-gray-500">
                                                            <i class="fas fa-play-circle mr-1"></i>
                                                            {{ $enrollment->lessons_completed }}/{{ $course->total_lessons }} bài học
                                                        </span>
                                                            @if($enrollment->completed_at && $enrollment->average_quiz_score)
                                                                <span class="text-xs text-green-600">
                                                                <i class="fas fa-star mr-1"></i>
                                                                Điểm: {{ number_format($enrollment->average_quiz_score, 0) }}%
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col items-end space-y-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                        {{ $statusText }}
                                                    </span>
                                                        @if($enrollment->progress_percentage >= 100 && $enrollment->certificate)
                                                            <a href="{{ route('certificates.show', $enrollment->certificate->certificate_code) }}"
                                                               class="{{ $actionClass }} text-sm font-medium">
                                                                {{ $actionText }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('learning.index', $course->slug) }}"
                                                               class="{{ $actionClass }} text-sm font-medium">
                                                                {{ $actionText }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Progress Bar --}}
                                                <div class="mt-4">
                                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                                        <span>Tiến độ</span>
                                                        <span>{{ $enrollment->progress_percentage }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-300"
                                                             style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- Empty State --}}
                            <div class="text-center py-12" id="empty-state">
                                <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-book-open text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Không có khóa học nào</h3>
                                <p class="text-gray-500 mb-6">Bạn chưa đăng ký khóa học nào. Hãy khám phá các khóa học của chúng tôi!</p>
                                <a href="{{ route('student.courses.index') }}"
                                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Khám phá khóa học
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Recent Certificates --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Chứng chỉ gần đây</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $recentCertificates = Auth::user()->certificates()
                                ->with('course')
                                ->orderBy('issued_at', 'desc')
                                ->limit(3)
                                ->get();
                        @endphp

                        @if($recentCertificates->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentCertificates as $certificate)
                                    <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg border border-purple-100">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-certificate text-purple-600"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $certificate->course->title }}</p>
                                            <p class="text-xs text-gray-500">Cấp ngày: {{ $certificate->formatted_issued_date }}</p>
                                            <p class="text-xs text-green-600 font-medium">
                                                Điểm: {{ number_format($certificate->final_score, 0) }}% - {{ $certificate->grade }}
                                            </p>
                                        </div>
                                        <a href="{{ $certificate->download_url }}"
                                           class="text-purple-600 hover:text-purple-700"
                                           target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('certificates.index') }}"
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Xem tất cả chứng chỉ →
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-certificate text-gray-400"></i>
                                </div>
                                <p class="text-sm text-gray-500">Chưa có chứng chỉ nào</p>
                                <p class="text-xs text-gray-400 mt-1">Hoàn thành khóa học để nhận chứng chỉ</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Hành động nhanh</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('student.courses.index') }}"
                               class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-search text-blue-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Khám phá khóa học</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>

                            <div class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-star text-green-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Đánh giá khóa học</span>
                                </div>
                                @if($reviewStats['pending_reviews'] > 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $reviewStats['pending_reviews'] }}</span>
                                @endif
                            </div>

                            <a href="{{ route('profile.edit') }}"
                               class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-edit text-purple-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Cập nhật hồ sơ</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Learning Streak (Optional) --}}
                <div class="bg-gradient-to-br from-orange-400 via-red-400 to-pink-400 rounded-lg shadow-sm text-white">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Chuỗi học tập</h3>
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-fire text-xl"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            @php
                                // Tính toán chuỗi học tập dựa trên last_login_at và updated_at của enrollments
                                $currentStreak = 7; // Placeholder - cần implement logic thực tế
                            @endphp
                            <div class="text-3xl font-bold mb-1">{{ $currentStreak }}</div>
                            <p class="text-sm opacity-90">ngày liên tiếp</p>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-xs opacity-75">Bạn đang làm rất tốt! Hãy tiếp tục duy trì.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Filter functionality
            document.addEventListener('DOMContentLoaded', function() {
                const filterButtons = document.querySelectorAll('.filter-btn');
                const courseCards = document.querySelectorAll('.course-card');

                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const filter = this.getAttribute('data-filter');

                        // Update active button
                        filterButtons.forEach(btn => {
                            btn.classList.remove('active', 'bg-blue-600', 'text-white');
                            btn.classList.add('bg-gray-100', 'text-gray-700');
                        });
                        this.classList.add('active', 'bg-blue-600', 'text-white');
                        this.classList.remove('bg-gray-100', 'text-gray-700');

                        // Filter courses
                        let visibleCount = 0;
                        courseCards.forEach(card => {
                            const status = card.getAttribute('data-status');
                            if (filter === 'all' || status === filter) {
                                card.style.display = 'block';
                                visibleCount++;
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

                // Progress bar animations
                function animateProgressBars() {
                    const progressBars = document.querySelectorAll('.course-card .bg-blue-600, .course-card .bg-green-500');
                    progressBars.forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });
                }

                // Call animation on page load
                setTimeout(animateProgressBars, 500);
            });
        </script>
    @endpush
@endsection
