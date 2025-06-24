@extends('layouts.app')

@section('title', 'Chứng chỉ của tôi - LMS')

@section('content')
    <div class="min-h-screen bg-white">
        <div class="max-w-6xl mx-auto px-6 py-32">

            <!-- Minimalist Header -->
            <div class="mb-16">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-5xl font-light text-[#1c1c1c]" style="font-family: 'CustomTitle', sans-serif; ">
                            Chứng chỉ
                        </h1>
                        <div class="w-[182px] h-0.5 bg-[#ed292a] mt-4"></div>
                    </div>
                    <div class="hidden md:flex items-center space-x-4 text-sm text-gray-500" >
                        <span>{{ isset($certificates) ? $certificates->total() : 0 }} chứng chỉ</span>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <span>{{ isset($certificates) ? $certificates->where('status', 'active')->count() : 0 }} hợp lệ</span>
                    </div>
                </div>
                <p class="text-gray-600 text-lg  max-w-2xl">
                    Bộ sưu tập chứng chỉ hoàn thành khóa học của bạn
                </p>
            </div>

            <!-- Certificate Success Notification -->
            @if(session('certificate_issued'))
                <div class="mb-12 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-emerald-600/5 rounded-2xl"></div>
                    <div class="relative bg-white/60 backdrop-blur-xl border border-emerald-200/30 rounded-2xl p-8">
                        <div class="flex items-start space-x-6">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-medium text-[#1c1c1c] mb-2">Chứng chỉ mới</h3>
                                <p class="text-gray-600 mb-6">{{ session('certificate_issued.message') }}</p>
                                <div class="flex space-x-4">
                                    <a href="{{ session('certificate_issued.download_url') }}"
                                       class="inline-flex items-center px-6 py-3 bg-[#1c1c1c] text-white rounded-xl hover:bg-[#ed292a] transition-colors duration-300 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Tải xuống
                                    </a>
                                    <a href="{{ route('certificates.show', session('certificate_issued.certificate_code')) }}"
                                       class="inline-flex items-center px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:border-gray-300 transition-colors duration-300 font-medium">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($certificates) && $certificates->count() > 0)
                <!-- Minimalist Stats -->
                <div class="grid grid-cols-3 gap-8 mb-16">
                    <div class="text-center">
                        <div class="text-3xl font-light text-[#1c1c1c] mb-2">{{ $certificates->total() }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider">Tổng số</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-light text-[#1c1c1c] mb-2">{{ $certificates->where('status', 'active')->count() }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider">Hợp lệ</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-light text-[#1c1c1c] mb-2">{{ $certificates->sum('download_count') }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider">Lượt tải</div>
                    </div>
                </div>

                <!-- Certificate Grid -->
                <div class="space-y-8">
                    @foreach($certificates as $certificate)
                        <div class="group relative">
                            <!-- Main Certificate Card -->
                            <div class="relative bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition-all duration-500 hover:-translate-y-1">

                                <!-- Certificate Header -->
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#1c1c1c] to-[#7e0202]"></div>
                                    <div class="relative p-8 text-white">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 pr-6">
                                                <h3 class="text-2xl font-light mb-3 line-clamp-2">{{ $certificate->course->title }}</h3>
                                                <p class="text-white/70 font-light">{{ $certificate->course->instructor->name }}</p>
                                            </div>
                                            <div class="text-right">
                                                @if($certificate->status === 'active')
                                                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                                                        <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></div>
                                                        <span class="text-sm font-medium">Hợp lệ</span>
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                                                        <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                                        <span class="text-sm font-medium">{{ ucfirst($certificate->status) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Certificate Body -->
                                <div class="p-8">
                                    <div class="grid grid-cols-4 gap-6 mb-8">
                                        <div class="text-center">
                                            <div class="text-sm text-gray-500 mb-2 uppercase tracking-wider">Số chứng chỉ</div>
                                            <div class="font-mono text-[#1c1c1c] text-sm">{{ $certificate->certificate_number }}</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm text-gray-500 mb-2 uppercase tracking-wider">Ngày cấp</div>
                                            <div class="text-[#1c1c1c] text-sm">{{ $certificate->formatted_issued_date }}</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm text-gray-500 mb-2 uppercase tracking-wider">Điểm số</div>
                                            <div class="text-[#1c1c1c] font-medium">{{ number_format($certificate->final_score, 1) }}%</div>
                                            <div class="text-xs text-[#ed292a] font-medium">{{ $certificate->grade }}</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm text-gray-500 mb-2 uppercase tracking-wider">Lượt tải</div>
                                            <div class="text-[#1c1c1c] font-medium">{{ $certificate->download_count }}</div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                        <div class="flex space-x-4">
                                            <a href="{{ route('certificates.download', $certificate->certificate_code) }}"
                                               class="inline-flex items-center px-6 py-3 bg-[#1c1c1c] text-white rounded-xl hover:bg-[#ed292a] transition-colors duration-300 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Tải xuống
                                            </a>
                                            <a href="{{ route('certificates.show', $certificate->certificate_code) }}"
                                               class="inline-flex items-center px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:border-gray-300 transition-colors duration-300 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Xem chi tiết
                                            </a>
                                            <a href="{{ route('certificates.verify', $certificate->certificate_code) }}"
                                               target="_blank"
                                               class="inline-flex items-center px-6 py-3 border border-emerald-200 text-emerald-700 rounded-xl hover:border-emerald-300 hover:bg-emerald-50 transition-colors duration-300 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                                Xác thực
                                            </a>
                                        </div>

                                        <!-- Share Actions -->
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-500">Chia sẻ:</span>
                                            <button onclick="copyToClipboard('{{ $certificate->verification_url }}')"
                                                    class="w-10 h-10 flex items-center justify-center border border-gray-200 text-gray-600 rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-colors duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                            </button>
                                            <a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->course->title) }}&organizationName=LMS&issueYear={{ $certificate->issued_at->year }}&issueMonth={{ $certificate->issued_at->month }}&certUrl={{ urlencode($certificate->verification_url) }}"
                                               target="_blank"
                                               class="w-10 h-10 flex items-center justify-center border border-blue-200 text-blue-600 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition-colors duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                            </a>
                                            <button onclick="shareOnFacebook('{{ $certificate->verification_url }}')"
                                                    class="w-10 h-10 flex items-center justify-center border border-blue-200 text-blue-600 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition-colors duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Minimalist Pagination -->
                @if($certificates->hasPages())
                    <div class="mt-16 flex justify-center">
                        <div class="bg-white border border-gray-100 rounded-2xl p-6">
                            {{ $certificates->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Elegant Empty State -->
                <div class="text-center py-24">
                    <div class="w-32 h-32 mx-auto mb-8 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-[#1c1c1c] mb-4">Chưa có chứng chỉ</h3>
                    <p class="text-gray-600 font-light mb-12 max-w-md mx-auto">
                        Hoàn thành các khóa học để nhận chứng chỉ và khẳng định thành tựu học tập của bạn.
                    </p>
                    <a href="{{ route('student.courses.index') }}"
                       class="inline-flex items-center px-8 py-4 bg-[#1c1c1c] text-white rounded-2xl hover:bg-[#ed292a] transition-colors duration-300 font-medium">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
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
                // Modern toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed top-6 right-6 bg-white border border-gray-200 shadow-xl px-6 py-4 rounded-2xl z-50 transform translate-x-full transition-transform duration-300';
                toast.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-800 font-medium">Đã sao chép link xác thực</span>
                    </div>
                `;
                document.body.appendChild(toast);

                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => document.body.contains(toast) && document.body.removeChild(toast), 300);
                }, 3000);
            });
        }

        function shareOnFacebook(url) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        // Smooth entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const certificates = document.querySelectorAll('.group');
            certificates.forEach((cert, index) => {
                cert.style.opacity = '0';
                cert.style.transform = 'translateY(20px)';
                cert.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;

                setTimeout(() => {
                    cert.style.opacity = '1';
                    cert.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endpush
