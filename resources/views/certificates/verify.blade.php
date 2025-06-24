@extends('layouts.app')

@section('title', 'Xác thực chứng chỉ - LMS')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 py-36">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-16">
                <div class="relative inline-block mb-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mx-auto shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-4xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>
                <h1 class="text-5xl font-black text-gray-900 mb-6 tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">
                    Xác thực <span class="text-red-600">chứng chỉ</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Nhập mã xác thực để kiểm tra tính hợp lệ và xác minh nguồn gốc của chứng chỉ
                </p>
            </div>

            <!-- How to verify section -->
            <div class="bg-gradient-to-r from-gray-900 to-black rounded-3xl p-8 mt-12 text-white">
                <h3 class="text-2xl font-bold mb-8 text-center">
                    <i class="fas fa-lightbulb text-white mr-3"></i>
                    Hướng dẫn xác thực chứng chỉ
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">1</span>
                        </div>
                        <h4 class="font-bold text-lg mb-3">Tìm mã xác thực</h4>
                        <p class="text-gray-300 leading-relaxed">
                            Mã xác thực nằm ở cuối chứng chỉ PDF, có dạng "CERT-XXXXXX"
                        </p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">2</span>
                        </div>
                        <h4 class="font-bold text-lg mb-3">Nhập mã chính xác</h4>
                        <p class="text-gray-300 leading-relaxed">
                            Nhập chính xác mã xác thực vào ô bên trên và nhấn xác thực
                        </p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">3</span>
                        </div>
                        <h4 class="font-bold text-lg mb-3">Xem kết quả</h4>
                        <p class="text-gray-300 leading-relaxed">
                            Hệ thống sẽ hiển thị thông tin chi tiết nếu chứng chỉ hợp lệ
                        </p>
                    </div>
                </div>
            </div>

            <!-- Verification Form -->
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-12 mb-12 backdrop-blur-sm">
                <form id="verificationForm" class="max-w-lg mx-auto">
                    @csrf
                    <div class="mb-8">
                        <label for="certificate_code" class="block text-lg font-bold text-gray-900 mb-4">
                            Mã xác thực chứng chỉ
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="certificate_code"
                                   name="code"
                                   value="{{ $code }}"
                                   placeholder="CERT-ABC123XYZ"
                                   class="w-full px-6 py-5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-100 focus:border-red-500 text-center uppercase font-mono text-lg tracking-wider bg-gray-50 transition-all duration-300">
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-barcode text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            id="verifyButton"
                            class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-5 px-8 rounded-xl font-bold text-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        <i class="fas fa-search mr-3"></i>
                        <span id="buttonText">Xác thực chứng chỉ</span>
                        <div id="loadingSpinner" class="hidden inline-block ml-3">
                            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Verification Result -->
            <div id="verificationResult" class="hidden">
                <!-- Success Result -->
                <div id="successResult" class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6 border-b border-green-100">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-green-800">Chứng chỉ hợp lệ</h3>
                                <p class="text-green-600 font-medium">Chứng chỉ đã được xác thực thành công</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="bg-gray-50 rounded-2xl p-6">
                                    <h4 class="font-bold text-xl text-gray-900 mb-6 flex items-center">
                                        <i class="fas fa-certificate text-red-600 mr-3"></i>
                                        Thông tin chứng chỉ
                                    </h4>
                                    <dl class="space-y-4">
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <dt class="text-gray-600 font-medium">Số chứng chỉ</dt>
                                            <dd class="font-bold text-gray-900 font-mono" id="certNumber"></dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <dt class="text-gray-600 font-medium">Học viên</dt>
                                            <dd class="font-bold text-gray-900" id="studentName"></dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <dt class="text-gray-600 font-medium">Khóa học</dt>
                                            <dd class="font-bold text-gray-900" id="courseTitle"></dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2">
                                            <dt class="text-gray-600 font-medium">Giảng viên</dt>
                                            <dd class="font-bold text-gray-900" id="instructorName"></dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <h4 class="font-bold text-xl text-gray-900 mb-6 flex items-center">
                                        <i class="fas fa-chart-line text-red-600 mr-3"></i>
                                        Chi tiết hoàn thành
                                    </h4>
                                    <dl class="space-y-4">
                                        <div class="flex justify-between items-center py-2 border-b border-red-100">
                                            <dt class="text-gray-600 font-medium">Ngày cấp</dt>
                                            <dd class="font-bold text-gray-900" id="issuedDate"></dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-red-100">
                                            <dt class="text-gray-600 font-medium">Ngày hoàn thành</dt>
                                            <dd class="font-bold text-gray-900" id="completedDate"></dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-red-100">
                                            <dt class="text-gray-600 font-medium">Điểm số</dt>
                                            <dd class="font-bold text-gray-900">
                                                <span id="finalScore"></span>%
                                                <span class="text-red-600 ml-2">(<span id="grade"></span>)</span>
                                            </dd>
                                        </div>
                                        <div class="flex justify-between items-center py-2">
                                            <dt class="text-gray-600 font-medium">Trạng thái</dt>
                                            <dd>
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-200">
                                                <i class="fas fa-check mr-2"></i>
                                                Hợp lệ
                                            </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Result -->
                <div id="errorResult" class="bg-white rounded-3xl shadow-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 px-8 py-6 border-b border-red-100">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-times text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-red-800">Chứng chỉ không hợp lệ</h3>
                                <p class="text-red-600 font-medium">Không tìm thấy chứng chỉ hoặc mã xác thực không đúng</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-4">Xác thực thất bại</h4>
                            <p class="text-gray-600 text-lg mb-6 max-w-md mx-auto">
                                Mã xác thực không tồn tại, đã hết hạn hoặc bị thu hồi.
                            </p>
                            <div class="bg-gray-50 rounded-xl p-4 max-w-md mx-auto">
                                <p class="text-sm text-gray-500">
                                    Vui lòng kiểm tra lại mã xác thực hoặc liên hệ với người cấp chứng chỉ.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($code && $verified)
        <script>
            // Auto verify if code is provided in URL
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('verificationForm').dispatchEvent(new Event('submit'));
            });
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const code = document.getElementById('certificate_code').value.trim();
            if (!code) {
                // Custom alert with better styling
                showAlert('Vui lòng nhập mã xác thực', 'warning');
                return;
            }

            // Show loading state
            const button = document.getElementById('verifyButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('loadingSpinner');

            button.disabled = true;
            button.classList.add('opacity-75');
            buttonText.textContent = 'Đang xác thực...';
            spinner.classList.remove('hidden');

            // Make AJAX request
            fetch('{{ route("certificates.verify-ajax") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ code: code })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('verificationResult').classList.remove('hidden');

                    // Smooth scroll to result
                    document.getElementById('verificationResult').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    if (data.verified) {
                        showSuccessResult(data.certificate);
                    } else {
                        showErrorResult();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorResult();
                    showAlert('Có lỗi xảy ra khi xác thực. Vui lòng thử lại.', 'error');
                })
                .finally(() => {
                    // Reset button state
                    button.disabled = false;
                    button.classList.remove('opacity-75');
                    buttonText.textContent = 'Xác thực chứng chỉ';
                    spinner.classList.add('hidden');
                });
        });

        function showSuccessResult(certificate) {
            document.getElementById('successResult').classList.remove('hidden');
            document.getElementById('errorResult').classList.add('hidden');

            // Populate certificate data with animation
            const fields = [
                { id: 'certNumber', value: certificate.certificate_number },
                { id: 'studentName', value: certificate.student_name },
                { id: 'courseTitle', value: certificate.course_title },
                { id: 'instructorName', value: certificate.instructor_name },
                { id: 'issuedDate', value: certificate.issued_date },
                { id: 'completedDate', value: certificate.completed_date },
                { id: 'finalScore', value: certificate.final_score },
                { id: 'grade', value: certificate.grade }
            ];

            fields.forEach((field, index) => {
                setTimeout(() => {
                    const element = document.getElementById(field.id);
                    element.textContent = field.value;
                    element.classList.add('animate-pulse');
                    setTimeout(() => element.classList.remove('animate-pulse'), 500);
                }, index * 100);
            });
        }

        function showErrorResult() {
            document.getElementById('successResult').classList.add('hidden');
            document.getElementById('errorResult').classList.remove('hidden');
        }

        function showAlert(message, type) {
            // Create and show custom alert
            const alertDiv = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-red-500' : type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';

            alertDiv.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-xl shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'error' ? 'fa-times' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(alertDiv);

            setTimeout(() => alertDiv.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                alertDiv.classList.add('translate-x-full');
                setTimeout(() => document.body.removeChild(alertDiv), 300);
            }, 3000);
        }

        // Auto-format certificate code input
        document.getElementById('certificate_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Add focus effects
        document.getElementById('certificate_code').addEventListener('focus', function(e) {
            e.target.classList.add('transform', 'scale-105');
        });

        document.getElementById('certificate_code').addEventListener('blur', function(e) {
            e.target.classList.remove('transform', 'scale-105');
        });
    </script>
@endpush
