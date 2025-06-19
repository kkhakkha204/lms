@extends('layouts.app')

@section('title', 'Chỉnh sửa bài học')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Chỉnh sửa bài học: {{ $lesson->title }}</h1>
        <form action="{{ route('admin.courses.sections.lessons.update', [$course, $section, $lesson]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $lesson->slug) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('slug')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                <textarea name="content" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content', $lesson->content) }}</textarea>
                @error('content')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tóm tắt</label>
                <textarea name="summary" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('summary', $lesson->summary) }}</textarea>
                @error('summary')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">URL Video</label>
                <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('video_url')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thời lượng video</label>
                <input type="text" name="video_duration" value="{{ old('video_duration', $lesson->video_duration) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="HH:MM:SS">
                @error('video_duration')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Kích thước video (MB)</label>
                <input type="number" name="video_size" value="{{ old('video_size', $lesson->video_size) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('video_size')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Loại bài học</label>
                <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="video" {{ old('type', $lesson->type) == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="text" {{ old('type', $lesson->type) == 'text' ? 'selected' : '' }}>Văn bản</option>
                    <option value="mixed" {{ old('type', $lesson->type) == 'mixed' ? 'selected' : '' }}>Kết hợp</option>
                </select>
                @error('type')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cho phép xem trước</label>
                <input type="checkbox" name="is_preview" value="1" {{ old('is_preview', $lesson->is_preview) ? 'checked' : '' }} class="mt-1">
                @error('is_preview')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $lesson->sort_order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('sort_order')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tài liệu (PDF)</label>
                <input type="file" name="materials[]" multiple accept=".pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('materials.*')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @if ($lesson->materials->count())
                    <div class="mt-2">
                        <h4 class="text-sm font-medium text-gray-700">Tài liệu hiện có</h4>
                        <ul class="list-disc pl-5">
                            @foreach ($lesson->materials as $material)
                                <li>{{ $material->title }} ({{ $material->file_type }}, {{ number_format($material->file_size / 1024, 2) }} KB)</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cập nhật</button>
        </form>
    </div>
@endsection
