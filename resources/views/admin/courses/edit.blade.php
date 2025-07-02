@extends('layouts.admin')

@section('title', 'Chỉnh sửa khóa học: ' . $course->title)

@section('content')
    <div class="container mx-auto p-4 max-w-7xl">
        <!-- Header with Course Status -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-10 gap-6">
            <div class="relative">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-primary via-accent to-danger bg-clip-text text-transparent mb-3 tracking-tight">
                    Chỉnh sửa khóa học
                </h1>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="px-4 py-2 rounded-xl text-sm font-semibold shadow-neumorph-sm border
                    {{ $course->status === 'published' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-yellow-50 text-yellow-700 border-yellow-100' }}">
                    {{ $course->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                </span>
                    </div>

                    @if($course->enrolled_count > 0)
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white rounded-xl shadow-neumorph-sm border border-gray-100">
                            <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ $course->enrolled_count }} học viên</span>
                        </div>
                    @endif

                    @if($course->rating > 0)
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white rounded-xl shadow-neumorph-sm border border-gray-100">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ number_format($course->rating, 1) }} ({{ $course->reviews_count }})</span>
                        </div>
                    @endif
                </div>
                <div class="mt-3 w-20 h-0.5 bg-gradient-to-r from-accent to-danger rounded-full"></div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.courses.index') }}"
                   class="group neumorph-button px-6 py-3 text-primary font-semibold rounded-2xl hover:text-accent transition-all duration-500 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Quay lại</span>
                </a>

                <form action="{{ route('admin.courses.toggle-publish', $course) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="group relative px-6 py-3 rounded-2xl font-semibold transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden
                        {{ $course->status === 'published'
                            ? 'bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white'
                            : 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white' }}">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="{{ $course->status === 'published' ? 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21' : 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' }}"/>
                            </svg>
                            <span>{{ $course->status === 'published' ? 'Chuyển về nháp' : 'Xuất bản' }}</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 via-transparent to-transparent -skew-x-12 transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-8 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl"></div>
                <div class="relative bg-white border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-neumorph-sm flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mr-4">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-pink-500/10 rounded-2xl"></div>
                <div class="relative bg-white border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-neumorph-sm flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full mr-4">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Course Builder Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Tab Navigation -->
            <div class="relative bg-white px-8 py-6 border-b border-gray-100/50">
                <div class="absolute inset-0 "></div>
                <div class="relative flex flex-wrap gap-2">
                    <button type="button" onclick="showTab('information')"
                            class="tab-button group flex items-center space-x-3 px-6 py-4 rounded-2xl font-semibold transition-all duration-500 active"
                            data-tab="information">
                        <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-accent/20 to-danger/20 group-hover:from-accent/30 group-hover:to-danger/30 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="tracking-wide">Thông tin khóa học</span>
                    </button>

                    <button type="button" onclick="showTab('curriculum')"
                            class="tab-button group flex items-center space-x-3 px-6 py-4 rounded-2xl font-semibold transition-all duration-500"
                            data-tab="curriculum">
                        <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-accent/20 to-danger/20 group-hover:from-accent/30 group-hover:to-danger/30 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="tracking-wide">Chương trình học</span>
                    </button>

                    <button type="button" onclick="showTab('settings')"
                            class="tab-button group flex items-center space-x-3 px-6 py-4 rounded-2xl font-semibold transition-all duration-500"
                            data-tab="settings">
                        <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-accent/20 to-danger/20 group-hover:from-accent/30 group-hover:to-danger/30 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="tracking-wide">Cài đặt nâng cao</span>
                    </button>
                </div>
            </div>

            <!-- Information Tab -->
            <div id="information-tab" class="tab-content">
                <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-8 space-y-10">
                        <!-- Thumbnail Upload Section -->
                        <div class="relative">
                            <div class="absolute -top-3 -left-3 w-6 h-6 bg-gradient-to-br from-accent to-danger rounded-full opacity-20"></div>
                            <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                    <h3 class="text-xl font-bold text-primary">Hình ảnh đại diện</h3>
                                </div>

                                @if($course->thumbnail)
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <!-- Current Image -->
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700 mb-3">Hình ảnh hiện tại:</p>
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 overflow-hidden shadow-neumorph-sm">
                                                <img src="{{ Storage::url($course->thumbnail) }}"
                                                     alt="{{ $course->title }}"
                                                     class="w-full h-full object-contain">
                                            </div>
                                        </div>

                                        <!-- Upload New -->
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700 mb-3">Thay đổi hình ảnh:</p>
                                            <div class="relative bg-gray-50/50 rounded-2xl p-6 border-2 border-dashed border-gray-200 hover:border-accent/30 transition-all duration-500 group">
                                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                       onchange="previewImage(this)">
                                                <div class="text-center">
                                                    <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-accent/60 transition-colors duration-300">
                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 48 48" class="w-full h-full">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="thumbnail" class="cursor-pointer">
                                            <span class="block text-sm font-semibold text-primary group-hover:text-accent transition-colors">
                                                Chọn hình ảnh mới
                                            </span>
                                                            <span class="mt-1 block text-xs text-gray-500">
                                                PNG, JPG, WEBP tối đa 2MB
                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview New Image -->
                                            <div id="image-preview" class="hidden mt-4">
                                                <p class="text-sm font-semibold text-gray-700 mb-3">Xem trước hình mới:</p>
                                                <div class="relative">
                                                    <div class="w-full h-36 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 overflow-hidden shadow-neumorph-sm">
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
                                @else
                                    <!-- No current thumbnail -->
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
                                <span class="block text-lg font-semibold text-primary group-hover:text-accent transition-colors">
                                    Tải lên hình ảnh đại diện
                                </span>
                                                <span class="mt-2 block text-sm text-gray-500">
                                    PNG, JPG, WEBP tối đa 2MB
                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="image-preview" class="hidden mt-6">
                                        <p class="text-sm font-semibold text-gray-700 mb-3">Xem trước:</p>
                                        <div class="relative">
                                            <div class="w-64 h-36 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 overflow-hidden shadow-neumorph-sm">
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
                                @endif

                                @error('thumbnail')
                                <p class="mt-3 text-sm text-danger font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
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
                                            <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}"
                                                   class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all duration-300 @error('title') border-danger @enderror"
                                                   placeholder="Nhập tiêu đề khóa học">
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
                                                <input type="text" name="slug" id="slug" value="{{ old('slug', $course->slug) }}"
                                                       class="flex-1 px-4 py-3 bg-gray-50/50 border-0 focus:ring-2 focus:ring-accent/20 @error('slug') border-danger @enderror">
                                            </div>
                                            @error('slug')
                                            <p class="mt-2 text-sm text-danger font-medium">{{ $message }}</p>
                                            @enderror
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
                                                            {{ $category->id == $course->category_id ? 'selected' : '' }}>
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
                                                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Sơ cấp</option>
                                                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
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
                                                    <option value="vi" {{ old('language', $course->language) == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                                    <option value="en" {{ old('language', $course->language) == 'en' ? 'selected' : '' }}>English</option>
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
                                                       value="{{ old('duration_hours', $course->duration_hours) }}" min="1" max="1000"
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
                                                      onkeyup="updateCharCount('short_description', 500)">{{ old('short_description', $course->short_description) }}</textarea>
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
                                                      onkeyup="updateCharCount('description', null, 50)">{{ old('description', $course->description) }}</textarea>
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
                                                   {{ old('is_free', $course->is_free) ? 'checked' : '' }}
                                                   onchange="togglePriceFields()"
                                                   class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent/20">
                                            <span class="ml-3 text-sm font-semibold text-primary">Khóa học miễn phí</span>
                                        </div>

                                        <!-- Price Fields -->
                                        <div class="space-y-4">
                                            <div id="price-field">
                                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">
                                                    Giá gốc (VND) <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="price" id="price"
                                                       value="{{ old('price', $course->price) }}"
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
                                                       value="{{ old('discount_price', $course->discount_price) }}"
                                                       min="0" step="1000"
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
                                                <!-- Will be populated by JavaScript -->
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
                                                   value="{{ old('preview_video', $course->preview_video) }}"
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
                                            <input type="text" name="tags" id="tags"
                                                   value="{{ old('tags', is_array($course->tags) ? implode(', ', $course->tags) : '') }}"
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
                                                       value="{{ old('meta_title', $course->meta_title) }}" maxlength="60"
                                                       class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent transition-all @error('meta_title') border-danger @enderror"
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
                                                          onkeyup="updateCharCount('meta_description', 160)">{{ old('meta_description', $course->meta_description) }}</textarea>
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
                                    <div class="w-1.5 h-6 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                    <div class="text-sm text-gray-600 font-medium">
                                        <span class="inline-flex items-center justify-center w-4 h-4 bg-danger text-white text-xs rounded-full mr-2">*</span>
                                        Trường bắt buộc
                                    </div>
                                </div>

                                <div class="flex space-x-4 w-full sm:w-auto">
                                    <a href="{{ route('admin.courses.index') }}"
                                       class="group flex-1 sm:flex-none relative neumorph-button px-8 py-4 text-gray-700 font-semibold rounded-2xl hover:text-primary transition-all duration-500 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-gray-100/50 to-gray-200/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="relative flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            <span>Hủy</span>
                                        </div>
                                    </a>

                                    <button type="submit"
                                            class="group flex-1 sm:flex-none relative bg-gradient-to-r from-accent to-danger hover:from-accent/90 hover:to-danger/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden">
                                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="relative flex items-center justify-center space-x-3">
                                            <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <span class="tracking-wide">Cập nhật khóa học</span>
                                        </div>
                                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 via-transparent to-transparent -skew-x-12 transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                    </button>
                                </div>
                            </div>

                            <!-- Progress indicator -->
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center justify-center space-x-2 text-xs text-gray-500">
                                    <div class="w-2 h-2 bg-accent rounded-full animate-pulse"></div>
                                    <span class="font-medium">Chỉnh sửa thông tin khóa học</span>
                                </div>
                            </div>
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
            <div id="settings-tab" class="tab-content hidden">
                <div class="p-8 h-full overflow-y-auto">
                    <div class="max-w-7xl mx-auto space-y-8">
                        <!-- Header -->
                        <div class="relative">
                            <div class="absolute -top-2 -left-2 w-4 h-4 bg-gradient-to-br from-accent to-danger rounded-full opacity-60 animate-pulse"></div>
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-8 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                <h3 class="text-2xl font-bold text-primary flex items-center">
                                    <i class="fas fa-chart-bar mr-3"></i>Thống kê và cài đặt
                                </h3>
                            </div>
                            <div class="mt-2 w-24 h-0.5 bg-gradient-to-r from-accent to-danger rounded-full ml-5"></div>
                        </div>

                        <!-- Main Grid Layout -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                            <!-- Left Column (2/3) -->
                            <div class="xl:col-span-2 space-y-8">
                                <!-- Course Statistics -->
                                <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-2 h-6 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                        <h4 class="text-xl font-bold text-primary">Thống kê tổng quan</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="relative group">
                                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-2xl"></div>
                                            <div class="relative bg-white rounded-2xl shadow-neumorph-sm border border-green-200/50 p-6 group-hover:shadow-neumorph transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl mr-4">
                                                        <i class="fas fa-users text-2xl text-green-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-green-600 mb-1">Học viên đăng ký</div>
                                                        <div class="text-3xl font-bold text-green-700">{{ number_format($course->enrolled_count) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative group">
                                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-indigo-500/10 rounded-2xl"></div>
                                            <div class="relative bg-white rounded-2xl shadow-neumorph-sm border border-purple-200/50 p-6 group-hover:shadow-neumorph transition-all duration-300">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl mr-4">
                                                        <i class="fas fa-list text-2xl text-purple-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-purple-600 mb-1">Tổng chương</div>
                                                        <div class="text-3xl font-bold text-purple-700">{{ $course->sections()->count() }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Course Content Summary -->
                                <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-2 h-6 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                        <h4 class="text-xl font-bold text-primary flex items-center">
                                            <i class="fas fa-list-ul mr-3"></i>Tóm tắt nội dung
                                        </h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex items-center space-x-3 p-4 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl border border-blue-200/50">
                                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                                                <i class="fas fa-folder text-blue-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs text-blue-600 font-medium">Chương</div>
                                                <div class="text-lg font-bold text-blue-700">{{ $course->sections()->count() }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3 p-4 bg-gradient-to-r from-green-50 to-green-100/50 rounded-xl border border-green-200/50">
                                            <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg">
                                                <i class="fas fa-play-circle text-green-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs text-green-600 font-medium">Bài học</div>
                                                <div class="text-lg font-bold text-green-700">{{ $course->lessons()->count() }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3 p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-xl border border-purple-200/50">
                                            <div class="flex items-center justify-center w-10 h-10 bg-purple-100 rounded-lg">
                                                <i class="fas fa-question-circle text-purple-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs text-purple-600 font-medium">Quiz</div>
                                                <div class="text-lg font-bold text-purple-700">{{ $course->quizzes()->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Publishing Information -->
                                <div class="bg-white rounded-3xl shadow-neumorph p-8 border border-gray-100/50">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-2 h-6 bg-gradient-to-b from-accent to-danger rounded-full"></div>
                                        <h4 class="text-xl font-bold text-primary flex items-center">
                                            <i class="fas fa-info-circle mr-3"></i>Thông tin xuất bản
                                        </h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-200/50">
                                                <span class="text-sm font-medium text-gray-600">Trạng thái:</span>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $course->status === 'published' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                        {{ $course->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                                    </span>
                                            </div>

                                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-200/50">
                                                <span class="text-sm font-medium text-gray-600">Ngày tạo:</span>
                                                <span class="text-sm font-semibold text-gray-700">{{ $course->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-200/50">
                                                <span class="text-sm font-medium text-gray-600">Cập nhật cuối:</span>
                                                <span class="text-sm font-semibold text-gray-700">{{ $course->updated_at->format('d/m/Y H:i') }}</span>
                                            </div>

                                            @if($course->published_at)
                                                <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-200/50">
                                                    <span class="text-sm font-medium text-gray-600">Ngày xuất bản:</span>
                                                    <span class="text-sm font-semibold text-gray-700">{{ $course->published_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column (1/3) -->
                            <div class="space-y-8">
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
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-orange-500/10 rounded-3xl"></div>
                                        <div class="relative bg-white border border-yellow-200/50 rounded-3xl shadow-neumorph p-8">
                                            <div class="flex items-center space-x-3 mb-4">
                                                <div class="flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-xl">
                                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                                </div>
                                                <h4 class="text-lg font-bold text-yellow-800">Yêu cầu xuất bản</h4>
                                            </div>
                                            <p class="text-sm text-yellow-700 mb-4">Khóa học cần hoàn thiện:</p>
                                            <ul class="space-y-3">
                                                @foreach($publishErrors as $error)
                                                    <li class="flex items-start space-x-3">
                                                        <div class="flex items-center justify-center w-5 h-5 bg-red-100 rounded-full mt-0.5">
                                                            <i class="fas fa-times text-red-500 text-xs"></i>
                                                        </div>
                                                        <span class="text-sm text-yellow-800">{{ $error }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-3xl"></div>
                                        <div class="relative bg-white border border-green-200/50 rounded-3xl shadow-neumorph p-8">
                                            <div class="text-center">
                                                <div class="mx-auto w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-4">
                                                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                                                </div>
                                                <h4 class="text-lg font-bold text-green-800 mb-2">Sẵn sàng xuất bản</h4>
                                                <p class="text-sm text-green-700">Khóa học đã đáp ứng tất cả yêu cầu và có thể xuất bản.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Danger Zone / Protection -->
                                @if($course->enrolled_count == 0)
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-pink-500/10 rounded-3xl"></div>
                                        <div class="relative bg-white border border-red-200/50 rounded-3xl shadow-neumorph p-8">
                                            <div class="flex items-center space-x-3 mb-4">
                                                <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-xl">
                                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                                </div>
                                                <h4 class="text-lg font-bold text-red-800">Vùng nguy hiểm</h4>
                                            </div>
                                            <p class="text-sm text-red-700 mb-6">
                                                Xóa khóa học sẽ không thể khôi phục. Hành động này sẽ xóa tất cả dữ liệu liên quan.
                                            </p>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa khóa học này không? Hành động này không thể hoàn tác!')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="group relative w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden">
                                                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                    <div class="relative flex items-center justify-center space-x-2">
                                                        <i class="fas fa-trash group-hover:scale-110 transition-transform duration-300"></i>
                                                        <span>Xóa khóa học</span>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-gray-500/10 to-slate-500/10 rounded-3xl"></div>
                                        <div class="relative bg-white border border-gray-200/50 rounded-3xl shadow-neumorph p-8">
                                            <div class="text-center">
                                                <div class="mx-auto w-16 h-16 bg-gradient-to-br from-gray-100 to-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                                    <i class="fas fa-shield-alt text-2xl text-gray-600"></i>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-800 mb-2">Được bảo vệ</h4>
                                                <p class="text-sm text-gray-700">
                                                    Khóa học đã có <strong>{{ $course->enrolled_count }}</strong> học viên đăng ký nên không thể xóa.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="${lessonCreateUrl}"
                           class="block p-3 border-2 border-dashed border-green-300 rounded-lg hover:border-green-400 hover:bg-green-50 transition-all text-center group">
                            <i class="fas fa-plus-circle text-2xl text-green-500 mb-3 group-hover:text-green-600"></i>
                            <div class="font-medium text-green-700 mb-1">Thêm bài học mới</div>
                        </a>

                        <a href="${quizCreateUrl}"
                           class="block p-3 border-2 border-dashed border-purple-300 rounded-lg hover:border-purple-400 hover:bg-purple-50 transition-all text-center group">
                            <i class="fas fa-question-circle text-2xl text-purple-500 mb-3 group-hover:text-purple-600"></i>
                            <div class="font-medium text-purple-700 mb-1">Thêm quiz mới</div>
                        </a>

                        <a href="${sectionEditUrl}"
                           class="block p-3 border-2 border-dashed border-blue-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all text-center group">
                            <i class="fas fa-edit text-2xl text-blue-500 mb-3 group-hover:text-blue-600"></i>
                            <div class="font-medium text-blue-700 mb-1">Chỉnh sửa chương</div>
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
            @apply text-gray-600 hover:text-primary bg-gray-50/50 shadow-neumorph-sm border border-gray-200/50 hover:shadow-neumorph hover:border-accent/20;
        }

        .tab-button.active {
            @apply text-white shadow-lg border-0 transform scale-105;
            background: linear-gradient(135deg, #7e0202, #ed292a) !important;
        }

        .tab-button.active .group div {
            @apply from-white/20 to-white/20;
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
