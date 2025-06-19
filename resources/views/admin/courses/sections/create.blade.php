@extends('layouts.app')

@section('title', 'Tạo mục mới')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Tạo mục mới cho {{ $course->title }}</h1>
        <form action="{{ route('admin.courses.sections.store', $course) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
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
