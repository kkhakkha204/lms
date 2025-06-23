@extends('layouts.app')

@section('title', 'Tạo khóa học mới')

@section('content')
    <div class="container mx-auto p-4 max-w-6xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tạo khóa học mới</h1>
            <a href="{{ route('admin.courses.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                ← Quay lại
            </a>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-lg overflow-hidden">
            @csrf

            <!-- Progress Steps -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Thông tin cơ bản</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="ml-2 text-sm text-gray-500">Nội dung khóa học</span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-8">
                <!-- Thumbnail Upload Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hình ảnh đại diện</h3>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Upload Area -->
                        <div class="flex-1">
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-gray-400 transition-colors">
                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       onchange="previewImage(this)">
                                <div class="text-center">
                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="mt-4">
                                        <label for="thumbnail" class="cursor-pointer">
                                            <span class="mt-2 block text-sm font-medium text-gray-900">
                                                Tải lên hình ảnh
                                            </span>
                                            <span class="mt-2 block text-sm text-gray-500">
                                                PNG, JPG, WEBP tối đa 2MB
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('thumbnail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Area - Thay thế phần preview hiện tại -->
                        <div class="flex-1">
                            <div id="image-preview" class="hidden">
                                <p class="text-sm font-medium text-gray-700 mb-2">Xem trước:</p>
                                <div class="relative">
                                    <!-- Sửa lại CSS để giữ tỷ lệ ảnh -->
                                    <div class="w-full h-48 bg-gray-100 rounded-lg border overflow-hidden">
                                        <img id="preview-img" src="" alt="Preview"
                                             class="w-full h-full object-contain"> <!-- Đổi từ object-cover thành object-contain -->
                                    </div>
                                    <button type="button" onclick="removeImage()"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Thêm thông tin ảnh -->
                                <div id="image-info" class="mt-2 text-xs text-gray-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cơ bản</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="lg:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Tiêu đề khóa học <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                   placeholder="Nhập tiêu đề khóa học"
                                   onblur="generateSlug()">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="lg:col-span-2">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                Đường dẫn (URL slug)
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    {{ url('/courses/') }}/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                                       placeholder="tu-dong-tao-neu-de-trong">
                            </div>
                            @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Để trống để tự động tạo từ tiêu đề</p>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Danh mục <span class="text-red-500">*</span>
                            </label>
                            <select name="categories[]" multiple
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('categories') border-red-500 @enderror"
                                    size="4">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Ctrl+Click để chọn nhiều danh mục</p>
                        </div>

                        <!-- Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                Cấp độ <span class="text-red-500">*</span>
                            </label>
                            <select name="level" id="level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('level') border-red-500 @enderror">
                                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Sơ cấp</option>
                                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
                            </select>
                            @error('level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Language -->
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                Ngôn ngữ <span class="text-red-500">*</span>
                            </label>
                            <select name="language" id="language"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('language') border-red-500 @enderror">
                                <option value="vi" {{ old('language', 'vi') == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                            @error('language')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Thời lượng (giờ) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="duration_hours" id="duration_hours"
                                   value="{{ old('duration_hours', 1) }}" min="1" max="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration_hours') border-red-500 @enderror">
                            @error('duration_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin giá</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Is Free Checkbox -->
                        <div class="lg:col-span-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_free" value="1" id="is_free_checkbox"
                                       {{ old('is_free') ? 'checked' : '' }}
                                       onchange="togglePriceFields()"
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Khóa học miễn phí</span>
                            </label>
                        </div>

                        <!-- Price -->
                        <div id="price-field">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Giá gốc (VND) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" id="price" value="{{ old('price', 0) }}"
                                   min="0" step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                            @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount Price -->
                        <div id="discount-price-field">
                            <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Giá khuyến mãi (VND)
                            </label>
                            <input type="number" name="discount_price" id="discount_price"
                                   value="{{ old('discount_price') }}" min="0" step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_price') border-red-500 @enderror">
                            @error('discount_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hiển thị giá</label>
                            <div id="price-preview" class="p-3 bg-gray-50 rounded-lg border">
                                <span class="text-lg font-bold text-green-600">Miễn phí</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descriptions -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Mô tả khóa học</h3>
                    <div class="space-y-6">
                        <!-- Short Description -->
                        <div>
                            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Mô tả ngắn <span class="text-red-500">*</span>
                            </label>
                            <textarea name="short_description" id="short_description" rows="3" maxlength="500"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('short_description') border-red-500 @enderror"
                                      placeholder="Tóm tắt ngắn gọn về khóa học (tối đa 500 ký tự)"
                                      onkeyup="updateCharCount('short_description', 500)">{{ old('short_description') }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('short_description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Hiển thị trong danh sách khóa học</p>
                                    @enderror
                                    <span id="short_description_count" class="text-sm text-gray-500">0/500</span>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Mô tả chi tiết <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                      placeholder="Mô tả chi tiết về khóa học, nội dung, mục tiêu học tập... (tối thiểu 50 ký tự)"
                                      onkeyup="updateCharCount('description', null, 50)">{{ old('description') }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Hiển thị trong trang chi tiết khóa học</p>
                                    @enderror
                                    <span id="description_count" class="text-sm text-gray-500">0 ký tự (tối thiểu 50)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Fields -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin bổ sung</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Preview Video -->
                        <div>
                            <label for="preview_video" class="block text-sm font-medium text-gray-700 mb-2">
                                Video giới thiệu (YouTube URL)
                            </label>
                            <input type="url" name="preview_video" id="preview_video"
                                   value="{{ old('preview_video') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('preview_video') border-red-500 @enderror"
                                   placeholder="https://youtube.com/watch?v=...">
                            @error('preview_video')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                                Từ khóa (Tags)
                            </label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tags') border-red-500 @enderror"
                                   placeholder="javascript, web development, react">
                            @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Phân cách bằng dấu phẩy</p>
                        </div>

                        <!-- Meta Title -->
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Tiêu đề SEO
                            </label>
                            <input type="text" name="meta_title" id="meta_title"
                                   value="{{ old('meta_title') }}" maxlength="60"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meta_title') border-red-500 @enderror"
                                   placeholder="Để trống để tự động tạo từ tiêu đề"
                                   onkeyup="updateCharCount('meta_title', 60)">
                            <div class="flex justify-between mt-1">
                                @error('meta_title')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Hiển thị trên Google Search</p>
                                    @enderror
                                    <span id="meta_title_count" class="text-sm text-gray-500">0/60</span>
                            </div>
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Mô tả SEO
                            </label>
                            <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meta_description') border-red-500 @enderror"
                                      placeholder="Để trống để tự động tạo từ mô tả ngắn"
                                      onkeyup="updateCharCount('meta_description', 160)">{{ old('meta_description') }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('meta_description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Hiển thị trên Google Search</p>
                                    @enderror
                                    <span id="meta_description_count" class="text-sm text-gray-500">0/160</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    <span class="text-red-500">*</span> Trường bắt buộc
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="window.history.back()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition duration-200">
                        Hủy
                    </button>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium">
                        Tạo khóa học
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Cập nhật hàm previewImage để hiển thị thông tin ảnh
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const imageInfo = document.getElementById('image-info');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');

                    // Hiển thị thông tin file
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    imageInfo.textContent = `Kích thước: ${fileSize}MB | Định dạng: ${file.type}`;

                    // Tính toán kích thước ảnh
                    previewImg.onload = function() {
                        const img = new Image();
                        img.onload = function() {
                            imageInfo.textContent += ` | Độ phân giải: ${img.width}x${img.height}px`;
                        };
                        img.src = e.target.result;
                    };
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('thumbnail').value = '';
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('image-info').textContent = '';
        }

        // Slug generation
        function generateSlug() {
            const title = document.getElementById('title').value;
            const slugField = document.getElementById('slug');

            if (title && !slugField.value) {
                fetch('{{ route("admin.courses.generate-slug") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ title: title })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.slug) {
                            slugField.value = data.slug;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Price toggle functionality
        function togglePriceFields() {
            const isFree = document.getElementById('is_free_checkbox').checked;
            const priceField = document.getElementById('price-field');
            const discountField = document.getElementById('discount-price-field');
            const priceInput = document.getElementById('price');
            const discountInput = document.getElementById('discount_price');

            if (isFree) {
                priceField.style.display = 'none';
                discountField.style.display = 'none';
                priceInput.value = 0;
                discountInput.value = '';
            } else {
                priceField.style.display = 'block';
                discountField.style.display = 'block';
                if (priceInput.value == 0) {
                    priceInput.value = '';
                }
            }
            updatePricePreview();
        }

        // Price preview update
        function updatePricePreview() {
            const isFree = document.getElementById('is_free_checkbox').checked;
            const price = parseFloat(document.getElementById('price').value) || 0;
            const discountPrice = parseFloat(document.getElementById('discount_price').value) || 0;
            const preview = document.getElementById('price-preview');

            if (isFree || price === 0) {
                preview.innerHTML = '<span class="text-lg font-bold text-green-600">Miễn phí</span>';
            } else if (discountPrice > 0 && discountPrice < price) {
                preview.innerHTML = `
                    <div class="space-y-1">
                        <div class="text-lg font-bold text-red-600">${new Intl.NumberFormat('vi-VN').format(discountPrice)}₫</div>
                        <div class="text-sm text-gray-500 line-through">${new Intl.NumberFormat('vi-VN').format(price)}₫</div>
                    </div>
                `;
            } else {
                preview.innerHTML = `<span class="text-lg font-bold text-blue-600">${new Intl.NumberFormat('vi-VN').format(price)}₫</span>`;
            }
        }

        // Character count functionality
        function updateCharCount(fieldId, maxLength = null, minLength = null) {
            const field = document.getElementById(fieldId);
            const counter = document.getElementById(fieldId + '_count');
            const currentLength = field.value.length;

            if (maxLength) {
                counter.textContent = `${currentLength}/${maxLength}`;
                counter.className = currentLength > maxLength ? 'text-sm text-red-500' : 'text-sm text-gray-500';
            } else if (minLength) {
                const remaining = Math.max(0, minLength - currentLength);
                if (remaining > 0) {
                    counter.textContent = `${currentLength} ký tự (còn thiếu ${remaining})`;
                    counter.className = 'text-sm text-red-500';
                } else {
                    counter.textContent = `${currentLength} ký tự ✓`;
                    counter.className = 'text-sm text-green-500';
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set up price field listeners
            document.getElementById('price').addEventListener('input', updatePricePreview);
            document.getElementById('discount_price').addEventListener('input', updatePricePreview);

            // Initialize price preview
            togglePriceFields();

            // Initialize character counters
            updateCharCount('short_description', 500);
            updateCharCount('description', null, 50);
            updateCharCount('meta_title', 60);
            updateCharCount('meta_description', 160);
        });
    </script>
@endsection
