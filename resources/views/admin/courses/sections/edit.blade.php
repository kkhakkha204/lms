@extends('layouts.admin')

@section('title', 'Chỉnh sửa mục')

@section('content')
    <div class="min-h-screen bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-3 text-sm mb-8">
                    <a href="{{ route('admin.courses.index') }}"
                       class="flex items-center px-4 py-2 text-gray-600 hover:text-accent transition-all duration-300 rounded-xl shadow-neumorph-sm hover:shadow-neumorph neumorph-button">
                        Khóa học
                    </a>
                    <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                    <a href="{{ route('admin.courses.edit', $course) }}"
                       class="flex items-center px-4 py-2 text-gray-600 hover:text-accent transition-all duration-300 rounded-xl shadow-neumorph-sm hover:shadow-neumorph neumorph-button">
                        {{ $course->title }}
                    </a>
                    <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                    <span class="px-4 py-2 text-primary font-medium bg-white rounded-xl shadow-neumorph-inset">
                        Chỉnh sửa mục
                    </span>
                </nav>

                <!-- Page Title -->
                <div class="flex items-center justify-between">
                    <div class="space-y-4">
                        <h1 class="text-4xl font-bold text-primary tracking-tight">Chỉnh sửa mục</h1>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            Cập nhật thông tin cho mục
                            <span class="font-semibold text-accent">"{{ $section->title }}"</span>
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Sort Order Badge -->
                        <div class="flex items-center px-6 py-3 bg-white rounded-2xl shadow-neumorph">
                            <i class="fas fa-sort-numeric-up text-accent mr-3 text-lg"></i>
                            <span class="text-primary font-bold text-lg">Thứ tự: {{ $section->sort_order }}</span>
                        </div>

                        <a href="{{ route('admin.courses.edit', $course) }}"
                           class="group inline-flex items-center px-8 py-4 text-gray-700 font-medium transition-all duration-300 rounded-2xl shadow-neumorph hover:shadow-neumorph-inset neumorph-button">
                            <i class="fas fa-arrow-left mr-3 text-lg group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-3xl shadow-neumorph overflow-hidden">
                <!-- Card Header -->
                <div class="relative px-8 py-8 bg-gradient-to-br from-accent via-danger to-accent">
                    <div class="absolute inset-0 bg-black bg-opacity-10 rounded-t-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                                <i class="fas fa-edit text-2xl text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Thông tin mục</h2>
                                <p class="text-white text-opacity-90 mt-1 text-lg">
                                    Thay đổi thứ tự bằng cách kéo thả trong trang quản lý khóa học
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('admin.courses.sections.update', [$course, $section]) }}" method="POST" class="p-8 space-y-10">
                    @csrf
                    @method('PUT')

                    <!-- Title Field -->
                    <div class="space-y-4">
                        <label for="title" class="flex items-center text-lg font-bold text-primary">
                            <i class="fas fa-heading text-accent mr-3"></i>
                            Tiêu đề mục
                            <span class="text-danger ml-2">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $section->title) }}"
                                   placeholder="Nhập tiêu đề cho mục..."
                                   class="w-full px-6 py-5 text-lg bg-white border-0 rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium @error('title') ring-2 ring-danger @enderror">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6">
                                <i class="fas fa-edit text-gray-400"></i>
                            </div>
                        </div>
                        @error('title')
                        <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                            <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                            <span class="text-danger font-medium">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="space-y-4">
                        <label for="description" class="flex items-center text-lg font-bold text-primary">
                            <i class="fas fa-align-left text-accent mr-3"></i>
                            Mô tả
                        </label>
                        <div class="relative">
                            <textarea id="description"
                                      name="description"
                                      rows="6"
                                      placeholder="Nhập mô tả chi tiết cho mục (tùy chọn)..."
                                      class="w-full px-6 py-5 text-lg bg-white border-0 rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium resize-none @error('description') ring-2 ring-danger @enderror">{{ old('description', $section->description) }}</textarea>
                            <div class="absolute top-5 right-0 flex items-center pr-6">
                                <i class="fas fa-file-alt text-gray-400"></i>
                            </div>
                        </div>
                        @error('description')
                        <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                            <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                            <span class="text-danger font-medium">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- Current Order Info -->
                    <div class="relative p-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-neumorph-inset border-l-4 border-primary">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle text-primary text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xl font-bold text-primary mb-3 flex items-center">
                                    <i class="fas fa-sort-numeric-up text-accent mr-2"></i>
                                    Thứ tự hiện tại
                                </h4>
                                <p class="text-gray-700 leading-relaxed text-lg">
                                    Mục này đang ở vị trí thứ
                                    <span class="inline-flex items-center px-3 py-1 bg-accent text-white rounded-lg font-bold mx-1">
                                        {{ $section->sort_order }}
                                    </span>
                                    . Để thay đổi thứ tự, hãy sử dụng tính năng kéo thả trong trang quản lý khóa học.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-6 pt-8 border-t border-gray-100">
                        <a href="{{ route('admin.courses.edit', $course) }}"
                           class="group inline-flex items-center px-10 py-5 text-lg font-bold text-gray-700 transition-all duration-300 rounded-2xl shadow-neumorph hover:shadow-neumorph-inset neumorph-button">
                            <i class="fas fa-times mr-3 group-hover:rotate-90 transition-transform duration-300"></i>
                            Hủy
                        </a>
                        <button type="submit"
                                class="group inline-flex items-center px-12 py-5 text-lg font-bold text-white bg-gradient-to-r from-accent to-danger rounded-2xl shadow-neumorph hover:shadow-neumorph-inset transition-all duration-300 transform hover:scale-105 hover:from-danger hover:to-accent">
                            <i class="fas fa-check mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
