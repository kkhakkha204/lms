@extends('layouts.student')

@section('title', 'Hoàn thành khóa học - ' . $course->title)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Celebration Header -->
            <div class="text-center mb-12">
                <div class="w-32 h-32 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                    <i class="fas fa-trophy text-white text-5xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    🎉 Chúc mừng!
                </h1>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-2">
                    Bạn đã hoàn thành xuất sắc
                </h2>
                <p class="text-xl text-blue-600 font-medium">
                    "{{ $course->title }}"
                </p>
            </div>

            <!-- Certificate Notification -->
            @if(session('certificate_issued'))
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg p-6 mb-8 shadow-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-certificate text-white text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold mb-2">🎊 Chứng chỉ đã được cấp!</h3>
                            <p class="mb-4">{{ session('certificate_issued.message') }}</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ session('certificate_issued.download_url') }}"
                                   class="bg-white text-green-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-download mr-2"></i>
                                    Tải xuống chứng chỉ
                                </a>
                                <a href="{{ route('certificates.verify', session('certificate_issued.certificate_code')) }}"
                                   target="_blank"
                                   class="bg-green-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-300 transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Xác thực công khai
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Course Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-percentage text-blue-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">{{ $completionPercentage }}%</div>
                    <div class="text-sm text-gray-600">Hoàn thành</div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-play-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-600 mb-1">{{ $stats['completed_lessons'] }}/{{ $stats['total_lessons'] }}</div>
                    <div class="text-sm text-gray-600">Bài học</div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-question-circle text-orange-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-orange-600 mb-1">{{ $stats['completed_quizzes'] }}/{{ $stats['total_quizzes'] }}</div>
                    <div class="text-sm text-gray-600">Bài kiểm tra</div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-purple-600 mb-1">{{ $stats['study_duration_days'] }}</div>
                    <div class="text-sm text-gray-600">Ngày học</div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Performance Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Kết quả học tập
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Điểm tổng kết:</span>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-blue-600">{{ $stats['overall_score'] }}%</span>
                                <div class="text-sm text-gray-500">{{ $stats['grade'] }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Điểm trung bình quiz:</span>
                            <span class="font-semibold text-gray-900">{{ $stats['average_quiz_score'] }}%</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Thời gian xem video:</span>
                            <span class="font-semibold text-gray-900">{{ $stats['total_video_time'] }} giờ</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Ngày bắt đầu:</span>
                            <span class="font-semibold text-gray-900">{{ $enrollment->enrolled_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Ngày hoàn thành:</span>
                            <span class="font-semibold text-gray-900">{{ $enrollment->completed_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        <i class="fas fa-book text-green-600 mr-2"></i>
                        Thông tin khóa học
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/300x160?text=Course' }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-32 object-cover rounded-lg mb-4">
                        </div>

                        <div>
                            <span class="text-gray-600">Giảng viên:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ $course->instructor->name }}</span>
                        </div>

                        <div>
                            <span class="text-gray-600">Danh mục:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ $course->category->name }}</span>
                        </div>

                        <div>
                            <span class="text-gray-600">Mức độ:</span>
                            <span class="font-semibold text-gray-900 ml-2">
                            @php
                                $levelLabels = [
                                    'beginner' => 'Cơ bản',
                                    'intermediate' => 'Trung cấp',
                                    'advanced' => 'Nâng cao'
                                ];
                            @endphp
                                {{ $levelLabels[$course->level] ?? ucfirst($course->level) }}
                        </span>
                        </div>

                        <div>
                            <span class="text-gray-600">Thời lượng:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ $course->duration_hours }} giờ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Section -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                @if($existingCertificate)
                    <!-- Already has certificate -->
                    <div class="mb-6">
                        <i class="fas fa-certificate text-green-600 text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-green-600 mb-2">Chứng chỉ đã được cấp</h3>
                        <p class="text-gray-600 mb-6">
                            Bạn đã nhận được chứng chỉ hoàn thành khóa học này.
                        </p>
                    </div>

                    <div class="bg-green-50 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Số chứng chỉ:</span>
                                <div class="font-semibold text-gray-900">{{ $existingCertificate->certificate_number }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Ngày cấp:</span>
                                <div class="font-semibold text-gray-900">{{ $existingCertificate->formatted_issued_date }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Mã xác thực:</span>
                                <div class="font-mono text-sm text-gray-900">{{ $existingCertificate->certificate_code }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Trạng thái:</span>
                                <div class="font-semibold text-green-600">{{ ucfirst($existingCertificate->status) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('certificates.download', $existingCertificate->certificate_code) }}"
                           class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Tải xuống chứng chỉ
                        </a>

                        <a href="{{ route('certificates.verify', $existingCertificate->certificate_code) }}"
                           target="_blank"
                           class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Xác thực công khai
                        </a>

                        <a href="{{ route('certificates.index') }}"
                           class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            Tất cả chứng chỉ
                        </a>
                    </div>
                @else
                    <!-- Certificate not issued yet -->
                    <div class="mb-8">
                        <i class="fas fa-award text-yellow-500 text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Nhận chứng chỉ hoàn thành</h3>
                        <p class="text-gray-600 mb-6">
                            Bạn đã hoàn thành xuất sắc khóa học với điểm số {{ $stats['overall_score'] }}% ({{ $stats['grade'] }}).
                            <br>Nhấn nút bên dưới để nhận chứng chỉ chính thức.
                        </p>
                    </div>

                    <form action="{{ route('learning.issue-certificate', $course->slug) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-certificate mr-3"></i>
                            Nhận chứng chỉ hoàn thành
                        </button>
                    </form>

                    <p class="text-sm text-gray-500 mt-4">
                        Chứng chỉ sẽ được gửi đến email của bạn và có thể xác thực công khai.
                    </p>
                @endif
            </div>

            <!-- Next Steps -->
            <div class="mt-8 text-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Bước tiếp theo</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('student.courses.index') }}"
                       class="bg-blue-100 text-blue-700 px-6 py-3 rounded-lg font-medium hover:bg-blue-200 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Khám phá khóa học khác
                    </a>

                    <a href="{{ route('student.dashboard') }}"
                       class="bg-green-100 text-green-700 px-6 py-3 rounded-lg font-medium hover:bg-green-200 transition-colors">
                        <i class="fas fa-user mr-2"></i>
                        Dashboard của tôi
                    </a>

                    <button onclick="shareAchievement()"
                            class="bg-purple-100 text-purple-700 px-6 py-3 rounded-lg font-medium hover:bg-purple-200 transition-colors">
                        <i class="fas fa-share mr-2"></i>
                        Chia sẻ thành tựu
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function shareAchievement() {
            const text = `🎉 Tôi vừa hoàn thành khóa học "${document.title}" với điểm số {{ $stats['overall_score'] }}%!

#OnlineLearning #LMSEducation #Achievement`;

            if (navigator.share) {
                navigator.share({
                    title: 'Hoàn thành khóa học',
                    text: text,
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(text + '\n\n' + window.location.href).then(() => {
                    alert('Đã copy thông tin chia sẻ vào clipboard!');
                });
            }
        }

        // Confetti animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Simple confetti effect (you can add a library like canvas-confetti for better effect)
            const colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    createConfetti();
                }, i * 100);
            }
        });

        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.style.position = 'fixed';
            confetti.style.width = '10px';
            confetti.style.height = '10px';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.top = '-10px';
            confetti.style.zIndex = '1000';
            confetti.style.pointerEvents = 'none';
            confetti.style.animation = 'fall 3s linear forwards';

            document.body.appendChild(confetti);

            setTimeout(() => {
                confetti.remove();
            }, 3000);
        }

        // Add CSS for confetti animation
        const style = document.createElement('style');
        style.textContent = `
        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(style);
    </script>
@endpush
