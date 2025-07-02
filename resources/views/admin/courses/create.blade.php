@extends('layouts.admin')

@section('title', 'Tạo khóa học mới')

@section('content')
    <div class="container mx-auto p-4 max-w-6xl">
        <!-- Header -->
        <div class="flex items-center justify-between mb-12">
            <div class="relative">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-primary via-accent to-danger bg-clip-text text-transparent mb-3 tracking-tight">
                    Tạo khóa học mới
                </h1>
                <p class="text-gray-500 text-lg font-light leading-relaxed pl-1">
                    Tạo một khóa học chất lượng cao để chia sẻ kiến thức của bạn
                </p>
                <div class="mt-2 w-16 h-0.5 bg-gradient-to-r from-accent to-danger rounded-full"></div>
            </div>
            <div class="flex flex-col items-end space-y-3">
                <a href="{{ route('admin.courses.index') }}"
                   class="group relative neumorph-button px-8 py-4 text-primary font-semibold rounded-2xl hover:text-accent transition-all duration-500 flex items-center space-x-3 border-0 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-accent/5 to-danger/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="relative z-10">Quay lại</span>
                </a>
                <div class="text-xs text-gray-400 font-medium tracking-wide">Course Builder</div>
            </div>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-lg overflow-hidden">
            @csrf

            <!-- Progress Steps -->
            <div class="bg-white px-8 py-6 border-b border-gray-100 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-accent/2 via-transparent to-danger/2"></div>
                <div class="relative flex items-center justify-center max-w-2xl mx-auto">
                    <div class="flex items-center group">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-accent to-danger text-white rounded-2xl flex items-center justify-center text-sm font-bold shadow-neumorph-sm relative z-10 transform group-hover:scale-105 transition-transform duration-300">
                                <span class="relative z-10">1</span>
                                <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="absolute -inset-1 bg-gradient-to-br from-accent to-danger rounded-2xl opacity-20 blur-sm"></div>
                        </div>
                        <div class="ml-4">
                <span class="text-base font-semibold bg-gradient-to-r from-accent to-danger bg-clip-text text-transparent">
                    Thông tin cơ bản
                </span>
                            <div class="text-xs text-gray-500 mt-0.5 font-medium">Đang hoạt động</div>
                        </div>
                    </div>

                    <div class="flex-1 mx-8 relative">
                        <div class="h-1 bg-gray-100 rounded-full shadow-neumorph-inset">
                            <div class="h-full w-1/3 bg-gradient-to-r from-accent to-danger rounded-full shadow-sm transition-all duration-700 ease-out relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/30 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center group cursor-pointer">
                        <div class="relative">
                            <div class="w-12 h-12 bg-white text-gray-400 rounded-2xl flex items-center justify-center text-sm font-bold shadow-neumorph relative z-10 group-hover:text-accent group-hover:shadow-neumorph-sm transition-all duration-300">
                                <span class="relative z-10">2</span>
                            </div>
                            <div class="absolute -inset-1 bg-gradient-to-br from-accent to-danger rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity duration-300 blur-sm"></div>
                        </div>
                        <div class="ml-4">
                <span class="text-base font-medium text-gray-500 group-hover:text-gray-700 transition-colors duration-300">
                    Nội dung khóa học
                </span>
                            <div class="text-xs text-gray-400 mt-0.5 font-medium">Sắp tới</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-10">
                <!-- Thumbnail Upload Section -->
                <div class="relative">
                    <div class="absolute -top-3 -left-3 w-6 h-6 bg-gradient-to-br from-accent to-danger rounded-full opacity-20"></div>
                    <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                            <h3 class="text-xl font-bold text-primary">Hình ảnh đại diện</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                            <!-- Upload Area -->
                            <div class="lg:col-span-3">
                                <div class="relative bg-gray-50/50 rounded-2xl p-8 border-2 border-dashed border-gray-200 hover:border-accent/30 transition-all duration-500 group">
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                           onchange="previewImage(this)">
                                    <div class="text-center">
                                        <div class="mx-auto h-16 w-16 text-gray-400 group-hover:text-accent/60 transition-colors duration-300">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 48 48" class="w-full h-full">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="mt-6">
                                            <label for="thumbnail" class="cursor-pointer">
                                    <span class="block text-lg font-semibold text-primary group-hover:text-accent transition-colors">
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
                                <p class="mt-3 text-sm text-danger font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preview Area -->
                            <div class="lg:col-span-2">
                                <div id="image-preview" class="hidden">
                                    <div class="relative">
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 overflow-hidden shadow-neumorph-sm">
                                            <img id="preview-img" src="" alt="Preview" class="w-full h-full object-contain">
                                        </div>
                                        <button type="button" onclick="removeImage()"
                                                class="absolute -top-2 -right-2 bg-danger hover:bg-danger/90 text-white rounded-full p-2 shadow-lg transition-all duration-300 hover:scale-110">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="image-info" class="mt-3 text-xs text-gray-500 font-medium"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-8">
                        <!-- Basic Information -->
                        <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                <h3 class="text-xl font-bold text-primary">Thông tin cơ bản</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Tiêu đề khóa học <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                           class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all duration-300 @error('title') border-danger @enderror"
                                           placeholder="Nhập tiêu đề khóa học"
                                           onblur="generateSlug()">
                                    @error('title')
                                    <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Đường dẫn (URL slug)
                                    </label>
                                    <div class="flex rounded-xl overflow-hidden shadow-neumorph-sm">
                            <span class="inline-flex items-center px-4 bg-gray-100 text-gray-600 text-sm font-medium border-r border-gray-200">
                                {{ url('/courses/') }}/
                            </span>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                               class="flex-1 px-4 py-3 bg-gray-50/50 border-0 focus:ring-2 focus:ring-accent/20 @error('slug') border-danger @enderror"
                                               placeholder="tu-dong-tao-neu-de-trong">
                                    </div>
                                    @error('slug')
                                    <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">Để trống để tự động tạo từ tiêu đề</p>
                                </div>

                                <!-- Categories & Level -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            Danh mục <span class="text-danger">*</span>
                                        </label>
                                        <select name="categories[]" multiple
                                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('categories') border-danger @enderror"
                                                size="4">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="level" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Cấp độ <span class="text-danger">*</span>
                                        </label>
                                        <select name="level" id="level"
                                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('level') border-danger @enderror">
                                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Sơ cấp</option>
                                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
                                        </select>
                                        @error('level')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Language & Duration -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="language" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Ngôn ngữ <span class="text-danger">*</span>
                                        </label>
                                        <select name="language" id="language"
                                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('language') border-danger @enderror">
                                            <option value="vi" {{ old('language', 'vi') == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                            <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                        @error('language')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="duration_hours" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Thời lượng (giờ) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="duration_hours" id="duration_hours"
                                               value="{{ old('duration_hours', 1) }}" min="1" max="1000"
                                               class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('duration_hours') border-danger @enderror">
                                        @error('duration_hours')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descriptions -->
                        <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                <h3 class="text-xl font-bold text-primary">Mô tả khóa học</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Short Description -->
                                <div>
                                    <label for="short_description" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Mô tả ngắn <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="short_description" id="short_description" rows="3" maxlength="500"
                                              class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all resize-none @error('short_description') border-danger @enderror"
                                              placeholder="Tóm tắt ngắn gọn về khóa học (tối đa 500 ký tự)"
                                              onkeyup="updateCharCount('short_description', 500)">{{ old('short_description') }}</textarea>
                                    <div class="flex justify-between mt-2">
                                        @error('short_description')
                                        <p class="text-sm text-danger font-medium">{{ $message }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Hiển thị trong danh sách khóa học</p>
                                            @enderror
                                            <span id="short_description_count" class="text-xs text-gray-500 font-medium">0/500</span>
                                    </div>
                                </div>

                                <!-- Full Description -->
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Mô tả chi tiết <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description" rows="6"
                                              class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all resize-none @error('description') border-danger @enderror"
                                              placeholder="Mô tả chi tiết về khóa học, nội dung, mục tiêu học tập..."
                                              onkeyup="updateCharCount('description', null, 50)">{{ old('description') }}</textarea>
                                    <div class="flex justify-between mt-2">
                                        @error('description')
                                        <p class="text-sm text-danger font-medium">{{ $message }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Hiển thị trong trang chi tiết khóa học</p>
                                            @enderror
                                            <span id="description_count" class="text-xs text-gray-500 font-medium">0 ký tự (tối thiểu 50)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-8">
                        <!-- Pricing -->
                        <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                <h3 class="text-xl font-bold text-primary">Thông tin giá</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Is Free Checkbox -->
                                <div class="flex items-center p-4 bg-gradient-to-r from-accent/5 to-danger/5 rounded-xl border border-accent/10">
                                    <input type="checkbox" name="is_free" value="1" id="is_free_checkbox"
                                           {{ old('is_free') ? 'checked' : '' }}
                                           onchange="togglePriceFields()"
                                           class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent/20">
                                    <span class="ml-3 text-sm font-semibold text-primary">Khóa học miễn phí</span>
                                </div>

                                <!-- Price Fields -->
                                <div class="grid grid-cols-1 gap-4">
                                    <div id="price-field">
                                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Giá gốc (VND) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="price" id="price" value="{{ old('price', 0) }}"
                                               min="0" step="1000"
                                               class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('price') border-danger @enderror">
                                        @error('price')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div id="discount-price-field">
                                        <label for="discount_price" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Giá khuyến mãi (VND)
                                        </label>
                                        <input type="number" name="discount_price" id="discount_price"
                                               value="{{ old('discount_price') }}" min="0" step="1000"
                                               class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('discount_price') border-danger @enderror">
                                        @error('discount_price')
                                        <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Price Preview -->
                                <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 shadow-neumorph-sm">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Hiển thị giá</label>
                                    <div id="price-preview">
                                        <span class="text-2xl font-bold text-green-600">Miễn phí</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Fields -->
                        <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                <h3 class="text-xl font-bold text-primary">Thông tin bổ sung</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Preview Video -->
                                <div>
                                    <label for="preview_video" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Video giới thiệu (YouTube URL)
                                    </label>
                                    <input type="url" name="preview_video" id="preview_video"
                                           value="{{ old('preview_video') }}"
                                           class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('preview_video') border-danger @enderror"
                                           placeholder="https://youtube.com/watch?v=...">
                                    @error('preview_video')
                                    <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div>
                                    <label for="tags" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Từ khóa (Tags)
                                    </label>
                                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                                           class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('tags') border-danger @enderror"
                                           placeholder="javascript, web development, react">
                                    @error('tags')
                                    <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">Phân cách bằng dấu phẩy</p>
                                </div>

                                <!-- SEO Fields -->
                                <div class="space-y-4 pt-4 border-t border-gray-100">
                                    <div>
                                        <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Tiêu đề SEO
                                        </label>
                                        <input type="text" name="meta_title" id="meta_title"
                                               value="{{ old('meta_title') }}" maxlength="60"
                                               class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('meta_title') border-danger @enderror"
                                               placeholder="Để trống để tự động tạo từ tiêu đề"
                                               onkeyup="updateCharCount('meta_title', 60)">
                                        <div class="flex justify-between mt-2">
                                            @error('meta_title')
                                            <p class="text-sm text-danger font-medium">{{ $message }}</p>
                                            @else
                                                <p class="text-xs text-gray-500">Hiển thị trên Google Search</p>
                                                @enderror
                                                <span id="meta_title_count" class="text-xs text-gray-500 font-medium">0/60</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-3">
                                            Mô tả SEO
                                        </label>
                                        <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                                                  class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all resize-none @error('meta_description') border-danger @enderror"
                                                  placeholder="Để trống để tự động tạo từ mô tả ngắn"
                                                  onkeyup="updateCharCount('meta_description', 160)">{{ old('meta_description') }}</textarea>
                                        <div class="flex justify-between mt-2">
                                            @error('meta_description')
                                            <p class="text-sm text-danger font-medium">{{ $message }}</p>
                                            @else
                                                <p class="text-xs text-gray-500">Hiển thị trên Google Search</p>
                                                @enderror
                                                <span id="meta_description_count" class="text-xs text-gray-500 font-medium">0/160</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="relative mt-12">
                <div class="absolute inset-0 bg-gradient-to-r from-accent/5 via-transparent to-danger/5 rounded-3xl"></div>
                <div class="relative bg-white/80 backdrop-blur-sm px-8 py-6 rounded-3xl shadow-neumorph border border-gray-100/50">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-600 font-medium">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-[#ed292a] text-lg rounded-full mr-2">*</span>
                                Trường bắt buộc
                            </div>
                        </div>

                        <div class="flex space-x-4 w-full sm:w-auto">
                            <button type="button" onclick="window.history.back()"
                                    class="group flex-1 sm:flex-none relative neumorph-button px-8 py-4 text-gray-700 font-semibold rounded-2xl hover:text-primary transition-all duration-500 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-100/50 to-gray-200/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Hủy</span>
                                </div>
                            </button>

                            <button type="submit"
                                    class="group flex-1 sm:flex-none relative bg-gradient-to-r from-accent to-danger hover:from-accent/90 hover:to-danger/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden">
                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative flex items-center justify-center space-x-3">
                                    <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    <span class="tracking-wide">Tạo khóa học</span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 via-transparent to-transparent -skew-x-12 transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </button>
                        </div>
                    </div>

                    <!-- Progress indicator -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-center space-x-2 text-xs text-gray-500">
                            <div class="w-2 h-2 bg-accent rounded-full animate-pulse"></div>
                            <span class="font-medium">Bước 1: Thông tin khóa học</span>
                            <div class="w-8 h-0.5 bg-gray-200 rounded-full"></div>
                            <span class="opacity-50">Bước 2: Nội dung học</span>
                        </div>
                    </div>
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
