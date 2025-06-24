@extends('layouts.app')

@section('title', 'Chứng chỉ của tôi - LMS')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-[#1c1c1c] via-[#2a2a2a] to-[#1c1c1c] relative overflow-hidden pt-32">
            <div class="absolute inset-0 bg-gradient-to-r from-[#7e0202]/10 to-[#ed292a]/5"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-2xl mb-8 shadow-2xl">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>

                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">
                        Chứng chỉ của tôi
                    </h1>

                    <p class="text-xl text-white/80 max-w-2xl mx-auto mb-8">
                        Bộ sưu tập thành tựu học tập và chứng nhận kỹ năng của bạn
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex justify-center items-center space-x-8 text-white/70">
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-white mr-2">{{ isset($certificates) ? $certificates->total() : 0 }}</span>
                            <span>chứng chỉ</span>
                        </div>
                        <div class="w-1 h-1 bg-white/40 rounded-full"></div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-white mr-2">{{ isset($certificates) ? $certificates->where('status', 'active')->count() : 0 }}</span>
                            <span>hợp lệ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-10">

            <!-- Certificate Success Notification -->
            @if(session('certificate_issued'))
                <div class="mb-8">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-1">
                            <div class="bg-white p-8 rounded-3xl">
                                <div class="flex items-start space-x-6">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-award text-white text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-[#1c1c1c] mb-3">🎉 Chứng chỉ mới!</h3>
                                        <p class="text-gray-600 mb-6 text-lg">{{ session('certificate_issued.message') }}</p>
                                        <div class="flex flex-wrap gap-4">
                                            <a href="{{ session('certificate_issued.download_url') }}"
                                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white rounded-2xl hover:shadow-lg transition-all duration-300 font-semibold group">
                                                <i class="fas fa-download mr-2 group-hover:animate-bounce"></i>
                                                Tải xuống ngay
                                            </a>
                                            <a href="{{ route('certificates.show', session('certificate_issued.certificate_code')) }}"
                                               class="inline-flex items-center px-6 py-3 bg-[#1c1c1c] text-white rounded-2xl hover:bg-[#2a2a2a] transition-colors duration-300 font-semibold">
                                                <i class="fas fa-eye mr-2"></i>
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($certificates) && $certificates->count() > 0)
                <!-- Enhanced Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center group hover:shadow-2xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div class="text-4xl font-bold text-[#1c1c1c] mb-2">{{ $certificates->total() }}</div>
                        <div class="text-gray-600 font-medium">Tổng số chứng chỉ</div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center group hover:shadow-2xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <div class="text-4xl font-bold text-[#1c1c1c] mb-2">{{ $certificates->where('status', 'active')->count() }}</div>
                        <div class="text-gray-600 font-medium">Chứng chỉ hợp lệ</div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center group hover:shadow-2xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-download text-white text-xl"></i>
                        </div>
                        <div class="text-4xl font-bold text-[#1c1c1c] mb-2">{{ $certificates->sum('download_count') }}</div>
                        <div class="text-gray-600 font-medium">Lượt tải xuống</div>
                    </div>
                </div>

                <!-- Certificate Grid -->
                <div class="space-y-8 mb-12">
                    @foreach($certificates as $certificate)
                        <div class="group">
                            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">

                                <!-- Certificate Header -->
                                <div class="relative bg-gradient-to-r from-[#1c1c1c] via-[#2a2a2a] to-[#1c1c1c] p-8">
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#7e0202]/10 to-[#ed292a]/5"></div>
                                    <div class="relative flex items-start justify-between">
                                        <div class="flex-1 pr-8">
                                            <div class="flex items-center mb-4">
                                                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-bold text-white mb-1 line-clamp-2" style="font-family: 'CustomTitle', sans-serif; ">{{ $certificate->course->title }}</h3>
                                                    <p class="text-white/70">{{ $certificate->course->instructor->name }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-end space-y-3">
                                            @if($certificate->status === 'active')
                                                <div class="inline-flex items-center px-4 py-2 bg-green-500/20 backdrop-blur-sm rounded-xl border border-green-400/30">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                                    <span class="text-sm font-medium text-white">Hợp lệ</span>
                                                </div>
                                            @else
                                                <div class="inline-flex items-center px-4 py-2 bg-red-500/20 backdrop-blur-sm rounded-xl border border-red-400/30">
                                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                                    <span class="text-sm font-medium text-white">{{ ucfirst($certificate->status) }}</span>
                                                </div>
                                            @endif

                                            <div class="text-right text-white/70">
                                                <div class="text-sm">Số chứng chỉ</div>
                                                <div class="font-mono text-lg font-bold text-white">{{ $certificate->certificate_number }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Certificate Body -->
                                <div class="p-8">
                                    <!-- Achievement Metrics -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-percentage text-white"></i>
                                            </div>
                                            <div class="text-2xl font-bold text-[#1c1c1c] mb-1">{{ number_format($certificate->final_score, 1) }}%</div>
                                            <div class="text-sm text-gray-600 mb-1">Điểm số</div>
                                            <div class="text-xs font-semibold text-[#ed292a] bg-[#ed292a]/10 px-2 py-1 rounded-full">{{ $certificate->grade }}</div>
                                        </div>

                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-calendar text-white"></i>
                                            </div>
                                            <div class="text-2xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->formatted_issued_date }}</div>
                                            <div class="text-sm text-gray-600">Ngày cấp</div>
                                        </div>

                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-download text-white"></i>
                                            </div>
                                            <div class="text-2xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->download_count }}</div>
                                            <div class="text-sm text-gray-600">Lượt tải</div>
                                        </div>

                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                            <div class="text-2xl font-bold text-[#1c1c1c] mb-1">{{ $certificate->study_duration ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-600">Giờ học</div>
                                        </div>
                                    </div>

                                    <!-- Actions Section -->
                                    <div class="flex flex-col lg:flex-row items-start justify-between pt-6 border-t border-gray-100 space-y-4 lg:space-y-0">
                                        <!-- Primary Actions -->
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('certificates.download', $certificate->certificate_code) }}"
                                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white rounded-2xl hover:shadow-lg transition-all duration-300 font-semibold group">
                                                <i class="fas fa-download mr-2 group-hover:animate-bounce"></i>
                                                Tải xuống
                                            </a>

                                            <a href="{{ route('certificates.show', $certificate->certificate_code) }}"
                                               class="inline-flex items-center px-6 py-3 bg-[#1c1c1c] text-white rounded-2xl hover:bg-[#2a2a2a] transition-colors duration-300 font-semibold">
                                                <i class="fas fa-eye mr-2"></i>
                                                Chi tiết
                                            </a>

                                            <a href="{{ route('certificates.verify', $certificate->certificate_code) }}"
                                               target="_blank"
                                               class="inline-flex items-center px-6 py-3 bg-white border-2 border-green-500 text-green-600 rounded-2xl hover:bg-green-50 transition-colors duration-300 font-semibold">
                                                <i class="fas fa-shield-check mr-2"></i>
                                                Xác thực
                                            </a>
                                        </div>

                                        <!-- Share Actions -->
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm font-medium text-gray-500">Chia sẻ:</span>

                                            <button onclick="copyToClipboard('{{ $certificate->verification_url }}')"
                                                    class="w-12 h-12 flex items-center justify-center bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300 group"
                                                    title="Copy link">
                                                <i class="fas fa-link group-hover:scale-110 transition-transform duration-200"></i>
                                            </button>

                                            <a href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{ urlencode($certificate->course->title) }}&organizationName=LMS&issueYear={{ $certificate->issued_at->year }}&issueMonth={{ $certificate->issued_at->month }}&certUrl={{ urlencode($certificate->verification_url) }}"
                                               target="_blank"
                                               class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-200 hover:text-blue-700 transition-colors duration-300 group"
                                               title="Thêm vào LinkedIn">
                                                <i class="fab fa-linkedin group-hover:scale-110 transition-transform duration-200"></i>
                                            </a>

                                            <button onclick="shareOnFacebook('{{ $certificate->verification_url }}')"
                                                    class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-200 hover:text-blue-700 transition-colors duration-300 group"
                                                    title="Chia sẻ Facebook">
                                                <i class="fab fa-facebook group-hover:scale-110 transition-transform duration-200"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Elegant Pagination -->
                @if($certificates->hasPages())
                    <div class="flex justify-center">
                        <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                            {{ $certificates->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Premium Empty State -->
                <div class="text-center py-20">
                    <div class="max-w-lg mx-auto">
                        <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                            <i class="fas fa-certificate text-gray-400 text-4xl"></i>
                        </div>

                        <h3 class="text-3xl font-bold text-[#1c1c1c] mb-4">Chưa có chứng chỉ nào</h3>
                        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                            Hoàn thành các khóa học để nhận chứng chỉ và khẳng định thành tựu học tập của bạn.
                            Mỗi chứng chỉ là một bước tiến quan trọng trong hành trình phát triển bản thân.
                        </p>

                        <a href="{{ route('student.courses.index') }}"
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white rounded-2xl hover:shadow-xl transition-all duration-300 font-semibold text-lg group">
                            <i class="fas fa-book-open mr-3 group-hover:animate-pulse"></i>
                            Khám phá khóa học
                            <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Đã sao chép link xác thực!', 'success');
            }).catch(function() {
                showNotification('Không thể sao chép link!', 'error');
            });
        }

        function shareOnFacebook(url) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'from-green-500 to-emerald-600' : 'from-red-500 to-red-600';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

            notification.className = `fixed top-6 right-6 bg-gradient-to-r ${bgColor} text-white px-6 py-4 rounded-2xl shadow-xl z-50 transform translate-x-full transition-all duration-300`;
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas ${icon}"></i>
                    </div>
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
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Smooth entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.group, .bg-white');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            elements.forEach((element) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
        });

        // Enhanced hover effects
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
@endpush
