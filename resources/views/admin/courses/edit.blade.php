@extends('layouts.admin')

@section('title', 'Chỉnh sửa khóa học: ' . $course->title)

@section('content')
    <div class="container mx-auto p-4 max-w-7xl">
        <!-- Header with Course Status -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa khóa học</h1>
                <div class="mt-2 flex items-center space-x-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $course->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                    </span>
                    @if($course->enrolled_count > 0)
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1"></i>{{ $course->enrolled_count }} học viên đã đăng ký
                        </span>
                    @endif
                    @if($course->rating > 0)
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>{{ number_format($course->rating, 1) }} ({{ $course->reviews_count }} đánh giá)
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.courses.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <form action="{{ route('admin.courses.toggle-publish', $course) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg transition duration-200 font-medium
                                {{ $course->status === 'published'
                                    ? 'bg-yellow-500 hover:bg-yellow-600 text-white'
                                    : 'bg-green-600 hover:bg-green-700 text-white' }}">
                        <i class="fas fa-{{ $course->status === 'published' ? 'eye-slash' : 'eye' }} mr-2"></i>
                        {{ $course->status === 'published' ? 'Chuyển về nháp' : 'Xuất bản' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Course Builder Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Tab Navigation -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="flex space-x-6">
                    <button type="button" onclick="showTab('information')"
                            class="tab-button px-4 py-2 rounded-lg transition-colors flex items-center active"
                            data-tab="information">
                        <i class="fas fa-info-circle mr-2"></i>
                        Thông tin khóa học
                    </button>
                    <button type="button" onclick="showTab('curriculum')"
                            class="tab-button px-4 py-2 rounded-lg transition-colors flex items-center"
                            data-tab="curriculum">
                        <i class="fas fa-list mr-2"></i>
                        Chương trình học
                    </button>
                    <button type="button" onclick="showTab('settings')"
                            class="tab-button px-4 py-2 rounded-lg transition-colors flex items-center"
                            data-tab="settings">
                        <i class="fas fa-cog mr-2"></i>
                        Cài đặt nâng cao
                    </button>
                </div>
            </div>

            <!-- Information Tab -->
            <div id="information-tab" class="tab-content">
                <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-8">
                        <!-- Current Thumbnail Display - Thay thế phần thumbnail hiện tại -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-image mr-2"></i>Hình ảnh đại diện
                            </h3>

                            @if($course->thumbnail)
                                <div class="flex flex-col lg:flex-row gap-6">
                                    <!-- Current Image -->
                                    <div class="flex-shrink-0">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Hình ảnh hiện tại:</p>
                                        <!-- Sửa CSS để giữ tỷ lệ ảnh -->
                                        <div class="w-64 h-36 bg-gray-100 rounded-lg border overflow-hidden">
                                            <img src="{{ Storage::url($course->thumbnail) }}"
                                                 alt="{{ $course->title }}"
                                                 class="w-full h-full object-contain"> <!-- Đổi từ object-cover thành object-contain -->
                                        </div>
                                    </div>

                                    <!-- Upload New -->
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Thay đổi hình ảnh:</p>
                                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-gray-400 transition-colors">
                                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                   onchange="previewImage(this)">
                                            <div class="text-center">
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                                <div class="text-sm text-gray-600">
                                                    <label for="thumbnail" class="cursor-pointer hover:text-blue-600 font-medium">
                                                        Chọn hình ảnh mới
                                                    </label>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP tối đa 2MB</p>
                                            </div>
                                        </div>

                                        <!-- Preview New Image -->
                                        <div id="image-preview" class="hidden mt-4">
                                            <p class="text-sm font-medium text-gray-700 mb-2">Xem trước hình mới:</p>
                                            <div class="relative">
                                                <!-- Container với tỷ lệ cố định -->
                                                <div class="w-64 h-36 bg-gray-100 rounded-lg border overflow-hidden">
                                                    <img id="preview-img" src="" alt="Preview"
                                                         class="w-full h-full object-contain"> <!-- object-contain để giữ tỷ lệ -->
                                                </div>
                                                <button type="button" onclick="removeImage()"
                                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                                                    <i class="fas fa-times text-sm"></i>
                                                </button>
                                            </div>
                                            <!-- Thông tin ảnh -->
                                            <div id="image-info" class="mt-2 text-xs text-gray-500"></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- No current thumbnail -->
                                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 hover:border-gray-400 transition-colors">
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                           onchange="previewImage(this)">
                                    <div class="text-center">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-4"></i>
                                        <div class="text-lg font-medium text-gray-900 mb-2">Tải lên hình ảnh đại diện</div>
                                        <div class="text-sm text-gray-500">PNG, JPG, WEBP tối đa 2MB</div>
                                    </div>
                                </div>

                                <div id="image-preview" class="hidden mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Xem trước:</p>
                                    <div class="relative">
                                        <div class="w-64 h-36 bg-gray-100 rounded-lg border overflow-hidden">
                                            <img id="preview-img" src="" alt="Preview"
                                                 class="w-full h-full object-contain">
                                        </div>
                                        <button type="button" onclick="removeImage()"
                                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                                            <i class="fas fa-times text-sm"></i>
                                        </button>
                                    </div>
                                    <div id="image-info" class="mt-2 text-xs text-gray-500"></div>
                                </div>
                            @endif

                            @error('thumbnail')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-edit mr-2"></i>Thông tin cơ bản
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Title -->
                                <div class="lg:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tiêu đề khóa học <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                           placeholder="Nhập tiêu đề khóa học">
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
                                        <input type="text" name="slug" id="slug" value="{{ old('slug', $course->slug) }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror">
                                    </div>
                                    @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                                {{ $category->id == $course->category_id ? 'selected' : '' }}>
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
                                        <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Sơ cấp</option>
                                        <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                        <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
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
                                        <option value="vi" {{ old('language', $course->language) == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                        <option value="en" {{ old('language', $course->language) == 'en' ? 'selected' : '' }}>English</option>
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
                                           value="{{ old('duration_hours', $course->duration_hours) }}" min="1" max="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration_hours') border-red-500 @enderror">
                                    @error('duration_hours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-dollar-sign mr-2"></i>Thông tin giá
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Is Free Checkbox -->
                                <div class="lg:col-span-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_free" value="1" id="is_free_checkbox"
                                               {{ old('is_free', $course->is_free) ? 'checked' : '' }}
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
                                    <input type="number" name="price" id="price"
                                           value="{{ old('price', $course->price) }}"
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
                                           value="{{ old('discount_price', $course->discount_price) }}"
                                           min="0" step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_price') border-red-500 @enderror">
                                    @error('discount_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Price Preview -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Hiển thị giá</label>
                                    <div id="price-preview" class="p-3 bg-gray-50 rounded-lg border">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descriptions -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-align-left mr-2"></i>Mô tả khóa học
                            </h3>
                            <div class="space-y-6">
                                <!-- Short Description -->
                                <div>
                                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Mô tả ngắn <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="short_description" id="short_description" rows="3" maxlength="500"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('short_description') border-red-500 @enderror"
                                              placeholder="Tóm tắt ngắn gọn về khóa học (tối đa 500 ký tự)"
                                              onkeyup="updateCharCount('short_description', 500)">{{ old('short_description', $course->short_description) }}</textarea>
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
                                              onkeyup="updateCharCount('description', null, 50)">{{ old('description', $course->description) }}</textarea>
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
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-plus-circle mr-2"></i>Thông tin bổ sung
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Preview Video -->
                                <div>
                                    <label for="preview_video" class="block text-sm font-medium text-gray-700 mb-2">
                                        Video giới thiệu (YouTube URL)
                                    </label>
                                    <input type="url" name="preview_video" id="preview_video"
                                           value="{{ old('preview_video', $course->preview_video) }}"
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
                                    <input type="text" name="tags" id="tags"
                                           value="{{ old('tags', is_array($course->tags) ? implode(', ', $course->tags) : '') }}"
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
                                           value="{{ old('meta_title', $course->meta_title) }}" maxlength="60"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meta_title') border-red-500 @enderror"
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
                                              onkeyup="updateCharCount('meta_description', 160)">{{ old('meta_description', $course->meta_description) }}</textarea>
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

                    <!-- Form Actions for Information Tab -->
                    <div class="bg-gray-50 px-6 py-4 border-t flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Trường bắt buộc
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.courses.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition duration-200">
                                Hủy
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium">
                                <i class="fas fa-save mr-2"></i>Cập nhật khóa học
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Curriculum Tab -->
            <div id="curriculum-tab" class="tab-content hidden">
                <div class="flex h-screen max-h-96 lg:max-h-screen">
                    <!-- Left Sidebar (30%) - Course Sections -->
                    <div class="w-1/3 border-r bg-gray-50 flex flex-col">
                        <!-- Header -->
                        <div class="p-4 border-b bg-white">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-list-ul mr-2"></i>Chương trình học
                                </h3>
                                <a href="{{ route('admin.courses.sections.create', $course) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm transition duration-200 flex items-center">
                                    <i class="fas fa-plus mr-1"></i>Thêm chương
                                </a>
                            </div>
                            <!-- Drag & Drop Hint -->
                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-hand-rock mr-1"></i>
                                Kéo thả để sắp xếp thứ tự
                            </div>
                        </div>

                        <!-- Sections List - Sortable -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <div id="sections-sortable" class="space-y-3">
                                @forelse($course->sections()->orderBy('sort_order')->get() as $section)
                                    <div class="section-item bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                         data-section-id="{{ $section->id }}"
                                         onclick="loadSectionContent({{ $section->id }}, '{{ $section->title }}')">
                                        <div class="p-4">
                                            <div class="flex items-start">
                                                <!-- Drag Handle -->
                                                <div class="drag-handle flex-shrink-0 mr-3 mt-1 cursor-move text-gray-400 hover:text-gray-600">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>

                                                <div class="flex-1">
                                                    <h4 class="font-medium text-gray-900 mb-1 flex items-center">
                                                        <i class="fas fa-folder mr-2 text-blue-500"></i>
                                                        {{ $section->title }}
                                                    </h4>
                                                    <div class="text-sm text-gray-500 space-y-1">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-play-circle mr-1 text-green-500"></i>
                                                            {{ $section->lessons()->count() }} bài học
                                                        </div>
                                                        <div class="flex items-center">
                                                            <i class="fas fa-question-circle mr-1 text-purple-500"></i>
                                                            {{ $section->quizzes()->count() }} bài kiểm tra
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex flex-col space-y-1 ml-2">
                                                    <a href="{{ route('admin.courses.sections.edit', [$course, $section]) }}"
                                                       class="text-blue-600 hover:text-blue-800 text-xs"
                                                       onclick="event.stopPropagation()"
                                                       title="Chỉnh sửa chương">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.courses.sections.destroy', [$course, $section]) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa chương này?')"
                                                          onclick="event.stopPropagation()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs"
                                                                title="Xóa chương">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Quick Actions -->
                                            <div class="mt-3 pt-3 border-t border-gray-100 flex space-x-3 text-xs">
                                                <a href="{{ route('admin.courses.sections.lessons.create', [$course, $section]) }}"
                                                   class="text-green-600 hover:text-green-800 flex items-center"
                                                   onclick="event.stopPropagation()">
                                                    <i class="fas fa-plus mr-1"></i>Thêm bài học
                                                </a>
                                                <a href="{{ route('admin.courses.sections.quizzes.create', [$course, $section]) }}"
                                                   class="text-purple-600 hover:text-purple-800 flex items-center"
                                                   onclick="event.stopPropagation()">
                                                    <i class="fas fa-plus mr-1"></i>Thêm quiz
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <div class="text-gray-400 mb-4">
                                            <i class="fas fa-folder-open text-4xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm mb-2">Chưa có chương nào</p>
                                        <p class="text-gray-400 text-xs">Nhấn "Thêm chương" để bắt đầu</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Content (70%) - Section/Lesson Editor -->
                    <div class="flex-1 flex flex-col">
                        <!-- Content Header -->
                        <div id="content-header" class="p-4 border-b bg-white hidden">
                            <h3 id="content-title" class="text-lg font-semibold text-gray-900"></h3>
                            <p class="text-sm text-gray-600 mt-1">Quản lý nội dung của chương này</p>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-1 p-6" id="content-area">
                            <!-- Default State -->
                            <div id="default-content" class="text-center py-16">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-mouse-pointer text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Chọn chương để quản lý</h3>
                                <p class="text-sm text-gray-500 mb-6">Nhấn vào một chương bên trái để xem và chỉnh sửa nội dung</p>
                                @if($course->sections()->count() == 0)
                                    <a href="{{ route('admin.courses.sections.create', $course) }}"
                                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tạo chương đầu tiên
                                    </a>
                                @endif
                            </div>

                            <!-- Dynamic Content (will be loaded via JavaScript) -->
                            <div id="dynamic-content" class="hidden">
                                <!-- Content will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Tab -->
            <div id="settings-tab" class="tab-content hidden p-6 space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Thống kê và cài đặt
                </h3>

                <!-- Course Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-eye text-2xl text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-blue-600">Lượt xem</div>
                                <div class="text-2xl font-bold text-blue-700">{{ number_format($course->views_count) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-2xl text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-green-600">Học viên</div>
                                <div class="text-2xl font-bold text-green-700">{{ number_format($course->enrolled_count) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-star text-2xl text-yellow-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-yellow-600">Đánh giá</div>
                                <div class="text-2xl font-bold text-yellow-700">
                                    {{ $course->rating > 0 ? number_format($course->rating, 1) : 'N/A' }}
                                    @if($course->reviews_count > 0)
                                        <span class="text-sm text-yellow-600">({{ $course->reviews_count }})</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-list text-2xl text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-purple-600">Chương</div>
                                <div class="text-2xl font-bold text-purple-700">{{ $course->sections()->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Content Summary -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list-ul mr-2"></i>Tóm tắt nội dung
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-folder text-blue-500 mr-2"></i>
                            <span class="text-gray-600">Tổng số chương:</span>
                            <span class="ml-2 font-medium">{{ $course->sections()->count() }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-play-circle text-green-500 mr-2"></i>
                            <span class="text-gray-600">Tổng số bài học:</span>
                            <span class="ml-2 font-medium">{{ $course->lessons()->count() }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-question-circle text-purple-500 mr-2"></i>
                            <span class="text-gray-600">Tổng số quiz:</span>
                            <span class="ml-2 font-medium">{{ $course->quizzes()->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Publishing Information -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Thông tin xuất bản
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="ml-2 px-2 py-1 rounded-full text-xs font-medium
                                {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $course->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600">Ngày tạo:</span>
                            <span class="ml-2 font-medium">{{ $course->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600">Cập nhật lần cuối:</span>
                            <span class="ml-2 font-medium">{{ $course->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($course->published_at)
                            <div class="flex items-center">
                                <span class="text-gray-600">Ngày xuất bản:</span>
                                <span class="ml-2 font-medium">{{ $course->published_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Publishing Requirements Check -->
                @php
                    $publishErrors = [];
                    if (!$course->thumbnail) $publishErrors[] = 'Chưa có hình ảnh đại diện';
                    if (!$course->description || strlen($course->description) < 50) $publishErrors[] = 'Mô tả quá ngắn (tối thiểu 50 ký tự)';
                    if (!$course->short_description) $publishErrors[] = 'Chưa có mô tả ngắn';
                    if ($course->sections()->count() === 0) $publishErrors[] = 'Chưa có nội dung bài học';
                    if (!$course->is_free && ($course->price <= 0)) $publishErrors[] = 'Khóa học trả phí phải có giá lớn hơn 0';
                @endphp

                @if(count($publishErrors) > 0)
                    <div class="border border-yellow-200 bg-yellow-50 p-6 rounded-lg">
                        <h4 class="text-md font-semibold text-yellow-900 mb-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Yêu cầu để xuất bản
                        </h4>
                        <p class="text-sm text-yellow-700 mb-3">Khóa học cần hoàn thiện các mục sau để có thể xuất bản:</p>
                        <ul class="text-sm text-yellow-800 space-y-1">
                            @foreach($publishErrors as $error)
                                <li class="flex items-center">
                                    <i class="fas fa-times text-red-500 mr-2"></i>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="border border-green-200 bg-green-50 p-6 rounded-lg">
                        <h4 class="text-md font-semibold text-green-900 mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Sẵn sàng xuất bản
                        </h4>
                        <p class="text-sm text-green-700">Khóa học đã đáp ứng tất cả yêu cầu và có thể xuất bản.</p>
                    </div>
                @endif

                <!-- Danger Zone -->
                @if($course->enrolled_count == 0)
                    <div class="border border-red-200 bg-red-50 p-6 rounded-lg">
                        <h4 class="text-md font-semibold text-red-900 mb-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Vùng nguy hiểm
                        </h4>
                        <p class="text-sm text-red-700 mb-4">
                            Xóa khóa học sẽ không thể khôi phục. Hành động này sẽ xóa tất cả dữ liệu liên quan bao gồm các chương, bài học, và quiz.
                        </p>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa khóa học này không? Hành động này không thể hoàn tác!')"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                <i class="fas fa-trash mr-2"></i>Xóa khóa học
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border border-gray-200 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-md font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-shield-alt mr-2"></i>Được bảo vệ
                        </h4>
                        <p class="text-sm text-gray-700">
                            Khóa học đã có <strong>{{ $course->enrolled_count }}</strong> học viên đăng ký nên không thể xóa để bảo vệ dữ liệu học viên.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include SortableJS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's an active tab from session
            const activeTab = @json(session('active_tab', 'information'));

            // Show the appropriate tab
            showTab(activeTab);

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
        let sectionsSortable = null;
        let contentSortable = null;

        // Tab functionality
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            // Add active class to clicked button
            const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
            activeButton.classList.add('active', 'bg-blue-600', 'text-white');
            activeButton.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');

            // Initialize sortable when curriculum tab is shown
            if (tabName === 'curriculum') {
                setTimeout(() => {
                    initializeSectionsSortable();
                }, 100);
            }
        }

        // Initialize sections sortable
        function initializeSectionsSortable() {
            const sectionsContainer = document.getElementById('sections-sortable');
            if (sectionsContainer && !sectionsSortable) {
                sectionsSortable = Sortable.create(sectionsContainer, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function (evt) {
                        updateSectionOrder();
                    }
                });
            }
        }

        // Update section order via AJAX
        function updateSectionOrder() {
            const sectionItems = document.querySelectorAll('.section-item');
            const sectionIds = Array.from(sectionItems).map(item =>
                parseInt(item.getAttribute('data-section-id'))
            );

            fetch(`/admin/courses/{{ $course->id }}/sections/reorder`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    section_ids: sectionIds
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message);
                    } else {
                        showNotification('error', 'Có lỗi xảy ra khi cập nhật thứ tự');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Có lỗi xảy ra khi cập nhật thứ tự');
                });
        }

        // Section content loading
        function loadSectionContent(sectionId, sectionTitle) {
            // Update header
            document.getElementById('content-title').textContent = sectionTitle;
            document.getElementById('content-header').classList.remove('hidden');

            // Hide default content
            document.getElementById('default-content').classList.add('hidden');

            // Show dynamic content area
            const dynamicContent = document.getElementById('dynamic-content');
            dynamicContent.classList.remove('hidden');

            // Generate URLs with actual sectionId
            const courseId = {{ $course->id }};
            const lessonCreateUrl = `/admin/courses/${courseId}/sections/${sectionId}/lessons/create`;
            const quizCreateUrl = `/admin/courses/${courseId}/sections/${sectionId}/quizzes/create`;
            const sectionEditUrl = `/admin/courses/${courseId}/sections/${sectionId}/edit`;

            // Load section details with loading state
            dynamicContent.innerHTML = `
                <div class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-medium text-blue-900 mb-2 flex items-center">
                            <i class="fas fa-folder-open mr-2"></i>
                            Quản lý chương: ${sectionTitle}
                        </h4>
                        <p class="text-sm text-blue-700">Chọn một hành động bên dưới để quản lý nội dung của chương này.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="${lessonCreateUrl}"
                           class="block p-6 border-2 border-dashed border-green-300 rounded-lg hover:border-green-400 hover:bg-green-50 transition-all text-center group">
                            <i class="fas fa-plus-circle text-3xl text-green-500 mb-3 group-hover:text-green-600"></i>
                            <div class="font-medium text-green-700 mb-1">Thêm bài học mới</div>
                            <div class="text-sm text-green-600">Tạo nội dung học tập với video và tài liệu</div>
                        </a>

                        <a href="${quizCreateUrl}"
                           class="block p-6 border-2 border-dashed border-purple-300 rounded-lg hover:border-purple-400 hover:bg-purple-50 transition-all text-center group">
                            <i class="fas fa-question-circle text-3xl text-purple-500 mb-3 group-hover:text-purple-600"></i>
                            <div class="font-medium text-purple-700 mb-1">Thêm quiz mới</div>
                            <div class="text-sm text-purple-600">Tạo bài kiểm tra với câu hỏi</div>
                        </a>

                        <a href="${sectionEditUrl}"
                           class="block p-6 border-2 border-dashed border-blue-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all text-center group">
                            <i class="fas fa-edit text-3xl text-blue-500 mb-3 group-hover:text-blue-600"></i>
                            <div class="font-medium text-blue-700 mb-1">Chỉnh sửa chương</div>
                            <div class="text-sm text-blue-600">Cập nhật thông tin chương</div>
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="font-medium text-gray-900 flex items-center">
                                <i class="fas fa-list mr-2"></i>
                                Nội dung hiện tại
                            </h5>
                            <div id="section-stats-${sectionId}" class="text-sm text-gray-600">
                                <!-- Stats will be loaded here -->
                            </div>
                        </div>
                        <!-- Drag & Drop Hint for Content -->
                        <div class="mb-3 text-xs text-gray-500 flex items-center">
                            <i class="fas fa-hand-rock mr-1"></i>
                            Kéo thả để sắp xếp thứ tự bài học và quiz
                        </div>
                        <div id="section-content-${sectionId}" class="space-y-2">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-3"></i>
                                <div class="text-sm">Đang tải nội dung...</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Load section content via AJAX
            loadSectionContentDetails(sectionId);

            // Highlight selected section
            document.querySelectorAll('.section-item').forEach(item => {
                item.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
            });
            event.target.closest('.section-item').classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
        }

            // Load section content details via AJAX
            function loadSectionContentDetails(sectionId) {
                const courseId = {{ $course->id }};
                const contentContainer = document.getElementById(`section-content-${sectionId}`);
                const statsContainer = document.getElementById(`section-stats-${sectionId}`);

                fetch(`/admin/courses/${courseId}/sections/${sectionId}/content`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update stats
                        if (statsContainer) {
                            statsContainer.innerHTML = `
                            <div class="flex items-center space-x-4 text-xs">
                                <span class="flex items-center">
                                    <i class="fas fa-play-circle text-green-500 mr-1"></i>
                                    ${data.stats.lessons_count} bài học
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-question-circle text-purple-500 mr-1"></i>
                                    ${data.stats.quizzes_count} quiz
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock text-blue-500 mr-1"></i>
                                    ${data.stats.total_duration} phút
                                </span>
                            </div>
                        `;
                        }

                        // Update content list
                        if (contentContainer) {
                            if (data.content.length === 0) {
                                contentContainer.innerHTML = `
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-3"></i>
                                    <div class="text-sm mb-2">Chương này chưa có nội dung</div>
                                    <div class="text-xs text-gray-400">Thêm bài học hoặc quiz để bắt đầu</div>
                                </div>
                            `;
                            } else {
                                let contentHtml = '<div id="content-sortable-' + sectionId + '" class="space-y-2">';
                                data.content.forEach((item, index) => {
                                    const isLesson = item.type === 'lesson';
                                    const iconClass = isLesson ? 'fas fa-play-circle text-green-500' : 'fas fa-question-circle text-purple-500';
                                    const bgClass = isLesson ? 'border-green-200 bg-green-50' : 'border-purple-200 bg-purple-50';

                                    contentHtml += `
                                    <div class="content-item flex items-center justify-between p-3 border rounded-lg ${bgClass} hover:shadow-sm transition-shadow"
                                         data-content-id="${item.id}" data-content-type="${item.type}">
                                        <div class="flex items-center flex-1">
                                            <!-- Drag Handle -->
                                            <div class="drag-handle flex-shrink-0 mr-3 cursor-move text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-grip-vertical"></i>
                                            </div>
                                            <div class="flex-shrink-0 mr-3">
                                                <i class="${iconClass}"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-900 truncate">${item.title}</div>
                                                <div class="text-sm text-gray-500 flex items-center space-x-3">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-sort-numeric-up mr-1"></i>
                                                        #${item.sort_order || index + 1}
                                                    </span>
                                                    ${isLesson ? `
                                                        <span class="flex items-center">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            ${item.duration_minutes || 0} phút
                                                        </span>
                                                        ${item.is_free ? '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Miễn phí</span>' : ''}
                                                    ` : `
                                                        <span class="flex items-center">
                                                            <i class="fas fa-list-ol mr-1"></i>
                                                            ${item.questions_count || 0} câu hỏi
                                                        </span>
                                                        ${item.time_limit ? `
                                                            <span class="flex items-center">
                                                                <i class="fas fa-hourglass-half mr-1"></i>
                                                                ${item.time_limit} phút
                                                            </span>
                                                        ` : ''}
                                                    `}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <a href="${item.edit_url}"
                                               class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-blue-700 text-sm rounded-md hover:bg-blue-50 transition-colors"
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit mr-1"></i>
                                                Sửa
                                            </a>
                                            <button onclick="deleteContent('${item.delete_url}', '${item.title}', '${item.type}')"
                                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 text-red-700 text-sm rounded-md hover:bg-red-50 transition-colors"
                                                    title="Xóa">
                                                <i class="fas fa-trash mr-1"></i>
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                `;
                                });
                                contentHtml += '</div>';

                                contentContainer.innerHTML = contentHtml;

                                // Initialize sortable for content items
                                initializeContentSortable(sectionId);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading section content:', error);
                        if (contentContainer) {
                            contentContainer.innerHTML = `
                            <div class="text-center py-8 text-red-500">
                                <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                                <div class="text-sm mb-2">Lỗi khi tải nội dung</div>
                                <div class="text-xs text-gray-500">Vui lòng thử lại sau</div>
                                <button onclick="loadSectionContentDetails(${sectionId})"
                                        class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-redo mr-1"></i>
                                    Thử lại
                                </button>
                            </div>
                        `;
                        }
                    });
            }

            // Initialize content sortable
            function initializeContentSortable(sectionId) {
                const contentContainer = document.getElementById(`content-sortable-${sectionId}`);
                if (contentContainer) {
                    // Destroy existing sortable if any
                    if (contentSortable) {
                        contentSortable.destroy();
                    }

                    contentSortable = Sortable.create(contentContainer, {
                        handle: '.drag-handle',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        onEnd: function (evt) {
                            updateContentOrder(sectionId);
                        }
                    });
                }
            }

            // Update content order via AJAX
            function updateContentOrder(sectionId) {
                const contentItems = document.querySelectorAll(`#content-sortable-${sectionId} .content-item`);
                const items = Array.from(contentItems).map(item => ({
                    id: parseInt(item.getAttribute('data-content-id')),
                    type: item.getAttribute('data-content-type')
                }));

                // Debug log
                console.log('Updating content order:', {
                    sectionId: sectionId,
                    items: items
                });

                fetch(`/admin/courses/{{ $course->id }}/sections/${sectionId}/content/reorder`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        items: items
                    })
                })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            return response.text().then(text => {
                                console.error('Response text:', text);
                                throw new Error(`HTTP ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success response:', data);
                        if (data.success) {
                            showNotification('success', data.message);
                        } else {
                            showNotification('error', data.message || 'Có lỗi xảy ra khi cập nhật thứ tự nội dung');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Có lỗi xảy ra khi cập nhật thứ tự nội dung: ' + error.message);
                    });
            }

            // Delete content function
            function deleteContent(deleteUrl, title, type) {
                const typeName = type === 'lesson' ? 'bài học' : 'quiz';

                if (confirm(`Bạn có chắc muốn xóa ${typeName} "${title}" không?\n\nHành động này không thể hoàn tác!`)) {
                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    form.style.display = 'none';

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrfInput);

                    // Add method override
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    // Add to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Show notification
            function showNotification(type, message) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

                // Add to body
                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Hide notification after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }

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
                const imageInfo = document.getElementById('image-info');
                if (imageInfo) {
                    imageInfo.textContent = '';
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
                    preview.innerHTML = '<span class="text-lg font-bold text-green-600"><i class="fas fa-gift mr-1"></i>Miễn phí</span>';
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

                // Initialize active tab styles
                const activeButton = document.querySelector('.tab-button.active');
                if (activeButton) {
                    activeButton.classList.add('bg-blue-600', 'text-white');
                    activeButton.classList.remove('text-gray-600');
                }
            });
    </script>

    <style>
        .tab-button:not(.active) {
            @apply text-gray-600 hover:text-gray-900 hover:bg-gray-100;
        }
        .tab-button.active {
            @apply bg-blue-600 text-white;
        }

        .section-item:hover {
            @apply shadow-md;
        }

        .section-item.selected {
            @apply ring-2 ring-blue-500 bg-blue-50;
        }

        /* Sortable styles */
        .sortable-ghost {
            @apply opacity-30;
        }

        .sortable-chosen {
            @apply transform scale-105;
        }

        .sortable-drag {
            @apply transform rotate-3;
        }

        .drag-handle {
            @apply transition-colors;
        }

        .drag-handle:hover {
            @apply text-blue-500;
        }

        /* Content item hover effects */
        .content-item:hover .drag-handle {
            @apply text-blue-500;
        }
    </style>
@endsection
