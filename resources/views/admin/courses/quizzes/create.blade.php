@extends('layouts.admin')

@section('title', 'Tạo bài kiểm tra mới')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-white to-neumorphism-light">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center gap-3 text-sm text-primary/60 mb-4 p-4 bg-white rounded-xl shadow-neumorph-sm">
                <a href="{{ route('admin.courses.edit', $course) }}" class="hover:text-accent transition-colors duration-300 font-medium">{{ $course->title }}</a>
                <span class="text-primary/30">/</span>
                <span class="font-medium">{{ $section->title }}</span>
                <span class="text-primary/30">/</span>
                <span class="text-primary font-semibold">Tạo bài kiểm tra mới</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-neumorph">
                <h1 class="text-4xl font-bold text-primary bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                    Tạo bài kiểm tra mới
                </h1>
                <div class="mt-3 w-24 h-1 bg-gradient-to-r from-accent to-danger rounded-full"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('admin.courses.sections.quizzes.store', [$course, $section]) }}" method="POST" class="bg-white rounded-3xl shadow-neumorph overflow-hidden">
                @csrf

                <!-- Form Header -->
                <div class="px-8 py-6 bg-gradient-to-r from-neumorphism-light to-white border-b border-neumorphism-shadow/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl shadow-neumorph-sm flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-accent text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">Thông tin bài kiểm tra</h2>
                    </div>
                    <p class="text-primary/60 mt-2 ml-13">Điền thông tin chi tiết cho bài kiểm tra của bạn</p>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Title -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                            <i class="fas fa-heading text-accent mr-2"></i>
                            Tiêu đề
                            <span class="text-danger ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                class="w-full px-4 py-4 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('title') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                placeholder="Nhập tiêu đề bài kiểm tra"
                                required
                            >
                        </div>
                        @error('title')
                        <p class="mt-2 text-sm text-danger flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                            <i class="fas fa-align-left text-accent mr-2"></i>
                            Mô tả
                        </label>
                        <div class="relative">
                            <textarea
                                name="description"
                                rows="3"
                                class="w-full px-4 py-4 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 resize-none @error('description') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                placeholder="Mô tả ngắn gọn về bài kiểm tra"
                            >{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                        <p class="mt-2 text-sm text-danger flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                            <i class="fas fa-list-ol text-accent mr-2"></i>
                            Hướng dẫn làm bài
                        </label>
                        <div class="relative">
                            <textarea
                                name="instructions"
                                rows="4"
                                class="w-full px-4 py-4 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 resize-none @error('instructions') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                placeholder="Hướng dẫn chi tiết cho học viên trước khi làm bài"
                            >{{ old('instructions') }}</textarea>
                        </div>
                        @error('instructions')
                        <p class="mt-2 text-sm text-danger flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Quiz Settings Grid -->
                    <div class="bg-gradient-to-r from-neumorphism-light to-white p-6 rounded-2xl shadow-neumorph-inset">
                        <h3 class="text-lg font-bold text-primary mb-6 flex items-center">
                            <i class="fas fa-cogs text-accent mr-2"></i>
                            Cài đặt bài kiểm tra
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Time Limit -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                                    <i class="fas fa-clock text-accent mr-2"></i>
                                    Thời gian giới hạn (phút)
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        name="time_limit"
                                        value="{{ old('time_limit') }}"
                                        min="1"
                                        class="w-full px-4 py-3 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('time_limit') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                        placeholder="Để trống nếu không giới hạn thời gian"
                                    >
                                </div>
                                @error('time_limit')
                                <p class="mt-2 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="mt-2 text-xs text-primary/50 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Để trống nếu không muốn giới hạn thời gian
                                </p>
                            </div>

                            <!-- Max Attempts -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                                    <i class="fas fa-redo text-accent mr-2"></i>
                                    Số lần thử tối đa
                                    <span class="text-danger ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        name="max_attempts"
                                        value="{{ old('max_attempts', 1) }}"
                                        min="1"
                                        max="10"
                                        class="w-full px-4 py-3 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('max_attempts') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                        required
                                    >
                                </div>
                                @error('max_attempts')
                                <p class="mt-2 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Passing Score -->
                            <div class="group md:col-span-2">
                                <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                                    <i class="fas fa-medal text-accent mr-2"></i>
                                    Điểm qua (%)
                                    <span class="text-danger ml-1">*</span>
                                </label>
                                <div class="relative max-w-md">
                                    <input
                                        type="number"
                                        name="passing_score"
                                        value="{{ old('passing_score', 70) }}"
                                        min="0"
                                        max="100"
                                        class="w-full px-4 py-3 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('passing_score') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
                                        required
                                    >
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-primary/50">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                                @error('passing_score')
                                <p class="mt-2 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox Options -->
                    <div class="bg-gradient-to-r from-white to-neumorphism-light p-6 rounded-2xl shadow-neumorph">
                        <h3 class="text-lg font-bold text-primary mb-6 flex items-center">
                            <i class="fas fa-sliders-h text-accent mr-2"></i>
                            Tùy chọn bài kiểm tra
                        </h3>

                        <div class="space-y-4">
                            <!-- Show Results -->
                            <div class="flex items-start space-x-4 p-4 bg-white rounded-xl shadow-neumorph-sm">
                                <div class="relative">
                                    <input
                                        type="checkbox"
                                        id="show_results"
                                        name="show_results"
                                        value="1"
                                        {{ old('show_results', true) ? 'checked' : '' }}
                                        class="sr-only"
                                    >
                                    <label for="show_results" class="flex items-center cursor-pointer">
                                        <div class="w-5 h-5 bg-white rounded-md shadow-neumorph-inset border-2 border-transparent relative">
                                            <i class="fas fa-check absolute inset-0 flex items-center justify-center text-accent text-xs opacity-0 transition-opacity duration-200"></i>
                                        </div>
                                    </label>
                                </div>
                                <div class="flex-1">
                                    <label for="show_results" class="text-sm font-semibold text-primary cursor-pointer flex items-center">
                                        <i class="fas fa-eye text-accent mr-2"></i>
                                        Hiển thị kết quả sau khi hoàn thành
                                    </label>
                                    <p class="text-xs text-primary/60 mt-1">Học viên sẽ thấy điểm số và kết quả ngay sau khi nộp bài</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 bg-gradient-to-r from-neumorphism-light to-white border-t border-neumorphism-shadow/20">
                    <div class="flex justify-between items-center">
                        <a
                            href="{{ route('admin.courses.edit', $course) }}"
                            class="neumorph-button px-6 py-3 text-sm font-semibold text-primary rounded-xl flex items-center space-x-2 hover:text-accent transition-colors duration-300"
                        >
                            <i class="fas fa-times"></i>
                            <span>Hủy</span>
                        </a>
                        <button
                            type="submit"
                            class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-accent to-danger rounded-xl shadow-neumorph hover:shadow-neumorph-sm transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-plus-circle"></i>
                            <span>Tạo bài kiểm tra</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Custom checkbox styling */
        input[type="checkbox"]:checked + label > div {
            background: linear-gradient(135deg, #7e0202, #ed292a);
            box-shadow: inset 2px 2px 4px rgba(0,0,0,0.1);
        }

        input[type="checkbox"]:checked + label > div > i {
            opacity: 1;
            color: white;
        }

        /* Input focus effects */
        .group:focus-within label {
            color: #7e0202;
        }

        /* Smooth animations */
        * {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
    </style>
@endsection
