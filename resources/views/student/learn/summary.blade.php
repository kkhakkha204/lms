@extends('layouts.app')

@section('title', 'Hoàn thành khóa học - ' . $course->title)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Hero Section with Dark Theme -->
        <div class=" bg-gradient-to-b from-white via-gray-800 to-[#1c1c1c] relative overflow-hidden pt-32">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-700/20"></div>
                <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 20% 50%, #7e0202 0%, transparent 50%), radial-gradient(circle at 80% 50%, #ed292a 0%, transparent 50%);"></div>
            </div>

            <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <!-- Trophy Icon with Glow Effect -->
                <div class="text-center mb-12">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent rounded-full"></div>
                            <i class="fas fa-trophy text-white text-6xl relative z-10"></i>
                        </div>
                        <!-- Glow effect -->
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-40 h-40 bg-red-600/30 rounded-full blur-3xl -z-10"></div>
                    </div>

                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 tracking-tight" style="font-family: 'CustomTitle', sans-serif; ">
                        Xuất sắc!
                    </h1>
                    <div class="max-w-2xl mx-auto">
                        <p class="text-xl text-gray-300 mb-4 leading-relaxed">
                            Bạn đã hoàn thành thành công khóa học
                        </p>
                        <h2 class="text-2xl md:text-3xl font-semibold text-red-400 bg-gradient-to-r from-red-400 to-red-300 bg-clip-text text-transparent" style="font-family: 'CustomTitle', sans-serif;">
                            "{{ $course->title }}"
                        </h2>
                    </div>
                </div>

                <!-- Stats Overview Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-3xl font-bold text-white mb-2">{{ $completionPercentage }}%</div>
                        <div class="text-sm text-gray-300">Hoàn thành</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-3xl font-bold text-white mb-2">{{ $stats['completed_lessons'] }}/{{ $stats['total_lessons'] }}</div>
                        <div class="text-sm text-gray-300">Bài học</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-3xl font-bold text-white mb-2">{{ $stats['completed_quizzes'] }}/{{ $stats['total_quizzes'] }}</div>
                        <div class="text-sm text-gray-300">Bài kiểm tra</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-3xl font-bold text-white mb-2">{{ $stats['study_duration_days'] }}</div>
                        <div class="text-sm text-gray-300">Ngày học</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Notification -->
        @if(session('certificate_issued'))
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent"></div>
                    <div class="relative z-10 flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-certificate text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-2xl font-bold mb-3">Chứng chỉ đã được cấp!</h3>
                            <p class="mb-6 text-red-100">{{ session('certificate_issued.message') }}</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ session('certificate_issued.download_url') }}"
                                   class="bg-white text-red-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Tải xuống chứng chỉ
                                </a>
                                <a href="{{ route('certificates.verify', session('certificate_issued.certificate_code')) }}"
                                   target="_blank"
                                   class="bg-red-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-400 transition-all duration-300 flex items-center">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Xác thực công khai
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Performance Summary -->
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Kết quả học tập</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Overall Score Highlight -->
                        <div class="bg-gradient-to-r h-[155px] from-[#1c1c1c] via-[#7e0202] to-[#ed292a] rounded-xl p-8 text-center">
                            <div class="text-5xl font-bold text-white mb-4">{{ $stats['overall_score'] }}%</div>
                            <div class="text-xl font-semibold text-gray-50">{{ $stats['grade'] }}</div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Điểm trung bình quiz</span>
                                <span class="font-bold text-gray-900">{{ $stats['average_quiz_score'] }}%</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Ngày bắt đầu</span>
                                <span class="font-bold text-gray-900">{{ $enrollment->enrolled_at->format('d/m/Y') }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600 font-medium">Ngày hoàn thành</span>
                                <span class="font-bold text-red-600">{{ $enrollment->completed_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Thông tin khóa học</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Course Thumbnail -->
                        <div class="relative overflow-hidden rounded-xl">
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x200?text=Course' }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-[155px] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Giảng viên</span>
                                <span class="font-bold text-gray-900">{{ $course->instructor->name }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Danh mục</span>
                                <span class="font-bold text-gray-900">{{ $course->category->name }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Mức độ</span>
                                <span class="font-bold text-gray-900">
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

                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600 font-medium">Thời lượng</span>
                                <span class="font-bold text-gray-900">{{ $course->duration_hours }} giờ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Section -->
            <div class="bg-white rounded-3xl shadow-lg p-12 text-center border border-gray-100 mb-12">
                @if($existingCertificate)
                    <!-- Already has certificate -->
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-certificate text-white text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Chứng chỉ đã được cấp</h3>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                            Bạn đã nhận được chứng chỉ hoàn thành khóa học này. Chứng chỉ có thể được xác thực công khai và tải xuống bất cứ lúc nào.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-8 mb-8 max-w-4xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-center md:text-left">
                                <div class="text-sm text-gray-500 font-medium mb-1">Số chứng chỉ</div>
                                <div class="text-lg font-bold text-gray-900">{{ $existingCertificate->certificate_number }}</div>
                            </div>
                            <div class="text-center md:text-left">
                                <div class="text-sm text-gray-500 font-medium mb-1">Ngày cấp</div>
                                <div class="text-lg font-bold text-gray-900">{{ $existingCertificate->formatted_issued_date }}</div>
                            </div>
                            <div class="text-center md:text-left">
                                <div class="text-sm text-gray-500 font-medium mb-1">Mã xác thực</div>
                                <div class="text-lg font-mono font-bold text-gray-900">{{ $existingCertificate->certificate_code }}</div>
                            </div>
                            <div class="text-center md:text-left">
                                <div class="text-sm text-gray-500 font-medium mb-1">Trạng thái</div>
                                <div class="text-lg font-bold text-red-600">{{ ucfirst($existingCertificate->status) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('certificates.download', $existingCertificate->certificate_code) }}"
                           class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-4 rounded-2xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-download mr-3"></i>
                            Tải xuống chứng chỉ
                        </a>

                        <a href="{{ route('certificates.verify', $existingCertificate->certificate_code) }}"
                           target="_blank"
                           class="bg-gradient-to-r from-gray-800 to-gray-900 text-white px-8 py-4 rounded-2xl font-semibold hover:from-gray-900 hover:to-black transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-shield-alt mr-3"></i>
                            Xác thực công khai
                        </a>

                        <a href="{{ route('certificates.index') }}"
                           class="bg-white text-gray-700 px-8 py-4 rounded-2xl font-semibold hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-gray-300 flex items-center">
                            <i class="fas fa-list mr-3"></i>
                            Tất cả chứng chỉ
                        </a>
                    </div>
                @else
                    <!-- Certificate not issued yet -->
                    <div class="mb-10">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-award text-white text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Nhận chứng chỉ hoàn thành</h3>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed mb-8">
                            Bạn đã hoàn thành xuất sắc khóa học với điểm số <span class="font-bold text-red-600">{{ $stats['overall_score'] }}%</span>
                            ({{ $stats['grade'] }}). Nhấn nút bên dưới để nhận chứng chỉ chính thức.
                        </p>
                    </div>

                    <form action="{{ route('learning.issue-certificate', $course->slug) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-gradient-to-r from-red-600 to-red-700 text-white px-12 py-5 rounded-2xl font-bold text-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-certificate mr-4"></i>
                            Nhận chứng chỉ hoàn thành
                        </button>
                    </form>

                    <p class="text-sm text-gray-500 mt-6 max-w-lg mx-auto">
                        Chứng chỉ sẽ được gửi đến email của bạn và có thể xác thực công khai. Bạn có thể tải xuống và chia sẻ chứng chỉ này với nhà tuyển dụng.
                    </p>
                @endif
            </div>

            <!-- Next Steps -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Tiếp tục hành trình học tập</h3>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('student.courses.index') }}"
                       class="bg-white text-gray-700 px-8 py-4 rounded-2xl font-semibold hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-red-300 hover:text-red-600 flex items-center group">
                        <i class="fas fa-search mr-3 group-hover:text-red-600"></i>
                        Khám phá khóa học khác
                    </a>

                    <a href="{{ route('student.dashboard') }}"
                       class="bg-white text-gray-700 px-8 py-4 rounded-2xl font-semibold hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-red-300 hover:text-red-600 flex items-center group">
                        <i class="fas fa-user mr-3 group-hover:text-red-600"></i>
                        Dashboard của tôi
                    </a>

                    <button onclick="shareAchievement()"
                            class="bg-gradient-to-r from-gray-800 to-gray-900 text-white px-8 py-4 rounded-2xl font-semibold hover:from-gray-900 hover:to-black transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                        <i class="fas fa-share mr-3"></i>
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
            const text = `🎉 Tôi vừa hoàn thành khóa học "${document.title.replace('Hoàn thành khóa học - ', '')}" với điểm số {{ $stats['overall_score'] }}%!

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
                }).catch(() => {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = text + '\n\n' + window.location.href;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Đã copy thông tin chia sẻ vào clipboard!');
                });
            }
        }

        // Enhanced confetti animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#7e0202', '#ed292a', '#1c1c1c', '#ffffff'];

            // Create multiple waves of confetti
            for (let wave = 0; wave < 3; wave++) {
                setTimeout(() => {
                    for (let i = 0; i < 30; i++) {
                        setTimeout(() => {
                            createConfetti();
                        }, i * 50);
                    }
                }, wave * 1000);
            }
        });

        function createConfetti() {
            const confetti = document.createElement('div');
            const size = Math.random() * 8 + 4;

            confetti.style.position = 'fixed';
            confetti.style.width = size + 'px';
            confetti.style.height = size + 'px';
            confetti.style.backgroundColor = ['#7e0202', '#ed292a', '#1c1c1c', '#ffffff'][Math.floor(Math.random() * 4)];
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.top = '-20px';
            confetti.style.zIndex = '9999';
            confetti.style.pointerEvents = 'none';
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            confetti.style.animation = `fall ${3 + Math.random() * 2}s linear forwards`;
            confetti.style.opacity = '0.8';

            document.body.appendChild(confetti);

            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.remove();
                }
            }, 5000);
        }

        // Enhanced CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                to {
                    transform: translateY(100vh) rotate(720deg);
                    opacity: 0;
                }
            }

            /* Smooth hover animations */
            .hover\\:scale-105:hover {
                transform: scale(1.05);
            }



            @keyframes gradient-shift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            /* Subtle glow effect for important elements */
            .shadow-2xl:hover {
                box-shadow: 0 25px 50px -12px rgba(126, 2, 2, 0.25);
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
