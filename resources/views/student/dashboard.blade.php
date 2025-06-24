{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - E-Learning LMS')

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Hero Section with Gradient --}}
        <div class="bg-gradient-to-br from-[#ed292a] via-[#1c1c1c] to-[#7e0202] relative overflow-hidden pt-32">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-10 left-10 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
                <div class="absolute bottom-10 right-10 w-40 h-40 bg-[#ed292a]/10 rounded-full blur-2xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'CustomTitle', sans-serif; ">
                        Chào mừng trở lại, <span class="text-[#ed292a]">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                        Tiếp tục hành trình học tập của bạn và khám phá những kiến thức mới mỗi ngày
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
            {{-- Statistics Cards - Floating Design --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                {{-- Total Courses --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-[#ed292a]/20 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">{{ $stats['total_courses'] }}</p>
                            <p class="text-sm font-medium text-gray-500">Tổng khóa học</p>
                        </div>
                    </div>
                    <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full group-hover:from-[#ed292a] group-hover:to-[#7e0202] transition-all duration-500" style="width: 100%"></div>
                    </div>
                </div>

                {{-- Completed Courses --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-[#ed292a]/20 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">{{ $stats['completed_courses'] }}</p>
                            <p class="text-sm font-medium text-gray-500">Đã hoàn thành</p>
                        </div>
                    </div>
                    <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                        @php $completionRate = $stats['total_courses'] > 0 ? ($stats['completed_courses'] / $stats['total_courses']) * 100 : 0; @endphp
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full group-hover:from-[#ed292a] group-hover:to-[#7e0202] transition-all duration-500" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>

                {{-- In Progress --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-[#ed292a]/20 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">{{ $stats['in_progress_courses'] }}</p>
                            <p class="text-sm font-medium text-gray-500">Đang học</p>
                        </div>
                    </div>
                    <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                        @php $progressRate = $stats['total_courses'] > 0 ? ($stats['in_progress_courses'] / $stats['total_courses']) * 100 : 0; @endphp
                        <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full group-hover:from-[#ed292a] group-hover:to-[#7e0202] transition-all duration-500" style="width: {{ $progressRate }}%"></div>
                    </div>
                </div>

                {{-- Certificates --}}
                <div class="group bg-[#1c1c1c] rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-[#ed292a]/20 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#7e0202] to-[#ed292a] rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white  transition-colors">{{ Auth::user()->certificates()->count() }}</p>
                            <p class="text-sm font-medium text-gray-200">Chứng chỉ</p>
                        </div>
                    </div>
                    <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#7e0202] to-[#ed292a] rounded-full transition-all duration-500" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
                {{-- Main Content - My Courses --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1c1c1c] to-[#2a2a2a] p-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-white mb-2">Khóa học của tôi</h2>
                                    <p class="text-gray-300">Theo dõi tiến độ và tiếp tục học tập</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="filter-btn active px-4 py-2 text-sm rounded-xl bg-[#ed292a] text-white font-medium hover:bg-[#7e0202] transition-all duration-200" data-filter="all">
                                        Tất cả
                                    </button>
                                    <button class="filter-btn px-4 py-2 text-sm rounded-xl bg-white/10 text-white font-medium hover:bg-white/20 transition-all duration-200" data-filter="in-progress">
                                        Đang học
                                    </button>
                                    <button class="filter-btn px-4 py-2 text-sm rounded-xl bg-white/10 text-white font-medium hover:bg-white/20 transition-all duration-200" data-filter="completed">
                                        Hoàn thành
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            @if($enrollments->count() > 0)
                                <div class="space-y-6" id="courses-list">
                                    @foreach($enrollments as $enrollment)
                                        @php
                                            $course = $enrollment->course;
                                            $status = 'not-started';
                                            $statusClass = 'bg-gray-100 text-gray-700';
                                            $statusText = 'Chưa bắt đầu';
                                            $actionText = 'Bắt đầu học';
                                            $actionClass = 'text-[#ed292a] hover:text-[#7e0202]';
                                            $progressColor = 'from-gray-300 to-gray-400';
                                            $cardBorder = 'border-gray-200';

                                            if ($enrollment->progress_percentage >= 100) {
                                                $status = 'completed';
                                                $statusClass = 'bg-emerald-100 text-emerald-800';
                                                $statusText = 'Hoàn thành';
                                                $actionText = 'Xem chứng chỉ';
                                                $actionClass = 'text-emerald-600 hover:text-emerald-700';
                                                $progressColor = 'from-emerald-400 to-emerald-500';
                                                $cardBorder = 'border-emerald-200';
                                            } elseif ($enrollment->progress_percentage > 0) {
                                                $status = 'in-progress';
                                                $statusClass = 'bg-amber-100 text-amber-800';
                                                $statusText = 'Đang học';
                                                $actionText = 'Tiếp tục học';
                                                $actionClass = 'text-[#ed292a] hover:text-[#7e0202]';
                                                $progressColor = 'from-[#ed292a] to-[#7e0202]';
                                                $cardBorder = 'border-[#ed292a]/20';
                                            }
                                        @endphp

                                        <div class="course-card group border-2 {{ $cardBorder }} rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gradient-to-br from-white to-gray-50/50" data-status="{{ $status }}">
                                            <div class="flex items-start space-x-6">
                                                <div class="relative">
                                                    <img src="{{ $course->thumbnail_url ?: 'https://via.placeholder.com/120x80/1c1c1c/ffffff?text=' . substr($course->title, 0, 1) }}"
                                                         alt="{{ $course->title }}"
                                                         class="w-24 h-18 rounded-xl object-cover shadow-md group-hover:shadow-lg transition-shadow">
                                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-br {{ $progressColor }} rounded-full flex items-center justify-center">
                                                        @if($enrollment->progress_percentage >= 100)
                                                            <i class="fas fa-check text-white text-xs"></i>
                                                        @elseif($enrollment->progress_percentage > 0)
                                                            <i class="fas fa-play text-white text-xs"></i>
                                                        @else
                                                            <i class="fas fa-circle text-white text-xs"></i>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between mb-4">
                                                        <div class="flex-1">
                                                            <h3 class="text-xl font-bold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors mb-2">
                                                                {{ $course->title }}
                                                            </h3>
                                                            <p class="text-gray-600 mb-3">Giảng viên: <span class="font-semibold">{{ $course->instructor->name }}</span></p>

                                                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                                                <span class="flex items-center">
                                                                    <i class="fas fa-calendar-alt mr-2"></i>
                                                                    @if($enrollment->completed_at)
                                                                        Hoàn thành: {{ $enrollment->completed_at->format('d/m/Y') }}
                                                                    @else
                                                                        Đăng ký: {{ $enrollment->enrolled_at->format('d/m/Y') }}
                                                                    @endif
                                                                </span>
                                                                <span class="flex items-center">
                                                                    <i class="fas fa-play-circle mr-2"></i>
                                                                    {{ $enrollment->lessons_completed }}/{{ $course->total_lessons }} bài học
                                                                </span>
                                                                @if($enrollment->completed_at && $enrollment->average_quiz_score)
                                                                    <span class="flex items-center text-emerald-600 font-semibold">
                                                                        <i class="fas fa-star mr-2"></i>
                                                                        Điểm: {{ number_format($enrollment->average_quiz_score, 0) }}%
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col items-end space-y-3">
                                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }}">
                                                                {{ $statusText }}
                                                            </span>
                                                            @if($enrollment->progress_percentage >= 100 && $enrollment->certificate)
                                                                <a href="{{ route('certificates.show', $enrollment->certificate->certificate_code) }}"
                                                                   class="{{ $actionClass }} text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                                                    {{ $actionText }} →
                                                                </a>
                                                            @else
                                                                <a href="{{ route('learning.index', $course->slug) }}"
                                                                   class="{{ $actionClass }} text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                                                    {{ $actionText }} →
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Enhanced Progress Bar --}}
                                                    <div class="mt-6">
                                                        <div class="flex items-center justify-between text-sm font-medium text-gray-700 mb-3">
                                                            <span>Tiến độ học tập</span>
                                                            <span class="text-[#7e0202]">{{ $enrollment->progress_percentage }}%</span>
                                                        </div>
                                                        <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                                            <div class="absolute inset-0 bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-1000 ease-out shadow-sm"
                                                                 style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent rounded-full animate-pulse"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {{-- Enhanced Empty State --}}
                                <div class="text-center py-16" id="empty-state">
                                    <div class="w-32 h-32 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                        <i class="fas fa-book-open text-4xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-[#1c1c1c] mb-4">Bắt đầu hành trình học tập</h3>
                                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Khám phá thế giới kiến thức với hàng trăm khóa học chất lượng cao được thiết kế dành cho bạn.</p>
                                    <a href="{{ route('student.courses.index') }}"
                                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                        <i class="fas fa-rocket mr-3"></i>
                                        Khám phá khóa học
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Enhanced Sidebar --}}
                <div class="space-y-8">
                    {{-- Recent Certificates --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] p-6">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-award mr-3"></i>
                                Chứng chỉ gần đây
                            </h3>
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
                                        <div class="group flex items-center space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition-all duration-300">
                                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <i class="fas fa-certificate text-white"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-[#1c1c1c] truncate group-hover:text-[#7e0202] transition-colors">{{ $certificate->course->title }}</p>
                                                <p class="text-sm text-gray-500">{{ $certificate->formatted_issued_date }}</p>
                                                <p class="text-sm text-emerald-600 font-semibold">
                                                    {{ number_format($certificate->final_score, 0) }}% - {{ $certificate->grade }}
                                                </p>
                                            </div>
                                            <a href="{{ $certificate->download_url }}"
                                               class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm hover:shadow-md hover:bg-[#ed292a] hover:text-white transition-all duration-200"
                                               target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-6 text-center">
                                    <a href="{{ route('certificates.index') }}"
                                       class="inline-flex items-center text-[#ed292a] hover:text-[#7e0202] font-semibold transition-colors">
                                        Xem tất cả chứng chỉ
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-certificate text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-600 font-medium">Chưa có chứng chỉ nào</p>
                                    <p class="text-sm text-gray-500 mt-2">Hoàn thành khóa học để nhận chứng chỉ</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1c1c1c] to-[#2a2a2a] p-6">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-bolt mr-3"></i>
                                Hành động nhanh
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <a href="{{ route('student.courses.index') }}"
                                   class="group w-full flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 rounded-xl transition-all duration-300 border border-blue-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-search text-white"></i>
                                        </div>
                                        <span class="font-semibold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">Khám phá khóa học</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-[#ed292a] transition-colors"></i>
                                </a>

                                <div class="group w-full flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-green-50 hover:from-emerald-100 hover:to-green-100 rounded-xl transition-all duration-300 border border-emerald-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-star text-white"></i>
                                        </div>
                                        <span class="font-semibold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">Đánh giá khóa học</span>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if($reviewStats['pending_reviews'] > 0)
                                            <span class="bg-[#ed292a] text-white text-sm px-3 py-1 rounded-full font-semibold">{{ $reviewStats['pending_reviews'] }}</span>
                                        @endif
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-[#ed292a] transition-colors"></i>
                                    </div>
                                </div>

                                <a href="{{ route('profile.edit') }}"
                                   class="group w-full flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 rounded-xl transition-all duration-300 border border-purple-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user-edit text-white"></i>
                                        </div>
                                        <span class="font-semibold text-[#1c1c1c] group-hover:text-[#7e0202] transition-colors">Cập nhật hồ sơ</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-[#ed292a] transition-colors"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Learning Streak - Enhanced --}}
                    <div class="bg-gradient-to-br from-[#ed292a] via-[#7e0202] to-[#1c1c1c] rounded-2xl shadow-lg text-white overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

                        <div class="relative p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold">Chuỗi học tập</h3>
                                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                    <i class="fas fa-fire text-2xl text-orange-300"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                @php
                                    $currentStreak = 7; // Placeholder - cần implement logic thực tế
                                @endphp
                                <div class="text-5xl font-bold mb-2">{{ $currentStreak }}</div>
                                <p class="text-lg opacity-90 mb-4">ngày liên tiếp</p>
                                <div class="flex justify-center space-x-2 mb-4">
                                    @for($i = 0; $i < 7; $i++)
                                        <div class="w-8 h-2 {{ $i < $currentStreak ? 'bg-white' : 'bg-white/30' }} rounded-full"></div>
                                    @endfor
                                </div>
                                <p class="text-sm opacity-75">Bạn đang làm rất tốt! Hãy tiếp tục duy trì streak này.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Enhanced filter functionality with smooth animations
            document.addEventListener('DOMContentLoaded', function() {
                const filterButtons = document.querySelectorAll('.filter-btn');
                const courseCards = document.querySelectorAll('.course-card');

                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const filter = this.getAttribute('data-filter');

                        // Update active button with smooth transition
                        filterButtons.forEach(btn => {
                            btn.classList.remove('active', 'bg-[#ed292a]', 'text-white');
                            btn.classList.add('bg-white/10', 'text-white');
                        });
                        this.classList.add('active', 'bg-[#ed292a]', 'text-white');
                        this.classList.remove('bg-white/10');

                        // Filter courses with fade animation
                        let visibleCount = 0;
                        courseCards.forEach((card, index) => {
                            const status = card.getAttribute('data-status');

                            // Fade out first
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';

                            setTimeout(() => {
                                if (filter === 'all' || status === filter) {
                                    card.style.display = 'block';
                                    // Fade in with stagger
                                    setTimeout(() => {
                                        card.style.opacity = '1';
                                        card.style.transform = 'translateY(0)';
                                    }, index * 100);
                                    visibleCount++;
                                } else {
                                    card.style.display = 'none';
                                }
                            }, 200);
                        });
                    });
                });

                // Enhanced progress bar animations with stagger effect
                function animateProgressBars() {
                    const progressBars = document.querySelectorAll('.course-card [style*="width"]');
                    progressBars.forEach((bar, index) => {
                        const targetWidth = bar.style.width;
                        bar.style.width = '0%';
                        bar.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';

                        setTimeout(() => {
                            bar.style.width = targetWidth;
                        }, 300 + (index * 150));
                    });
                }

                // Animate statistics cards on scroll
                function animateStatsCards() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry, index) => {
                            if (entry.isIntersecting) {
                                setTimeout(() => {
                                    entry.target.style.opacity = '1';
                                    entry.target.style.transform = 'translateY(0)';
                                }, index * 100);
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.group').forEach(card => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(30px)';
                        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                        observer.observe(card);
                    });
                }

                // Smooth scroll for internal links
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

                // Add loading states for buttons
                document.querySelectorAll('a, button').forEach(element => {
                    element.addEventListener('click', function() {
                        if (this.href && !this.href.includes('#')) {
                            this.style.opacity = '0.7';
                            this.style.transform = 'scale(0.98)';
                        }
                    });
                });

                // Parallax effect for hero section
                window.addEventListener('scroll', () => {
                    const scrolled = window.pageYOffset;
                    const parallax = document.querySelector('.bg-gradient-to-br');
                    if (parallax) {
                        parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
                    }
                });

                // Initialize animations
                setTimeout(() => {
                    animateProgressBars();
                    animateStatsCards();
                }, 500);

                // Add hover effects for course cards
                courseCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-8px) scale(1.02)';
                        this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                        this.style.boxShadow = '';
                    });
                });

                // Add ripple effect to buttons
                function createRipple(event) {
                    const button = event.currentTarget;
                    const circle = document.createElement("span");
                    const diameter = Math.max(button.clientWidth, button.clientHeight);
                    const radius = diameter / 2;

                    circle.style.width = circle.style.height = `${diameter}px`;
                    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
                    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
                    circle.classList.add("ripple");

                    const rippleStyles = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        transform: scale(0);
                        animation: ripple 600ms linear;
                        pointer-events: none;
                    `;
                    circle.style.cssText = rippleStyles;

                    const rippleKeyframes = `
                        @keyframes ripple {
                            to {
                                transform: scale(4);
                                opacity: 0;
                            }
                        }
                    `;

                    if (!document.getElementById('ripple-styles')) {
                        const style = document.createElement('style');
                        style.id = 'ripple-styles';
                        style.textContent = rippleKeyframes;
                        document.head.appendChild(style);
                    }

                    const ripple = button.getElementsByClassName("ripple")[0];
                    if (ripple) {
                        ripple.remove();
                    }

                    button.appendChild(circle);
                }

                // Apply ripple effect to buttons
                document.querySelectorAll('button, .filter-btn').forEach(button => {
                    button.style.position = 'relative';
                    button.style.overflow = 'hidden';
                    button.addEventListener('click', createRipple);
                });

                // Smooth number counting animation for statistics
                function animateNumber(element, target, duration = 2000) {
                    const start = 0;
                    const increment = target / (duration / 16);
                    let current = start;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        element.textContent = Math.floor(current);
                    }, 16);
                }

                // Animate numbers when they come into view
                const numberElements = document.querySelectorAll('.text-3xl.font-bold');
                const numberObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const target = parseInt(entry.target.textContent);
                            if (!isNaN(target)) {
                                animateNumber(entry.target, target);
                                numberObserver.unobserve(entry.target);
                            }
                        }
                    });
                }, { threshold: 0.5 });

                numberElements.forEach(el => numberObserver.observe(el));
            });

            // Add custom CSS for enhanced animations
            const customStyles = `
                <style>
                    .course-card {
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .filter-btn {
                        transition: all 0.2s ease-in-out;
                    }

                    .group:hover .w-16.h-16 {
                        transform: scale(1.1) rotate(5deg);
                    }

                    @media (prefers-reduced-motion: reduce) {
                        *, *::before, *::after {
                            animation-duration: 0.01ms !important;
                            animation-iteration-count: 1 !important;
                            transition-duration: 0.01ms !important;
                        }
                    }

                    .bg-gradient-to-br {
                        transition: transform 0.1s ease-out;
                    }

                    .progress-bar-glow {
                        box-shadow: 0 0 20px rgba(237, 41, 42, 0.3);
                    }
                </style>
            `;

            document.head.insertAdjacentHTML('beforeend', customStyles);
        </script>
    @endpush
@endsection
