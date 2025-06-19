@extends('layouts.app')

@section('title', 'Tạo bài kiểm tra mới')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Tạo bài kiểm tra mới cho {{ $course->title }}</h1>
        <form action="{{ route('admin.courses.sections.quizzes.store', [$course, $section]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hướng dẫn</label>
                <textarea name="instructions" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('instructions') }}</textarea>
                @error('instructions')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thời gian giới hạn (phút)</label>
                <input type="number" name="time_limit" value="{{ old('time_limit') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('time_limit')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Số lần thử tối đa</label>
                <input type="number" name="max_attempts" value="{{ old('max_attempts', 1) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('max_attempts')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Điểm qua (%)</label>
                <input type="number" name="passing_score" value="{{ old('passing_score', 70) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('passing_score')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hiển thị kết quả</label>
                <input type="checkbox" name="show_results" value="1" {{ old('show_results', true) ? 'checked' : '' }} class="mt-1">
                @error('show_results')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Xáo trộn câu hỏi</label>
                <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions') ? 'checked' : '' }} class="mt-1">
                @error('shuffle_questions')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('sort_order')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Tạo</button>
        </form>
    </div>
@endsection
