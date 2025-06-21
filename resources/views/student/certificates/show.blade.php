@extends('layouts.student')

@section('title', 'Chi tiết chứng chỉ - ' . $certificate->course->title)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('certificates.index') }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại danh sách chứng chỉ
                </a>
            </div>

            <!-- Certificate Header -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-certificate text-3xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold mb-1">Chứng chỉ hoàn thành</h1>
                                    <p class="text-blue-100">{{ $certificate->title }}</p>
                                </div>
                            </div>
                            <h2 class="text-2xl font-semibold mb-2">{{ $certificate->course->title }}</h2>
                            <p class="text-blue-100">{{ $certificate->instructor_name }}</p>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-blue-200 mb-1">Số chứng chỉ</div>
                            <div class="text-xl font-bold">{{ $certificate->certificate_number }}</div>

                            @if($certificate->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-3">
                                <i class="fas fa-check-circle mr-1"></i>
                                Hợp lệ
                            </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 mt-3">
                                <i class="fas fa-times-circle mr-1"></i>
                                {{ ucfirst($certificate->status) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Certificate Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Student Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Thông tin học viên
                        </h3>

                        <div class="flex items-start space-x-4">
                            <img src="{{ $certificate->student->avatar_url }}"
                                 alt="{{ $certificate->student->name }}"
                                 class="w-16 h-16 rounded-full">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $certificate->student->name }}</h4>
                                <p class="text-gray-600">{{ $certificate->student->email }}</p>
                                <div class="mt-2 text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Gia nhập: {{ $certificate->student->created_at->format('d/m/Y') }}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-book text-green-600 mr-2"></i>
                            Thông tin khóa học
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <img src="{{ $certificate->course->thumbnail ? asset('storage/' . $certificate->course->thumbnail) : 'https://via.placeholder.com/300x160?text=Course' }}"
                                     alt="{{ $certificate->course->title }}"
                                     class="w-full h-32 object-cover rounded-lg mb-4">
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-600">Tên khóa học:</span>
                                    <p class="font-semibold text-gray-900">{{ $certificate->course->title }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Giảng viên:</span>
                                    <p class="font-semibold text-gray-900">{{ $certificate->instructor_name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Danh mục:</span>
                                    <p class="font-semibold text-gray-900">{{ $certificate->course_details['category'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Mức độ:</span>
                                    <p class="font-semibold text-gray-900">
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

                    <!-- Completion Details -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-chart-line text-orange-600 mr-2"></i>
                            Chi tiết hoàn thành
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-percentage text-blue-600"></i>
                                </div>
                                <div class="text-2xl font-bold text-blue-600">{{ number_format($certificate->final_score, 1) }}%</div>
                                <div class="text-sm text-gray-600">Điểm tổng kết</div>
                                <div class="text-xs text-blue-600 font-medium">{{ $certificate->grade }}</div>
                            </div>

                            <div class="text-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-play-circle text-green-600"></i>
                                </div>
                                <div class="text-2xl font-bold text-green-600">{{ $certificate->lessons_completed }}</div>
                                <div class="text-sm text-gray-600">Bài học hoàn thành</div>
                            </div>

                            <div class="text-center">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-question-circle text-purple-600"></i>
                                </div>
                                <div class="text-2xl font-bold text-purple-600">{{ $certificate->quizzes_completed }}</div>
                                <div class="text-sm text-gray-600">Bài kiểm tra đạt</div>
                            </div>

                            <div class="text-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                                <div class="text-2xl font-bold text-yellow-600">{{ $certificate->study_duration }}</div>
                                <div class="text-sm text-gray-600">Giờ học tập</div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Ngày bắt đầu:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $certificate->course_started_at->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Ngày hoàn thành:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $certificate->course_completed_at->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Ngày cấp chứng chỉ:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $certificate->formatted_issued_date }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Điểm quiz trung bình:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ number_format($certificate->average_quiz_score, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Sidebar -->
                <div class="space-y-6">

                    <!-- Download Actions -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hành động</h3>

                        <div class="space-y-3">
                            <a href="{{ route('certificates.download', $certificate->certificate_code) }}"
                               class="block w-full bg-blue-600 text-white text-center py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-download mr-2"></i>
                                Tải xuống PDF
                            </a>

                            <a href="{{ route('certificates.verify', $certificate->certificate_code) }}"
                               target="_blank"
                               class="block w-full bg-green-600 text-white text-center py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Xác thực công khai
                            </a>

                            <button onclick="copyVerificationLink()"
                                    class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                <i class="fas fa-link mr-2"></i>
                                Copy link xác thực
                            </button>
                        </div>
                    </div>

                    <!-- Certificate Info -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin chứng chỉ</h3>

                        <div class="space-y-4 text-sm">
                            <div>
                                <span class="text-gray-600">Mã xác thực:</span>
                                <div class="font-mono text-sm text-gray-900 bg-gray-50 p-2 rounded mt-1">
                                    {{ $certificate->certificate_code }}
                                </div>
                            </div>

                            <div>
                                <span class="text-gray-600">Template sử dụng:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ ucfirst($certificate->certificate_template) }}</span>
                            </div>

                            <div>
                                <span class="text-gray-600">Lượt tải xuống:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ $certificate->download_count }}</span>
                            </div>

                            @if($certificate->last_downloaded_at)
                                <div>
                                    <span class="text-gray-600">Tải xuống lần cuối:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $certificate->last_downloaded_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif

                            @if($certificate->expires_at)
                                <div>
                                    <span class="text-gray-600">Ngày hết hạn:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $certificate->expires_at->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Share Options -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Chia sẻ thành tựu</h3>

                        <div class="space-y-3">
                            <button onclick="shareToLinkedIn()"
                                    class="w-full bg-blue-700 text-white py-3 px-4 rounded-lg hover:bg-blue-800 transition-colors font-medium">
                                <i class="fab fa-linkedin mr-2"></i>
                                Thêm vào LinkedIn
                            </button>

                            <button onclick="shareToFacebook()"
                                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fab fa-facebook mr-2"></i>
                                Chia sẻ Facebook
                            </button>

                            <button onclick="shareToTwitter()"
                                    class="w-full bg-gray-900 text-white py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium">
                                <i class="fab fa-twitter mr-2"></i>
                                Chia sẻ Twitter
                            </button>
                        </div>
                    </div>

                    <!-- QR Code for Verification -->
                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code xác thực</h3>
                        <div class="bg-gray-100 p-4 rounded-lg mb-3">
                            <div id="qrcode" class="flex justify-center"></div>
                        </div>
                        <p class="text-sm text-gray-600">Quét để xác thực chứng chỉ</p>
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
                showNotification('Đã copy link xác thực!');
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

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endpush
