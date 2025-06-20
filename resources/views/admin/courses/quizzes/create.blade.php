@extends('layouts.app')

@section('title', 'Tạo bài kiểm tra mới')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.courses.edit', $course) }}" class="hover:text-blue-600">{{ $course->title }}</a>
                <span>/</span>
                <span>{{ $section->title }}</span>
                <span>/</span>
                <span class="text-gray-800">Tạo bài kiểm tra mới</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Tạo bài kiểm tra mới</h1>
        </div>

        <!-- Form -->
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('admin.courses.sections.quizzes.store', [$course, $section]) }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
                @csrf

                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Thông tin bài kiểm tra</h2>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tiêu đề <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                            placeholder="Nhập tiêu đề bài kiểm tra"
                            required
                        >
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                        <textarea
                            name="description"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                            placeholder="Mô tả ngắn gọn về bài kiểm tra"
                        >{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hướng dẫn làm bài</label>
                        <textarea
                            name="instructions"
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('instructions') border-red-500 @enderror"
                            placeholder="Hướng dẫn chi tiết cho học viên trước khi làm bài"
                        >{{ old('instructions') }}</textarea>
                        @error('instructions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quiz Settings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Time Limit -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Thời gian giới hạn (phút)
                            </label>
                            <input
                                type="number"
                                name="time_limit"
                                value="{{ old('time_limit') }}"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('time_limit') border-red-500 @enderror"
                                placeholder="Để trống nếu không giới hạn thời gian"
                            >
                            @error('time_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Để trống nếu không muốn giới hạn thời gian</p>
                        </div>

                        <!-- Max Attempts -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Số lần thử tối đa <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="max_attempts"
                                value="{{ old('max_attempts', 1) }}"
                                min="1"
                                max="10"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_attempts') border-red-500 @enderror"
                                required
                            >
                            @error('max_attempts')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Passing Score -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Điểm qua (%) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="passing_score"
                                value="{{ old('passing_score', 70) }}"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passing_score') border-red-500 @enderror"
                                required
                            >
                            @error('passing_score')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Checkbox Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800">Tùy chọn bài kiểm tra</h3>

                        <div class="space-y-3">
                            <!-- Show Results -->
                            <div class="flex items-start space-x-3">
                                <input
                                    type="checkbox"
                                    id="show_results"
                                    name="show_results"
                                    value="1"
                                    {{ old('show_results', true) ? 'checked' : '' }}
                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                >
                                <div>
                                    <label for="show_results" class="text-sm font-medium text-gray-700">
                                        Hiển thị kết quả sau khi hoàn thành
                                    </label>
                                    <p class="text-xs text-gray-500">Học viên sẽ thấy điểm số và kết quả ngay sau khi nộp bài</p>
                                </div>
                            </div>

                            <!-- Shuffle Questions -->
                            <div class="flex items-start space-x-3">
                                <input
                                    type="checkbox"
                                    id="shuffle_questions"
                                    name="shuffle_questions"
                                    value="1"
                                    {{ old('shuffle_questions') ? 'checked' : '' }}
                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                >
                                <div>
                                    <label for="shuffle_questions" class="text-sm font-medium text-gray-700">
                                        Xáo trộn câu hỏi
                                    </label>
                                    <p class="text-xs text-gray-500">Thứ tự câu hỏi sẽ được xáo trộn cho mỗi lần làm bài</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-between items-center">
                    <a
                        href="{{ route('admin.courses.edit', $course) }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Hủy
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Tạo bài kiểm tra
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
