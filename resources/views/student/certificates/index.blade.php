@extends('layouts.student')

@section('title', 'Chứng chỉ của tôi - LMS')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Chứng chỉ của tôi</h1>
                <p class="text-gray-600 mt-2">Quản lý và tải xuống các chứng chỉ hoàn thành khóa học</p>
            </div>

            <!-- Certificate Success Notification -->
            @if(session('certificate_issued'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-certificate text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">🎉 Chúc mừng!</h3>
                            <p class="text-green-700 mb-4">{{ session('certificate_issued.message') }}</p>
                            <div class="flex space-x-4">
                                <a href="{{ session('certificate_issued.download_url') }}"
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-download mr-2"></i>
                                    Tải xuống chứng chỉ
                                </a>
                                <a href="{{ route('certificates.show', session('certificate_issued.certificate_code')) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($certificates) && $certificates->count() > 0)
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <i class="fas fa-certificate text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Tổng chứng chỉ</p>
                                <p class="text-2xl font-bold text-gray-900">{{ isset($certificates) ? $certificates->total() : 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Hợp lệ</p>
                                <p class="text-2xl font-bold text-gray-900">{{ isset($certificates) ? $certificates->where('status', 'active')->count() : 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <i class="fas fa-download text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Lượt tải xuống</p>
                                <p class="text-2xl font-bold text-gray-900">{{ isset($certificates) ? $certificates->sum('download_count') : 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certificates List -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($certificates as $certificate)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <!-- Certificate Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Lượt tải</p>
                                        <p class="font-semibold text-gray-900">{{ $certificate->download_count }}</p>
                                    </div>
                                </div>

                                <!-- Certificate Actions -->
                                <div class="flex space-x-3">
                                    <a href="{{ route('certificates.download', $certificate->certificate_code) }}"
                                       class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-download mr-2"></i>
                                        Tải xuống
                                    </a>

                                    <a href="{{ route('certificates.show', $certificate->certificate_code) }}"
                                       class="flex-1 bg-gray-100 text-gray-700 text-center py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-eye mr-2"></i>
                                        Xem chi tiết
                                    </a>

                                    <a href="{{ route('certificates.verify', $certificate->certificate_code) }}"
                                       target="_blank"
                                       class="flex-1 bg-green-100 text-green-700 text-center py-2 px-4 rounded-lg hover:bg-green-200 transition-colors">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Xác thực
                                    </a>
                                </div>

                                <!-- Share Options -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 mb-2">Chia sẻ chứng chỉ:</p>
                                    <div class="flex space-x-2">
                                        <button onclick="copyToClipboard('{{ $certificate->verification_url }}')"
                                                class="text-gray-500 hover:text-blue-600 text-sm">
                                            <i class="fas fa-link mr-1"></i>
                                            Copy link
                                        </button>
                                        <a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->course->title) }}&organizationName=LMS&issueYear={{ $certificate->issued_at->year }}&issueMonth={{ $certificate->issued_at->month }}&certUrl={{ urlencode($certificate->verification_url) }}"
                                           target="_blank"
                                           class="text-gray-500 hover:text-blue-600 text-sm">
                                            <i class="fab fa-linkedin mr-1"></i>
                                            LinkedIn
                                        </a>
                                        <button onclick="shareOnFacebook('{{ $certificate->verification_url }}')"
                                                class="text-gray-500 hover:text-blue-600 text-sm">
                                            <i class="fab fa-facebook mr-1"></i>
                                            Facebook
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $certificates->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có chứng chỉ</h3>
                    <p class="text-gray-600 mb-6">
                        Hoàn thành các khóa học để nhận chứng chỉ hoàn thành.
                    </p>
                    <a href="{{ route('student.courses.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-book mr-2"></i>
                        Khám phá khóa học
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                toast.textContent = 'Đã copy link xác thực!';
                document.body.appendChild(toast);

                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            });
        }

        function shareOnFacebook(url) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
@endpush
<h3 class="text-lg font-semibold mb-1">{{ $certificate->course->title }}</h3>
<p class="text-blue-100 text-sm">{{ $certificate->course->instructor->name }}</p>
</div>
<div class="text-right">
    @if($certificate->status === 'active')
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Hợp lệ
                                        </span>
    @else
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            {{ ucfirst($certificate->status) }}
                                        </span>
    @endif
</div>
</div>
</div>

<!-- Certificate Body -->
<div class="p-6">
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <p class="text-sm text-gray-600">Số chứng chỉ</p>
            <p class="font-semibold text-gray-900">{{ $certificate->certificate_number }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Ngày cấp</p>
            <p class="font-semibold text-gray-900">{{ $certificate->formatted_issued_date }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Điểm số</p>
            <p class="font-semibold text-gray-900">
                {{ number_format($certificate->final_score, 1) }}%
                <span class="text-blue-600">({{ $certificate->grade }})</span>
            </p>
        </div>
        <div>
