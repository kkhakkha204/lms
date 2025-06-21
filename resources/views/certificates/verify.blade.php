@extends('layouts.student')

@section('title', 'Xác thực chứng chỉ - LMS')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Xác thực chứng chỉ</h1>
                <p class="text-lg text-gray-600">
                    Nhập mã xác thực để kiểm tra tính hợp lệ của chứng chỉ
                </p>
            </div>

            <!-- Verification Form -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
                <form id="verificationForm" class="max-w-md mx-auto">
                    @csrf
                    <div class="mb-6">
                        <label for="certificate_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Mã xác thực chứng chỉ
                        </label>
                        <input type="text"
                               id="certificate_code"
                               name="code"
                               value="{{ $code }}"
                               placeholder="VD: CERT-ABC123XYZ"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center uppercase"
                               style="letter-spacing: 2px;">
                    </div>

                    <button type="submit"
                            id="verifyButton"
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        <span id="buttonText">Xác thực chứng chỉ</span>
                        <div id="loadingSpinner" class="hidden inline-block ml-2">
                            <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Verification Result -->
            <div id="verificationResult" class="hidden">
                <!-- Success Result -->
                <div id="successResult" class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-green-800">Chứng chỉ hợp lệ</h3>
                                <p class="text-green-600 text-sm">Chứng chỉ đã được xác thực thành công</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Thông tin chứng chỉ</h4>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-gray-600">Số chứng chỉ</dt>
                                        <dd class="font-semibold text-gray-900" id="certNumber"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Học viên</dt>
                                        <dd class="font-semibold text-gray-900" id="studentName"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Khóa học</dt>
                                        <dd class="font-semibold text-gray-900" id="courseTitle"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Giảng viên</dt>
                                        <dd class="font-semibold text-gray-900" id="instructorName"></dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Chi tiết hoàn thành</h4>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-gray-600">Ngày cấp</dt>
                                        <dd class="font-semibold text-gray-900" id="issuedDate"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Ngày hoàn thành</dt>
                                        <dd class="font-semibold text-gray-900" id="completedDate"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Điểm số</dt>
                                        <dd class="font-semibold text-gray-900">
                                            <span id="finalScore"></span>%
                                            <span class="text-blue-600">(<span id="grade"></span>)</span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">Trạng thái</dt>
                                        <dd>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Hợp lệ
                                        </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Result -->
                <div id="errorResult" class="bg-white rounded-lg shadow-sm">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-red-800">Chứng chỉ không hợp lệ</h3>
                                <p class="text-red-600 text-sm">Không tìm thấy chứng chỉ hoặc mã xác thực không đúng</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Xác thực thất bại</h4>
                            <p class="text-gray-600 mb-4">
                                Mã xác thực không tồn tại, đã hết hạn hoặc bị thu hồi.
                            </p>
                            <p class="text-sm text-gray-500">
                                Vui lòng kiểm tra lại mã xác thực hoặc liên hệ với người cấp chứng chỉ.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to verify section -->
            <div class="bg-blue-50 rounded-lg p-6 mt-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    Cách xác thực chứng chỉ
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-800">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                            <span class="text-blue-800 font-bold text-xs">1</span>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Tìm mã xác thực</p>
                            <p>Mã xác thực nằm ở cuối chứng chỉ PDF, có dạng "CERT-XXXXXX"</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                            <span class="text-blue-800 font-bold text-xs">2</span>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Nhập mã</p>
                            <p>Nhập chính xác mã xác thực vào ô bên trên</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                            <span class="text-blue-800 font-bold text-xs">3</span>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Xem kết quả</p>
                            <p>Hệ thống sẽ hiển thị thông tin chi tiết nếu chứng chỉ hợp lệ</p>
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
                alert('Vui lòng nhập mã xác thực');
                return;
            }

            // Show loading state
            const button = document.getElementById('verifyButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('loadingSpinner');

            button.disabled = true;
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

                    if (data.verified) {
                        showSuccessResult(data.certificate);
                    } else {
                        showErrorResult();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorResult();
                })
                .finally(() => {
                    // Reset button state
                    button.disabled = false;
                    buttonText.textContent = 'Xác thực chứng chỉ';
                    spinner.classList.add('hidden');
                });
        });

        function showSuccessResult(certificate) {
            document.getElementById('successResult').classList.remove('hidden');
            document.getElementById('errorResult').classList.add('hidden');

            // Populate certificate data
            document.getElementById('certNumber').textContent = certificate.certificate_number;
            document.getElementById('studentName').textContent = certificate.student_name;
            document.getElementById('courseTitle').textContent = certificate.course_title;
            document.getElementById('instructorName').textContent = certificate.instructor_name;
            document.getElementById('issuedDate').textContent = certificate.issued_date;
            document.getElementById('completedDate').textContent = certificate.completed_date;
            document.getElementById('finalScore').textContent = certificate.final_score;
            document.getElementById('grade').textContent = certificate.grade;
        }

        function showErrorResult() {
            document.getElementById('successResult').classList.add('hidden');
            document.getElementById('errorResult').classList.remove('hidden');
        }

        // Auto-format certificate code input
        document.getElementById('certificate_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    </script>
@endpush
