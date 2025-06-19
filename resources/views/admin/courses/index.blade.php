@extends('layouts.admin')

@section('title', 'Quản lý khóa học')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Quản lý khóa học</h1>
            <a href="{{ route('admin.courses.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Tạo khóa học mới
            </a>
        </div>

        <!-- Bảng danh sách khóa học -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">Hình ảnh</th>
                    <th class="p-3 text-left">Tiêu đề</th>
                    <th class="p-3 text-left">Danh mục</th>
                    <th class="p-3 text-left">Giá</th>
                    <th class="p-3 text-left">Trạng thái</th>
                    <th class="p-3 text-left">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($courses as $course)
                    <tr class="border-b">
                        <td class="p-3">
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-3">{{ $course->title }}</td>
                        <td class="p-3">{{ $course->category->name }}</td>
                        <td class="p-3">
                            @if ($course->is_free)
                                Miễn phí
                            @else
                                {{ number_format($course->discount_price ?? $course->price, 0, ',', '.') }} VND
                            @endif
                        </td>
                        <td class="p-3">
                            @if ($course->status === 'published')
                                <span class="text-green-600">Đã xuất bản</span>
                            @elseif ($course->status === 'draft')
                                <span class="text-yellow-600">Bản nháp</span>
                            @else
                                <span class="text-red-600">Lưu trữ</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <a href="{{ route('admin.courses.edit', $course) }}"
                               class="text-blue-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2"
                                        onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center">Chưa có khóa học nào</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
