@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài kiểm tra')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.courses.edit', $course) }}" class="hover:text-blue-600">{{ $course->title }}</a>
                <span>/</span>
                <span>{{ $section->title }}</span>
                <span>/</span>
                <span class="text-gray-800">{{ $quiz->title }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Chỉnh sửa bài kiểm tra</h1>
        </div>

        <div class="max-w-6xl mx-auto space-y-8">
            <!-- Quiz Information Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <form action="{{ route('admin.courses.sections.quizzes.update', [$course, $section, $quiz]) }}" method="POST" class="bg-white rounded-3xl shadow-neumorph overflow-hidden">
                    @csrf
                    @method('PUT')

                    <!-- Form Header -->
                    <div class="px-8 py-6 bg-gradient-to-r from-neumorphism-light to-white border-b border-neumorphism-shadow/20">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-neumorph-sm flex items-center justify-center">
                                <i class="fas fa-edit text-accent text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-primary">Chỉnh sửa bài kiểm tra</h2>
                        </div>
                        <p class="text-primary/60 mt-2 ml-13">Cập nhật thông tin chi tiết cho bài kiểm tra</p>
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
                                    value="{{ old('title', $quiz->title) }}"
                                    class="w-full px-4 py-4 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('title') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
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
                >{{ old('description', $quiz->description) }}</textarea>
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
                >{{ old('instructions', $quiz->instructions) }}</textarea>
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
                                            value="{{ old('time_limit', $quiz->time_limit) }}"
                                            min="1"
                                            class="w-full px-4 py-3 bg-white rounded-xl shadow-neumorph-inset border-0 focus:outline-none focus:shadow-neumorph transition-all duration-300 text-primary placeholder-primary/40 @error('time_limit') shadow-[inset_4px_4px_8px_#ffebee,inset_-4px_-4px_8px_#ffffff] @enderror"
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
                                            value="{{ old('max_attempts', $quiz->max_attempts) }}"
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
                                            value="{{ old('passing_score', $quiz->passing_score) }}"
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
                                <div class="flex items-start space-x-3">
                                    <input
                                        type="checkbox"
                                        id="show_results"
                                        name="show_results"
                                        value="1"
                                        {{ old('show_results', $quiz->show_results) ? 'checked' : '' }}
                                        class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    >
                                    <div>
                                        <label for="show_results" class="text-sm font-medium text-gray-700">
                                            Hiển thị kết quả sau khi hoàn thành
                                        </label>
                                        <p class="text-xs text-gray-500">Học viên sẽ thấy điểm số và kết quả ngay sau khi nộp bài</p>
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
                            Quay lại
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-[#1c1c1c] border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Cập nhật bài kiểm tra
                        </button>
                    </div>
                </form>
            </div>

            <!-- Questions Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Danh sách câu hỏi</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Tổng cộng: {{ $quiz->questions->count() }} câu hỏi
                            @if($quiz->questions->count() > 0)
                                <span class="ml-2 text-blue-600">• Kéo thả để sắp xếp thứ tự</span>
                            @endif
                        </p>
                    </div>
                    <a
                        href="{{ route('admin.courses.sections.quizzes.questions.create', [$course, $section, $quiz]) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Thêm câu hỏi
                    </a>
                </div>

                <!-- Sortable Questions List -->
                <div id="questions-list" class="divide-y divide-gray-200">
                    @forelse ($quiz->questions as $index => $question)
                        <div class="question-item p-6 hover:bg-gray-50 transition-colors cursor-move" data-question-id="{{ $question->id }}">
                            <div class="flex items-start">
                                <!-- Drag Handle -->
                                <div class="flex-shrink-0 mr-4 mt-2">
                                    <svg class="drag-handle w-5 h-5 text-gray-400 cursor-move" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM7 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM7 14a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM17 2a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM17 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM17 14a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"></path>
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0 pr-4">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="question-number inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                                {{ $question->question }}
                                            </h3>
                                            <div class="flex items-center space-x-4 mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($question->type === 'single_choice') bg-blue-100 text-blue-800
                                                    @elseif($question->type === 'multiple_choice') bg-green-100 text-green-800
                                                    @elseif($question->type === 'fill_blank') bg-purple-100 text-purple-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    @switch($question->type)
                                                        @case('single_choice')
                                                            Trắc nghiệm 1 đáp án
                                                            @break
                                                        @case('multiple_choice')
                                                            Trắc nghiệm nhiều đáp án
                                                            @break
                                                        @case('fill_blank')
                                                            Điền vào chỗ trống
                                                            @break
                                                        @default
                                                            {{ ucfirst($question->type) }}
                                                    @endswitch
                                                </span>
                                                @if($question->points)
                                                    <span class="text-sm text-gray-500">{{ $question->points }} điểm</span>
                                                @endif
                                                @if($question->is_required)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        Bắt buộc
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($question->explanation)
                                        <div class="mt-2 ml-11">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Giải thích:</span>
                                                {{ Str::limit($question->explanation, 100) }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Show question options preview -->
                                    @if($question->options->count() > 0)
                                        <div class="mt-3 ml-11">
                                            <p class="text-xs text-gray-500 mb-1">Các lựa chọn:</p>
                                            <div class="space-y-1">
                                                @foreach($question->options->take(3) as $option)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        @if($question->type === 'single_choice')
                                                            <span class="w-4 h-4 mr-2 rounded-full border-2 {{ $option->is_correct ? 'bg-green-500 border-green-500' : 'border-gray-300' }}"></span>
                                                        @else
                                                            <span class="w-4 h-4 mr-2 rounded border-2 {{ $option->is_correct ? 'bg-green-500 border-green-500' : 'border-gray-300' }}"></span>
                                                        @endif
                                                        <span class="{{ $option->is_correct ? 'text-green-700 font-medium' : '' }}">
                                                            {{ Str::limit($option->option_text, 50) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if($question->options->count() > 3)
                                                    <p class="text-xs text-gray-400">... và {{ $question->options->count() - 3 }} lựa chọn khác</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <a
                                        href="{{ route('admin.courses.sections.quizzes.questions.edit', [$course, $section, $quiz, $question]) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 border border-transparent rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        title="Chỉnh sửa câu hỏi"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Sửa
                                    </a>
                                    <form
                                        action="{{ route('admin.courses.sections.quizzes.questions.destroy', [$course, $section, $quiz, $question]) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này? Hành động này không thể hoàn tác.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            title="Xóa câu hỏi"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Chưa có câu hỏi nào</h3>
                            <p class="mt-1 text-sm text-gray-500">Hãy bắt đầu bằng cách thêm câu hỏi đầu tiên cho bài kiểm tra này.</p>
                            <div class="mt-6">
                                <a
                                    href="{{ route('admin.courses.sections.quizzes.questions.create', [$course, $section, $quiz]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Thêm câu hỏi đầu tiên
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($quiz->questions->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>
                                Tổng điểm: {{ $quiz->questions->sum('points') ?: 'Chưa thiết lập' }}
                            </span>
                            <span>
                                Câu hỏi bắt buộc: {{ $quiz->questions->where('is_required', true)->count() }}/{{ $quiz->questions->count() }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Đang cập nhật thứ tự...</span>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-message">
            {{ session('error') }}
        </div>
    @endif

    <!-- Include SortableJS from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionsList = document.getElementById('questions-list');
            const loadingOverlay = document.getElementById('loading-overlay');

            if (questionsList && questionsList.children.length > 0) {
                // Initialize SortableJS
                const sortable = Sortable.create(questionsList, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',

                    onStart: function(evt) {
                        // Add visual feedback when dragging starts
                        evt.item.style.opacity = '0.5';
                    },

                    onEnd: function(evt) {
                        // Reset opacity
                        evt.item.style.opacity = '1';

                        // Get new order
                        const questionIds = Array.from(questionsList.children).map(item =>
                            item.getAttribute('data-question-id')
                        );

                        // Update question numbers
                        updateQuestionNumbers();

                        // Send AJAX request to update server
                        updateQuestionOrder(questionIds);
                    }
                });

                // Add custom CSS for drag states
                const style = document.createElement('style');
                style.textContent = `
                    .sortable-ghost {
                        opacity: 0.4;
                        background-color: #f3f4f6;
                    }
                    .sortable-chosen {
                        cursor: grabbing;
                    }
                    .sortable-drag {
                        opacity: 0.8;
                        transform: rotate(5deg);
                    }
                    .question-item:hover .drag-handle {
                        color: #3b82f6;
                    }
                `;
                document.head.appendChild(style);
            }

            function updateQuestionNumbers() {
                const questionNumbers = document.querySelectorAll('.question-number');
                questionNumbers.forEach((numberEl, index) => {
                    numberEl.textContent = index + 1;
                });
            }

            function updateQuestionOrder(questionIds) {
                // Show loading overlay
                loadingOverlay.classList.remove('hidden');

                fetch(`{{ route('admin.courses.sections.quizzes.sort-questions', [$course, $section, $quiz]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        questions: questionIds
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading overlay
                        loadingOverlay.classList.add('hidden');

                        if (data.success) {
                            showMessage(data.message, 'success');
                        } else {
                            showMessage(data.message || 'Có lỗi xảy ra khi cập nhật thứ tự câu hỏi.', 'error');
                            // Reload page to reset order on error
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        // Hide loading overlay
                        loadingOverlay.classList.add('hidden');

                        console.error('Error:', error);
                        showMessage('Có lỗi xảy ra khi cập nhật thứ tự câu hỏi.', 'error');

                        // Reload page to reset order on error
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
            }

            function showMessage(message, type) {
                // Remove existing messages
                const existingMessages = document.querySelectorAll('.message-toast');
                existingMessages.forEach(msg => msg.remove());

                // Create new message
                const messageDiv = document.createElement('div');
                messageDiv.className = `message-toast fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white`;
                messageDiv.textContent = message;

                document.body.appendChild(messageDiv);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    messageDiv.style.opacity = '0';
                    setTimeout(() => messageDiv.remove(), 300);
                }, 3000);
            }

            // Auto-hide session messages
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            [successMessage, errorMessage].forEach(message => {
                if (message) {
                    setTimeout(() => {
                        message.style.opacity = '0';
                        setTimeout(() => message.remove(), 300);
                    }, 3000);
                }
            });
        });
    </script>
@endsection
