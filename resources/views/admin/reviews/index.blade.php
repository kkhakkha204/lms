@extends('layouts.admin')

@section('title', 'Quản lý Reviews')

@section('content')
    <style>
        /* Custom Neumorphism Styles */
        .neu-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 8px 8px 20px rgba(28, 28, 28, 0.1),
            -8px -8px 20px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .neu-card-inset {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: inset 4px 4px 12px rgba(28, 28, 28, 0.08),
            inset -4px -4px 12px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(28, 28, 28, 0.03);
        }

        .neu-button {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 12px;
            box-shadow: 4px 4px 12px rgba(28, 28, 28, 0.1),
            -4px -4px 12px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
            transition: all 0.3s ease;
        }

        .neu-button:hover {
            box-shadow: 2px 2px 8px rgba(28, 28, 28, 0.15),
            -2px -2px 8px rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .neu-button:active {
            box-shadow: inset 2px 2px 6px rgba(28, 28, 28, 0.1),
            inset -2px -2px 6px rgba(255, 255, 255, 0.8);
            transform: translateY(0);
        }

        .neu-button-primary {
            background: linear-gradient(145deg, #ed292a, #d42324);
            color: white;
            box-shadow: 4px 4px 12px rgba(237, 41, 42, 0.3),
            -4px -4px 12px rgba(255, 255, 255, 0.1);
        }

        .neu-button-primary:hover {
            background: linear-gradient(145deg, #f03537, #ed292a);
            box-shadow: 2px 2px 8px rgba(237, 41, 42, 0.4),
            -2px -2px 8px rgba(255, 255, 255, 0.1);
        }

        .neu-button-danger {
            background: linear-gradient(145deg, #7e0202, #6b0202);
            color: white;
            box-shadow: 4px 4px 12px rgba(126, 2, 2, 0.3),
            -4px -4px 12px rgba(255, 255, 255, 0.1);
        }

        .neu-button-danger:hover {
            background: linear-gradient(145deg, #8f0303, #7e0202);
            box-shadow: 2px 2px 8px rgba(126, 2, 2, 0.4),
            -2px -2px 8px rgba(255, 255, 255, 0.1);
        }

        .neu-input {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: inset 3px 3px 8px rgba(28, 28, 28, 0.08),
            inset -3px -3px 8px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(28, 28, 28, 0.05);
            transition: all 0.3s ease;
        }

        .neu-input:focus {
            box-shadow: inset 3px 3px 8px rgba(237, 41, 42, 0.1),
            inset -3px -3px 8px rgba(255, 255, 255, 0.8),
            0 0 0 3px rgba(237, 41, 42, 0.1);
            outline: none;
            border-color: rgba(237, 41, 42, 0.3);
        }

        .neu-table-header {
            background: linear-gradient(145deg, #f8f9fa, #e9ecef);
            border-radius: 16px 16px 0 0;
            box-shadow: inset 2px 2px 6px rgba(28, 28, 28, 0.05),
            inset -2px -2px 6px rgba(255, 255, 255, 0.9);
        }

        .neu-table-row {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 0;
        }

        .neu-table-row:hover {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            box-shadow: 2px 2px 8px rgba(28, 28, 28, 0.05),
            -2px -2px 8px rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .neu-badge {
            border-radius: 20px;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 2px 2px 6px rgba(28, 28, 28, 0.1),
            -2px -2px 6px rgba(255, 255, 255, 0.9);
        }

        .neu-badge-success {
            background: linear-gradient(145deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .neu-badge-warning {
            background: linear-gradient(145deg, #fff3cd, #ffeaa7);
            color: #856404;
        }

        .neu-avatar {
            border-radius: 50%;
            box-shadow: 3px 3px 8px rgba(28, 28, 28, 0.15),
            -3px -3px 8px rgba(255, 255, 255, 0.9);
        }

        .neu-modal {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 20px 20px 40px rgba(28, 28, 28, 0.15),
            -20px -20px 40px rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(28, 28, 28, 0.05);
        }

        .neu-star {
            filter: drop-shadow(1px 1px 2px rgba(28, 28, 28, 0.1));
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(145deg, #1c1c1c, #4a4a4a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(28, 28, 28, 0.1), transparent);
            margin: 2rem 0;
        }
    </style>

    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Header Section -->
        <div class="neu-card p-8 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold gradient-text mb-2" style="font-family: 'CustomTitle', sans-serif; ">Quản lý Reviews</h1>
                    <p class="text-gray-600">Quản lý và kiểm duyệt đánh giá của học viên</p>
                </div>

                <div class="flex space-x-4">
                    <button id="bulkActionBtn" class="neu-button-primary px-6 py-3 rounded-lg hidden">
                        <i class="fas fa-tasks mr-2"></i>Thao tác hàng loạt
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="neu-card p-6 mb-8">
            <form method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Search -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tìm kiếm</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Tên học viên hoặc nội dung review..."
                               class="neu-input w-full px-4 py-3 text-gray-700 placeholder-gray-400">
                    </div>

                    <!-- Course Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Khóa học</label>
                        <select name="course_id" class="neu-input w-full px-4 py-3 text-gray-700">
                            <option value="">Tất cả khóa học</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rating Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Đánh giá</label>
                        <select name="rating" class="neu-input w-full px-4 py-3 text-gray-700">
                            <option value="">Tất cả đánh giá</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} sao
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Trạng thái</label>
                        <select name="status" class="neu-input w-full px-4 py-3 text-gray-700">
                            <option value="">Tất cả trạng thái</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        </select>
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-4">
                    <button type="submit" class="neu-button-primary px-6 py-3 rounded-lg font-medium">
                        <i class="fas fa-search mr-2"></i>Lọc kết quả
                    </button>
                    <a href="{{ route('admin.reviews.index') }}" class="neu-button px-6 py-3 rounded-lg font-medium text-gray-700">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                </div>
            </form>
        </div>

        <!-- Reviews Table -->
        <div class="neu-card overflow-hidden">
            @if($reviews->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="neu-table-header">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-gray-300 neu-input">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Học viên</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Khóa học</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Đánh giá</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nội dung</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($reviews as $review)
                            <tr class="neu-table-row">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="review_ids[]" value="{{ $review->id }}"
                                           class="review-checkbox w-4 h-4 rounded border-gray-300 neu-input">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $review->student->avatar_url }}"
                                             alt="{{ $review->student->name }}"
                                             class="w-10 h-10 neu-avatar object-cover">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $review->student->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($review->course->title, 25) }}</div>
                                    <div class="text-xs text-gray-500">{{ $review->course->category->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star neu-star text-xs"></i>
                                                @else
                                                    <i class="far fa-star neu-star text-xs"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $review->rating }}/5</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 leading-relaxed">
                                        {{ $review->review ? Str::limit($review->review, 40) : 'Không có nội dung' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($review->is_approved)
                                        <span class="neu-badge neu-badge-success">
                                            <i class="fas fa-check-circle "></i>
                                        </span>
                                    @else
                                        <span class="neu-badge neu-badge-warning">
                                            <i class="fas fa-clock "></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button onclick="showReviewDetail({{ $review->id }})"
                                                class="neu-button p-2 text-blue-600 hover:text-blue-800"
                                                title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="toggleApproval({{ $review->id }})"
                                                class="neu-button p-2 text-{{ $review->is_approved ? 'orange' : 'green' }}-600"
                                                title="{{ $review->is_approved ? 'Ẩn review' : 'Duyệt review' }}">
                                            <i class="fas fa-{{ $review->is_approved ? 'eye-slash' : 'check' }}"></i>
                                        </button>
                                        <button onclick="deleteReview({{ $review->id }})"
                                                class="neu-button p-2 text-red-600 hover:text-red-800"
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
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="neu-card-inset inline-block p-8 rounded-full mb-6">
                        <i class="fas fa-star text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Không có review nào</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Chưa có review nào trong hệ thống hoặc không tìm thấy kết quả phù hợp với tiêu chí lọc của bạn.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Review Detail Modal -->
    <div id="reviewDetailModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="neu-modal max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold gradient-text">Chi tiết Review</h3>
                        <button onclick="closeReviewDetail()" class="neu-button p-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div id="reviewDetailContent" class="space-y-6">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div id="bulkActionModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="neu-modal max-w-md w-full">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold gradient-text">Thao tác hàng loạt</h3>
                        <button onclick="closeBulkActionModal()" class="neu-button p-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <div class="neu-card-inset p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Đã chọn <span id="selectedCount" class="font-bold text-red-600">0</span> review</p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Chọn hành động</label>
                            <select id="bulkAction" class="neu-input w-full px-4 py-3 text-gray-700">
                                <option value="">Chọn hành động</option>
                                <option value="approve">Duyệt reviews</option>
                                <option value="reject">Ẩn reviews</option>
                                <option value="delete">Xóa reviews</option>
                            </select>
                        </div>

                        <div class="flex space-x-4">
                            <button onclick="executeBulkAction()" class="flex-1 neu-button-primary py-3 px-4 rounded-lg font-medium">
                                Thực hiện
                            </button>
                            <button onclick="closeBulkActionModal()" class="flex-1 neu-button py-3 px-4 rounded-lg font-medium text-gray-700">
                                Hủy
                            </button>
                        </div>
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
                    <div class="space-y-6">
                        <!-- Student Info -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Thông tin học viên</h4>
                            <div class="flex items-center space-x-4">
                                <img src="${review.student_avatar}" alt="${review.student_name}" class="w-12 h-12 neu-avatar object-cover">
                                <div>
                                    <h5 class="font-medium text-gray-900">${review.student_name}</h5>
                                    <p class="text-sm text-gray-600">${review.student_email}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Thông tin khóa học</h4>
                            <div class="flex items-center space-x-4">
                                ${review.course_thumbnail ? `<img src="${review.course_thumbnail}" alt="${review.course_title}" class="w-16 h-12 object-cover rounded-lg neu-avatar">` : ''}
                                <div>
                                    <p class="font-medium text-gray-900">${review.course_title}</p>
                                    <p class="text-sm text-gray-600">${review.course_category || 'N/A'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Đánh giá</h4>
                            <div class="flex items-center space-x-3">
                                <div class="flex text-yellow-400">
                                    ${Array.from({length: 5}, (_, i) =>
                            `<i class="fas fa-star${i < review.rating ? '' : '-o'} neu-star"></i>`
                        ).join('')}
                                </div>
                                <span class="text-xl font-bold text-gray-900">${review.rating}/5</span>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Nội dung đánh giá</h4>
                            <div class="neu-card-inset p-4 rounded-lg bg-gray-50">
                                <p class="text-gray-700 leading-relaxed">${review.review || 'Không có nội dung đánh giá'}</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Trạng thái</h4>
                            <span class="neu-badge ${review.is_approved ? 'neu-badge-success' : 'neu-badge-warning'}">
                                <i class="fas fa-${review.is_approved ? 'check-circle' : 'clock'} mr-1"></i>
                                ${review.is_approved ? 'Đã duyệt' : 'Chờ duyệt'}
                            </span>
                        </div>

                        <!-- Timestamps -->
                        <div class="neu-card-inset p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-4">Thông tin thời gian</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span class="font-medium">Ngày tạo:</span>
                                    <span>${review.created_at}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Cập nhật:</span>
                                    <span>${review.updated_at}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-4 pt-4">
                            <button onclick="toggleApproval(${review.id})"
                                    class="flex-1 ${review.is_approved ? 'neu-button-danger' : 'neu-button-primary'} py-3 px-4 rounded-lg font-medium">
                                <i class="fas fa-${review.is_approved ? 'eye-slash' : 'check'} mr-2"></i>
                                ${review.is_approved ? 'Ẩn review' : 'Duyệt review'}
                            </button>
                            <button onclick="deleteReview(${review.id})"
                                    class="neu-button-danger py-3 px-6 rounded-lg font-medium">
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
            alertDiv.className = `fixed top-6 right-6 p-4 rounded-xl shadow-lg z-50 max-w-sm animate-slide-in ${
                type === 'success' ? 'neu-badge-success border border-green-200' :
                    type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' :
                        type === 'warning' ? 'neu-badge-warning border border-yellow-200' :
                            'bg-blue-50 text-blue-800 border border-blue-200'
            }`;

            alertDiv.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-${
                type === 'success' ? 'check-circle' :
                    type === 'error' ? 'exclamation-circle' :
                        type === 'warning' ? 'exclamation-triangle' :
                            'info-circle'
            } mr-3 text-lg"></i>
                <span class="font-medium">${message}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-500 hover:text-gray-700 neu-button p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

            // Add slide-in animation
            const style = document.createElement('style');
            style.textContent = `
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in { animation: slide-in 0.3s ease-out; }
    `;
            document.head.appendChild(style);

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.style.animation = 'slide-in 0.3s ease-out reverse';
                    setTimeout(() => alertDiv.remove(), 300);
                }
            }, 5000);
        }

        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50';
            loadingDiv.innerHTML = `
        <div class="neu-modal p-8 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
            <span class="text-gray-900 font-medium">Đang xử lý...</span>
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

        // Add smooth transitions to page elements
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.neu-card, .neu-button, .neu-input');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
@endpush
