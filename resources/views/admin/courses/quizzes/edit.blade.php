@extends('layouts.app')

@section('title', 'Chỉnh sửa bài kiểm tra')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Chỉnh sửa bài kiểm tra: {{ $quiz->title }}</h1>
        <form action="{{ route('admin.courses.sections.quizzes.update', [$course, $section, $quiz]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title', $quiz->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $quiz->description) }}</textarea>
                @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hướng dẫn</label>
                <textarea name="instructions" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('instructions', $quiz->instructions) }}</textarea>
                @error('instructions')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thời gian giới hạn (phút)</label>
                <input type="number" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('time_limit')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Số lần thử tối đa</label>
                <input type="number" name="max_attempts" value="{{ old('max_attempts', $quiz->max_attempts) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('max_attempts')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Điểm qua (%)</label>
                <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('passing_score')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hiển thị kết quả</label>
                <input type="checkbox" name="show_results" value="1" {{ old('show_results', $quiz->show_results) ? 'checked' : '' }} class="mt-1">
                @error('show_results')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Xáo trộn câu hỏi</label>
                <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions', $quiz->shuffle_questions) ? 'checked' : '' }} class="mt-1">
                @error('shuffle_questions')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $quiz->sort_order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('sort_order')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cập nhật</button>
        </form>

        <!-- Questions Section -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Danh sách câu hỏi</h2>
                <a href="{{ route('admin.courses.sections.quizzes.questions.create', [$course, $section, $quiz]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Thêm câu hỏi</a>
            </div>
            @forelse ($quiz->questions as $question)
                <div class="border p-4 mb-2 rounded-md flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $question->question }}</p>
                        <p class="text-sm text-gray-500">Loại: {{ __('quiz_question_types.' . $question->type) }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.courses.sections.quizzes.questions.edit', [$course, $section, $quiz, $question]) }}" class="text-blue-600 hover:underline">Sửa</a>
                        <form action="{{ route('admin.courses.sections.quizzes.questions.destroy', [$course, $section, $quiz, $question]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">Xóa</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Chưa có câu hỏi nào. Vui lòng thêm câu hỏi mới.</p>
            @endforelse
        </div>
    </div>
@endsection
