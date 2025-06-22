@extends('layouts.admin')

@section('title', 'Quản lý Reviews')

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quản lý Reviews</h1>
                <p class="text-gray-600 mt-1">Quản lý và kiểm duyệt đánh giá của học viên</p>
            </div>

            <div class="flex space-x-3">
                <button id="bulkActionBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 hidden">
                    <i class="fas fa-tasks mr-2"></i>Thao tác hàng loạt
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Tên học viên hoặc nội dung review..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Course Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Khóa học</label>
                    <select name="course_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả khóa học</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đánh giá</label>
                    <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả đánh giá</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} sao
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="md:col-span-4 flex space-x-3">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-search mr-2"></i>Lọc
                    </button>
                    <a href="{{ route('admin.reviews.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                </div>
            </form>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($reviews->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Học viên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khóa học</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đánh giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reviews as $review)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="review_ids[]" value="{{ $review->id }}"
                                           class="review-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $review->student->avatar_url }}"
                                             alt="{{ $review->student->name }}"
                                             class="w-8 h-8 rounded-full mr-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $review->student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $review->student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($review->course->title, 30) }}</div>
                                    <div class="text-sm text-gray-500">{{ $review->course->category->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $review->rating }}/5</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $review->review ? Str::limit($review->review, 50) : 'Không có nội dung' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Đã duyệt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Chờ duyệt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $review->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button onclick="showReviewDetail({{ $review->id }})"
                                                class="text-blue-600 hover:text-blue-900 transition duration-200"
                                                title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="toggleApproval({{ $review->id }})"
                                                class="text-{{ $review->is_approved ? 'orange' : 'green' }}-600 hover:text-{{ $review->is_approved ? 'orange' : 'green' }}-900 transition duration-200"
                                                title="{{ $review->is_approved ? 'Ẩn review' : 'Duyệt review' }}">
                                            <i class="fas fa-{{ $review->is_approved ? 'eye-slash' : 'check' }}"></i>
                                        </button>
                                        <button onclick="deleteReview({{ $review->id }})"
                                                class="text-red-600 hover:text-red-900 transition duration-200"
                                                title="Xóa review">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-star text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Không có review nào</h3>
                    <p class="text-gray-500">Chưa có review nào trong hệ thống hoặc không tìm thấy kết quả phù hợp.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Review Detail Modal -->
    <div id="reviewDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Chi tiết Review</h3>
                        <button onclick="closeReviewDetail()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div id="reviewDetailContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div id="bulkActionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Thao tác hàng loạt</h3>
                        <button onclick="closeBulkActionModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-3">Đã chọn <span id="selectedCount">0</span> review</p>
                        <select id="bulkAction" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Chọn hành động</option>
                            <option value="approve">Duyệt reviews</option>
                            <option value="reject">Ẩn reviews</option>
                            <option value="delete">Xóa reviews</option>
                        </select>
                    </div>

                    <div class="flex space-x-3">
                        <button onclick="executeBulkAction()" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            Thực hiện
                        </button>
                        <button onclick="closeBulkActionModal()" class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200">
                            Hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Checkbox handling
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.review-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButton();
        });

        document.querySelectorAll('.review-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionButton);
        });

        function updateBulkActionButton() {
            const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
            const bulkActionBtn = document.getElementById('bulkActionBtn');

            if (checkedBoxes.length > 0) {
                bulkActionBtn.classList.remove('hidden');
                document.getElementById('selectedCount').textContent = checkedBoxes.length;
            } else {
                bulkActionBtn.classList.add('hidden');
            }
        }

        // Bulk actions
        document.getElementById('bulkActionBtn').addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
            if (checkedBoxes.length === 0) {
                showAlert('Vui lòng chọn ít nhất một review!', 'warning');
                return;
            }

            document.getElementById('selectedCount').textContent = checkedBoxes.length;
            document.getElementById('bulkActionModal').classList.remove('hidden');
        });

        function closeBulkActionModal() {
            document.getElementById('bulkActionModal').classList.add('hidden');
            document.getElementById('bulkAction').value = '';
        }

        function executeBulkAction() {
            const action = document.getElementById('bulkAction').value;
            if (!action) {
                showAlert('Vui lòng chọn hành động!', 'warning');
                return;
            }

            const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
            const reviewIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);

            let confirmMessage = '';
            switch (action) {
                case 'approve':
                    confirmMessage = `Bạn có chắc chắn muốn duyệt ${reviewIds.length} review đã chọn?`;
                    break;
                case 'reject':
                    confirmMessage = `Bạn có chắc chắn muốn ẩn ${reviewIds.length} review đã chọn?`;
                    break;
                case 'delete':
                    confirmMessage = `Bạn có chắc chắn muốn xóa ${reviewIds.length} review đã chọn? Hành động này không thể hoàn tác!`;
                    break;
            }

            if (!confirm(confirmMessage)) {
                return;
            }

            // Show loading
            const loadingSpinner = showLoading();

            fetch('{{ route("admin.reviews.bulk-action") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    action: action,
                    review_ids: reviewIds
                })
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading(loadingSpinner);

                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading(loadingSpinner);
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi thực hiện hành động!', 'error');
                });

            closeBulkActionModal();
        }

        // Show review detail
        function showReviewDetail(reviewId) {
            const loadingSpinner = showLoading();

            fetch(`/admin/reviews/${reviewId}`)
                .then(response => response.json())
                .then(data => {
                    hideLoading(loadingSpinner);

                    if (data.success) {
                        const review = data.review;
                        const content = `
                    <div class="space-y-4">
                        <!-- Student Info -->
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <img src="${review.student_avatar}" alt="${review.student_name}" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-medium text-gray-900">${review.student_name}</h4>
                                <p class="text-sm text-gray-600">${review.student_email}</p>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Khóa học</h4>
                            <div class="flex items-center space-x-3">
                                ${review.course_thumbnail ? `<img src="${review.course_thumbnail}" alt="${review.course_title}" class="w-16 h-12 object-cover rounded">` : ''}
                                <div>
                                    <p class="font-medium text-gray-900">${review.course_title}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Đánh giá</h4>
                            <div class="flex items-center space-x-2">
                                <div class="flex text-yellow-400">
                                    ${Array.from({length: 5}, (_, i) =>
                            `<i class="fas fa-star${i < review.rating ? '' : '-o'}"></i>`
                        ).join('')}
                                </div>
                                <span class="text-lg font-medium">${review.rating}/5</span>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Nội dung đánh giá</h4>
                            <p class="text-gray-700 leading-relaxed">${review.review || 'Không có nội dung đánh giá'}</p>
                        </div>

                        <!-- Status -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Trạng thái</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${review.is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                <i class="fas fa-${review.is_approved ? 'check-circle' : 'clock'} mr-1"></i>
                                ${review.is_approved ? 'Đã duyệt' : 'Chờ duyệt'}
                            </span>
                        </div>

                        <!-- Timestamps -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Thời gian</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Ngày tạo:</strong> ${review.created_at}</p>
                                <p><strong>Cập nhật:</strong> ${review.updated_at}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3 pt-4">
                            <button onclick="toggleApproval(${review.id})"
                                    class="flex-1 bg-${review.is_approved ? 'orange' : 'green'}-600 text-white py-2 px-4 rounded-lg hover:bg-${review.is_approved ? 'orange' : 'green'}-700 transition duration-200">
                                <i class="fas fa-${review.is_approved ? 'eye-slash' : 'check'} mr-2"></i>
                                ${review.is_approved ? 'Ẩn review' : 'Duyệt review'}
                            </button>
                            <button onclick="deleteReview(${review.id})"
                                    class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                                <i class="fas fa-trash mr-2"></i>Xóa
                            </button>
                        </div>
                    </div>
                `;

                        document.getElementById('reviewDetailContent').innerHTML = content;
                        document.getElementById('reviewDetailModal').classList.remove('hidden');
                    } else {
                        showAlert('Không thể tải thông tin review!', 'error');
                    }
                })
                .catch(error => {
                    hideLoading(loadingSpinner);
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi tải thông tin review!', 'error');
                });
        }

        function closeReviewDetail() {
            document.getElementById('reviewDetailModal').classList.add('hidden');
        }

        // Toggle approval
        function toggleApproval(reviewId) {
            const loadingSpinner = showLoading();

            fetch(`/admin/reviews/${reviewId}/toggle-approval`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading(loadingSpinner);

                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading(loadingSpinner);
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi cập nhật trạng thái!', 'error');
                });
        }

        // Delete review
        function deleteReview(reviewId) {
            if (!confirm('Bạn có chắc chắn muốn xóa review này? Hành động này không thể hoàn tác!')) {
                return;
            }

            const loadingSpinner = showLoading();

            fetch(`/admin/reviews/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading(loadingSpinner);

                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading(loadingSpinner);
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi xóa review!', 'error');
                });
        }

        // Utility functions
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-300' :
                    type === 'error' ? 'bg-red-100 text-red-800 border border-red-300' :
                        type === 'warning' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' :
                            'bg-blue-100 text-blue-800 border border-blue-300'
            }`;

            alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${
                type === 'success' ? 'check-circle' :
                    type === 'error' ? 'exclamation-circle' :
                        type === 'warning' ? 'exclamation-triangle' :
                            'info-circle'
            } mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            loadingDiv.innerHTML = `
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-900">Đang xử lý...</span>
        </div>
    `;

            document.body.appendChild(loadingDiv);
            return loadingDiv;
        }

        function hideLoading(loadingDiv) {
            if (loadingDiv && loadingDiv.parentNode) {
                loadingDiv.remove();
            }
        }

        // Close modals when clicking outside
        document.getElementById('reviewDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewDetail();
            }
        });

        document.getElementById('bulkActionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBulkActionModal();
            }
        });
    </script>
@endpush
