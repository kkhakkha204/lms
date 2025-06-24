@extends('layouts.app')

@section('title', 'Chi tiết chứng chỉ - ' . $certificate->course->title)

@section('content')
    <div class="min-h-screen bg-gray-50 pb-32">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-[#1c1c1c] via-[#2a2a2a] to-[#1c1c1c] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-[#7e0202]/10 to-[#ed292a]/5"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
                <!-- Back Button -->
                <div class="mb-8">
                    <a href="{{ route('certificates.index') }}"
                       class="inline-flex items-center text-white/80 hover:text-white transition-colors group">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                            <i class="fas fa-arrow-left text-sm"></i>
                        </div>
                        <span class="text-sm font-medium">Quay lại danh sách</span>
                    </a>
                </div>

                <!-- Certificate Hero -->
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-full mb-6 shadow-2xl">
                        <i class="fas fa-award text-white text-3xl"></i>
                    </div>

                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">
                        Chứng chỉ hoàn thành
                    </h1>

                    <div class="max-w-3xl mx-auto">
                        <h2 class="text-xl md:text-2xl text-white/90 font-medium mb-2">
                            {{ $certificate->course->title }}
                        </h2>
                    </div>

                    <!-- Certificate Number -->
                    <div class="mt-8 inline-flex items-center bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-3">
                        <span class="text-white/70 text-sm mr-3">Số chứng chỉ:</span>
                        <span class="text-white font-mono font-bold text-lg">{{ $certificate->certificate_number }}</span>
                        @if($certificate->status === 'active')
                            <div class="ml-4 w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Column - Main Content -->
                <div class="lg:col-span-8 space-y-8">

                    <!-- Achievement Stats -->
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-[#1c1c1c] mb-2">Thành tích của bạn</h3>
                            <p class="text-gray-600">Tổng quan về quá trình học tập</p>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="text-center group">
                                <div class="w-16 h-16 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-percentage text-white text-xl"></i>
                                </div>
                                <div class="text-3xl font-bold text-[#1c1c1c] mb-1">{{ number_format($certificate->final_score, 1) }}%</div>
                                <div class="text-sm text-gray-600 mb-1">Điểm tổng kết</div>
                                <div class="text-xs font-semibold text-[#ed292a] bg-[#ed292a]/10 px-3 py-1 rounded-full">
                                    {{ $certificate->grade }}
                                </div>
                            </div>

                            <div class="text-center group">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-play-circle text-white text-xl"></i>
                                </div>
                                <div class="text-3xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->lessons_completed }}</div>
                                <div class="text-sm text-gray-600">Bài học</div>
                                <div class="text-xs text-green-600">hoàn thành</div>
                            </div>

                            <div class="text-center group">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-question-circle text-white text-xl"></i>
                                </div>
                                <div class="text-3xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->quizzes_completed }}</div>
                                <div class="text-sm text-gray-600">Bài kiểm tra</div>
                                <div class="text-xs text-purple-600">đạt yêu cầu</div>
                            </div>

                            <div class="text-center group">
                                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <div class="text-3xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->study_duration }}</div>
                                <div class="text-sm text-gray-600">Giờ học tập</div>
                                <div class="text-xs text-amber-600">tổng cộng</div>
                            </div>
                        </div>
                    </div>

                    <!-- Student & Course Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Student Information -->
                        <div class="bg-[#1c1c1c] rounded-3xl shadow-xl p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                                <h3 class="text-xl font-bold text-white">Thông tin học viên</h3>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="relative">
                                    <img src="{{ $certificate->student->avatar_url }}"
                                         alt="{{ $certificate->student->name }}"
                                         class="w-18 h-18 rounded-2xl shadow-lg">
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-white mb-1">{{ $certificate->student->name }}</h4>
                                    <p class="text-gray-200 mb-3">{{ $certificate->student->email }}</p>
                                    <div class="flex items-center text-sm text-gray-200">
                                        <i class="fas fa-user-clock mr-2"></i>
                                        <span>Gia nhập: {{ $certificate->student->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Information -->
                        <div class="bg-[#1c1c1c] rounded-3xl shadow-xl p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                                <h3 class="text-xl font-bold text-white">Khóa học</h3>
                            </div>

                            <div class="mb-4">
                                <img src="{{ $certificate->course->thumbnail ? asset('storage/' . $certificate->course->thumbnail) : 'https://via.placeholder.com/300x160?text=Course' }}"
                                     alt="{{ $certificate->course->title }}"
                                     class="w-full h-32 object-cover rounded-2xl shadow-lg">
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-100">Danh mục:</span>
                                    <p class="text-white font-semibold">{{ $certificate->course_details['category'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-100">Mức độ:</span>
                                    <p class="text-white font-semibold">
                                        @php
                                            $levelLabels = [
                                                'beginner' => 'Cơ bản',
                                                'intermediate' => 'Trung cấp',
                                                'advanced' => 'Nâng cao'
                                            ];
                                        @endphp
                                        {{ $levelLabels[$certificate->course_details['level']] ?? ucfirst($certificate->course_details['level']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                        <div class="flex items-center mb-8">
                            <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                            <h3 class="text-xl font-bold text-[#1c1c1c]">Lộ trình hoàn thành</h3>
                        </div>

                        <div class="relative">
                            <!-- Timeline line -->
                            <div class="absolute left-8 top-6 bottom-6 w-0.5 bg-gradient-to-b from-[#ed292a] via-green-500 to-[#7e0202] opacity-30"></div>

                            <div class="space-y-8">
                                <!-- Step 1: Start Course -->
                                <div class="flex items-start group">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-play text-white text-lg"></i>
                                        </div>
                                        <!-- Pulse animation -->
                                        <div class="absolute inset-0 w-16 h-16 bg-blue-500 rounded-full animate-ping opacity-20"></div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-gradient-to-r from-blue-50 to-transparent p-6 rounded-2xl border-l-4 border-blue-500">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-lg font-bold text-[#1c1c1c]">Bắt đầu hành trình</h4>
                                            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">BƯỚC 1</span>
                                        </div>
                                        <p class="text-gray-600 mb-2">Khởi đầu cuộc hành trình học tập của bạn</p>
                                        <div class="flex items-center text-sm text-blue-600">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <span class="font-semibold">{{ $certificate->course_started_at->format('d/m/Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $certificate->course_started_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Learning Progress -->
                                <div class="flex items-start group">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-brain text-white text-lg"></i>
                                        </div>
                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                            <i class="fas fa-star text-white text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-gradient-to-r from-purple-50 to-transparent p-6 rounded-2xl border-l-4 border-purple-500">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-lg font-bold text-[#1c1c1c]">Quá trình học tập</h4>
                                            <span class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full font-semibold">BƯỚC 2</span>
                                        </div>
                                        <p class="text-gray-600 mb-4">Hoàn thành các bài học và kiểm tra</p>

                                        <!-- Progress stats -->
                                        <div class="grid grid-cols-2 gap-4 mb-3">
                                            <div class="bg-white p-3 rounded-xl shadow-sm">
                                                <div class="text-2xl font-bold text-purple-600">{{ $certificate->lessons_completed }}</div>
                                                <div class="text-xs text-gray-500">Bài học</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-xl shadow-sm">
                                                <div class="text-2xl font-bold text-purple-600">{{ $certificate->quizzes_completed }}</div>
                                                <div class="text-xs text-gray-500">Bài kiểm tra</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-sm text-purple-600">
                                            <i class="fas fa-clock mr-2"></i>
                                            <span class="font-semibold">{{ $certificate->study_duration }} giờ học tập</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Course Completion -->
                                <div class="flex items-start group">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-check-double text-white text-lg"></i>
                                        </div>
                                        <!-- Success badge -->
                                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center animate-bounce">
                                            <i class="fas fa-trophy text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-gradient-to-r from-green-50 to-transparent p-6 rounded-2xl border-l-4 border-green-500">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-lg font-bold text-[#1c1c1c]">Hoàn thành xuất sắc</h4>
                                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">BƯỚC 3</span>
                                        </div>
                                        <p class="text-gray-600 mb-4">Đạt được mục tiêu học tập với kết quả ấn tượng</p>

                                        <!-- Achievement highlight -->
                                        <div class="bg-white p-4 rounded-xl shadow-sm mb-3">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="text-2xl font-bold text-green-600">{{ number_format($certificate->final_score, 1) }}%</div>
                                                    <div class="text-sm text-gray-500">Điểm tổng kết</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-lg font-bold text-green-600">{{ $certificate->grade }}</div>
                                                    <div class="text-sm text-gray-500">Xếp loại</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-sm text-green-600">
                                            <i class="fas fa-calendar-check mr-2"></i>
                                            <span class="font-semibold">{{ $certificate->course_completed_at->format('d/m/Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <span>Quiz trung bình: {{ number_format($certificate->average_quiz_score, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Certificate Issued -->
                                <div class="flex items-start group">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-award text-white text-lg"></i>
                                        </div>
                                        <!-- Sparkle effect -->
                                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-yellow-400 rounded-full animate-ping"></div>
                                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-yellow-300 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-gradient-to-r from-red-50 to-transparent p-6 rounded-2xl border-l-4 border-[#ed292a]">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-lg font-bold text-[#1c1c1c]">Nhận chứng chỉ</h4>
                                            <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold">HOÀN THÀNH</span>
                                        </div>
                                        <p class="text-gray-600 mb-4">Chúc mừng! Bạn đã chính thức nhận được chứng chỉ</p>

                                        <!-- Certificate info -->
                                        <div class="bg-white p-4 rounded-xl shadow-sm mb-3">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-certificate text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-[#1c1c1c]">{{ $certificate->certificate_number }}</div>
                                                    <div class="text-sm text-gray-500">Mã chứng chỉ</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-sm text-[#ed292a]">
                                            <i class="fas fa-calendar-plus mr-2"></i>
                                            <span class="font-semibold">{{ $certificate->formatted_issued_date }}</span>
                                            <span class="mx-2">•</span>
                                            <span class="inline-flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            Đã xác thực
                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Actions & Info -->
                <div class="lg:col-span-4 space-y-8">

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 top-8">
                        <h3 class="text-xl font-bold text-[#1c1c1c] mb-6">Hành động</h3>

                        <div class="space-y-4">
                            <a href="{{ route('certificates.download', $certificate->certificate_code) }}"
                               class="block w-full bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white text-center py-4 px-6 rounded-2xl hover:shadow-lg transition-all duration-300 font-semibold group">
                                <i class="fas fa-download mr-3 group-hover:animate-bounce"></i>
                                Tải xuống PDF
                            </a>

                            <a href="{{ route('certificates.verify', $certificate->certificate_code) }}"
                               target="_blank"
                               class="block w-full bg-[#1c1c1c] text-white text-center py-4 px-6 rounded-2xl hover:bg-[#2a2a2a] transition-colors font-semibold">
                                <i class="fas fa-shield-alt mr-3"></i>
                                Xác thực công khai
                            </a>

                            <button onclick="copyVerificationLink()"
                                    class="w-full bg-gray-100 text-[#1c1c1c] py-4 px-6 rounded-2xl hover:bg-gray-200 transition-colors font-semibold">
                                <i class="fas fa-link mr-3"></i>
                                Copy link xác thực
                            </button>
                        </div>
                    </div>

                    <!-- Certificate Details -->
                    <div class="rounded-3xl p-8 ">
                        <div class="flex items-center mb-6">
                            <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                            <h3 class="text-xl font-bold text-[#1c1c1c]">Chi tiết chứng chỉ</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-2">Mã xác thực</label>
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200">
                                    <code class="text-sm font-mono text-[#1c1c1c]">{{ $certificate->certificate_code }}</code>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 block mb-1">Template:</span>
                                    <span class="font-semibold text-[#1c1c1c]">{{ ucfirst($certificate->certificate_template) }}</span>
                                </div>

                                <div>
                                    <span class="text-gray-500 block mb-1">Lượt tải:</span>
                                    <span class="font-semibold text-[#1c1c1c]">{{ $certificate->download_count }}</span>
                                </div>
                            </div>

                            @if($certificate->last_downloaded_at)
                                <div class="text-sm">
                                    <span class="text-gray-500 block mb-1">Tải xuống lần cuối:</span>
                                    <span class="font-semibold text-[#1c1c1c]">{{ $certificate->last_downloaded_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif

                            @if($certificate->expires_at)
                                <div class="text-sm">
                                    <span class="text-gray-500 block mb-1">Ngày hết hạn:</span>
                                    <span class="font-semibold text-[#1c1c1c]">{{ $certificate->expires_at->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Share -->
                    <div class=" p-8 ">
                        <div class="flex items-center mb-6">
                            <div class="w-2 h-8 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full mr-4"></div>
                            <h3 class="text-xl font-bold text-[#1c1c1c]">Chia sẻ thành tựu</h3>
                        </div>

                        <div class="space-y-3">
                            <button onclick="shareToLinkedIn()"
                                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-2xl hover:bg-blue-700 transition-colors font-medium">
                                <i class="fab fa-linkedin mr-2"></i>
                                LinkedIn
                            </button>

                            <button onclick="shareToFacebook()"
                                    class="w-full bg-blue-500 text-white py-3 px-4 rounded-2xl hover:bg-blue-600 transition-colors font-medium">
                                <i class="fab fa-facebook mr-2"></i>
                                Facebook
                            </button>

                            <button onclick="shareToTwitter()"
                                    class="w-full bg-gray-900 text-white py-3 px-4 rounded-2xl hover:bg-gray-800 transition-colors font-medium">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- QR Code Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <script>
        // Generate QR Code
        document.addEventListener('DOMContentLoaded', function() {
            new QRious({
                element: document.getElementById('qrcode'),
                value: '{{ $certificate->verification_url }}',
                size: 150,
                level: 'M'
            });
        });

        function copyVerificationLink() {
            const url = '{{ $certificate->verification_url }}';
            navigator.clipboard.writeText(url).then(function() {
                showNotification('Đã copy link xác thực!', 'success');
            });
        }

        function shareToLinkedIn() {
            const url = 'https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->course->title) }}&organizationName=LMS&issueYear={{ $certificate->issued_at->year }}&issueMonth={{ $certificate->issued_at->month }}&certUrl={{ urlencode($certificate->verification_url) }}';
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareToFacebook() {
            const text = `🎉 Tôi vừa hoàn thành khóa học "{{ $certificate->course->title }}" và nhận được chứng chỉ!`;
            const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('{{ $certificate->verification_url }}')}`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareToTwitter() {
            const text = `🎓 Tôi vừa hoàn thành khóa học "{{ $certificate->course->title }}" với điểm số {{ number_format($certificate->final_score, 1) }}%!

#OnlineLearning #Certificate #Achievement`;
            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent('{{ $certificate->verification_url }}')}`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-2xl shadow-xl z-50 transform translate-x-full transition-transform duration-300`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Animate out
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
@endpush
