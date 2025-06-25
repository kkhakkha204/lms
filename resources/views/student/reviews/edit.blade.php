@extends('layouts.app')

@section('title', 'Chỉnh sửa đánh giá: ' . $course->title)

@section('content')
    <div class="min-h-screen bg-gray-50 py-36">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-start space-x-4">
                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/120x80?text=Course' }}"
                         alt="{{ $course->title }}"
                         class="w-20 h-14 object-cover rounded">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Chỉnh sửa đánh giá</h1>
                        <h2 class="text-lg font-semibold text-blue-600 mb-1">{{ $course->title }}</h2>
                        <p class="text-sm text-gray-600">Giảng viên: {{ $course->instructor->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('courses.review.update', $course->slug) }}" method="POST" id="reviewForm">
                    @csrf
                    @method('PUT')

                    <!-- Rating Section -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-gray-900 mb-4">
                            Đánh giá tổng thể <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-1 mb-2" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        class="star text-3xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors duration-200 focus:outline-none"
                                        data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600 mb-2" id="ratingText">
                            @php
                                $ratingTexts = [
                                    1 => 'Rất tệ - 1 sao',
                                    2 => 'Tệ - 2 sao',
                                    3 => 'Trung bình - 3 sao',
                                    4 => 'Tốt - 4 sao',
                                    5 => 'Tuyệt vời - 5 sao'
                                ];
                            @endphp
                            {{ $ratingTexts[$review->rating] ?? 'Chọn số sao để đánh giá' }}
                        </p>
                        <input type="hidden" name="rating" id="ratingInput" value="{{ $review->rating }}">
                        @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Review Content -->
                    <div class="mb-8">
                        <label for="review" class="block text-lg font-semibold text-gray-900 mb-4">
                            Nội dung đánh giá
                        </label>
                        <textarea name="review"
                                  id="review"
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Chia sẻ trải nghiệm của bạn về khóa học này... (Tùy chọn)">{{ old('review', $review->review) }}</textarea>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-sm text-gray-500">Tối đa 1000 ký tự</p>
                            <span class="text-sm text-gray-500" id="charCount">{{ strlen($review->review ?? '') }}/1000</span>
                        </div>
                        @error('review')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Original Review Info -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Thông tin đánh giá
                        </h3>
                        <p class="text-sm text-gray-600">
                            Đánh giá đầu tiên: {{ $review->created_at->format('d/m/Y H:i') }}
                        </p>
                        @if($review->updated_at && $review->updated_at != $review->created_at)
                            <p class="text-sm text-gray-600">
                                Cập nhật lần cuối: {{ $review->updated_at->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between">
                        <div class="flex space-x-3">
                            <a href="{{ route('student.courses.show', $course->slug) }}"
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Quay lại
                            </a>

                            <button type="button"
                                    onclick="confirmDelete()"
                                    class="px-6 py-3 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Xóa đánh giá
                            </button>
                        </div>

                        <button type="submit"
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            Cập nhật đánh giá
                        </button>
                    </div>
                </form>

                <!-- Delete Form (Hidden) -->
                <form action="{{ route('courses.review.destroy', $course->slug) }}" method="POST" id="deleteForm" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa đánh giá</h3>
            </div>

            <p class="text-gray-600 mb-6">
                Bạn có chắc chắn muốn xóa đánh giá này? Hành động này không thể hoàn tác.
            </p>

            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Hủy
                </button>
                <button type="button"
                        onclick="submitDelete()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Xóa đánh giá
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.getElementById('ratingText');
            const reviewTextarea = document.getElementById('review');
            const charCount = document.getElementById('charCount');

            const ratingTexts = {
                1: 'Rất tệ - 1 sao',
                2: 'Tệ - 2 sao',
                3: 'Trung bình - 3 sao',
                4: 'Tốt - 4 sao',
                5: 'Tuyệt vời - 5 sao'
            };

            let currentRating = {{ $review->rating }};

            // Handle star rating
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    highlightStars(index + 1);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(currentRating);
                });

                star.addEventListener('click', function() {
                    currentRating = index + 1;
                    ratingInput.value = currentRating;
                    ratingText.textContent = ratingTexts[currentRating];
                    highlightStars(currentRating);
                });
            });

            function highlightStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            // Handle character count
            reviewTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length + '/1000';

                if (length > 1000) {
                    charCount.classList.add('text-red-500');
                    this.value = this.value.substring(0, 1000);
                    charCount.textContent = '1000/1000';
                } else {
                    charCount.classList.remove('text-red-500');
                }
            });
        });

        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        function submitDelete() {
            document.getElementById('deleteForm').submit();
        }
    </script>
@endpush

@push('styles')
    <style>
        .star {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .star:hover {
            transform: scale(1.1);
        }

        #review:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        @media (max-width: 768px) {
            .star {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush
