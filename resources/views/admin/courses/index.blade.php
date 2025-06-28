@extends('layouts.admin')

@section('title', 'Quản lý khóa học')

@section('content')
    <div class="min-h-screen bg-white p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <div class="w-3 h-14 bg-gradient-to-b from-[#ed292a] to-[#7e0202] rounded-full shadow-lg"></div>
                    <div>
                        <h1 class="text-4xl font-bold text-[#1c1c1c] tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">Quản lý khóa học</h1>
                        <p class="text-gray-600 mt-1 ">Tạo và quản lý các khóa học của bạn</p>
                    </div>
                </div>

                <a href="{{ route('admin.courses.create') }}"
                   class="group relative overflow-hidden bg-white text-[#1c1c1c] px-8 py-4 rounded-2xl border-2 border-gray-100
                          shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]
                          hover:shadow-[inset_8px_8px_16px_#d1d9e6,inset_-8px_-8px_16px_#ffffff]
                          transition-all duration-300 ease-in-out transform hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#ed292a] to-[#7e0202] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        <span class="font-semibold">Tạo khóa học mới</span>
                    </div>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Tổng khóa học</p>
                            <p class="text-2xl font-bold text-[#1c1c1c] mt-1">{{ $courses->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-[#ed292a] to-[#7e0202] rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 2h12a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v16h12V4H6zm2 2h8v2H8V6zm0 4h8v2H8v-2zm0 4h5v2H8v-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Đã xuất bản</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $courses->where('status', 'published')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Bản nháp</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $courses->where('status', 'draft')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Lưu trữ</p>
                            <p class="text-2xl font-bold text-red-600 mt-1">{{ $courses->where('status', 'archived')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Table -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-[12px_12px_24px_#d1d9e6,-12px_-12px_24px_#ffffff] overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-[#1c1c1c]">Danh sách khóa học</h2>
                        <div class="flex items-center space-x-4">
                            <!-- Search Box -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Tìm kiếm..."
                                       class="bg-white border border-gray-200 text-[#1c1c1c] placeholder-gray-400 pl-10 pr-4 py-3 rounded-xl
                                                      shadow-[inset_4px_4px_8px_#d1d9e6,inset_-4px_-4px_8px_#ffffff]
                                                      focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-20">Ảnh</th>
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-80">Thông tin</th>
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-32">Danh mục</th>
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-28">Giá</th>
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-32">Trạng thái</th>
                                <th class="text-left py-4 px-4 text-gray-700 font-semibold tracking-wider uppercase text-sm w-40">Hành động</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @forelse ($courses as $course)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                    <td class="py-4 px-4">
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-xl border border-gray-100 overflow-hidden
                                                            shadow-[4px_4px_8px_#d1d9e6,-4px_-4px_8px_#ffffff]
                                                            group-hover:shadow-[6px_6px_12px_#d1d9e6,-6px_-6px_12px_#ffffff]
                                                            transition-all duration-300">
                                                @if ($course->thumbnail)
                                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                         alt="{{ $course->title }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M6 2h12a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v16h12V4H6zm2 2h8v2H8V6zm0 4h8v2H8v-2zm0 4h5v2H8v-2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="max-w-xs">
                                            <h3 class="text-[#1c1c1c] font-semibold text-base mb-1 group-hover:text-[#ed292a] transition-colors duration-200 truncate">
                                                {{ $course->title }}
                                            </h3>
                                            <p class="text-gray-600 text-sm line-clamp-1 mb-2">
                                                {{ Str::limit($course->description, 50) }}
                                            </p>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v4h2v-7.5c0-.83.67-1.5 1.5-1.5S12 9.67 12 10.5V11h2v-.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5V18h2v2H4v-2z"/>
                                                        </svg>
                                                        {{ $course->enrollments_count ?? 0 }}
                                                    </span>
                                                <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                                        </svg>
                                                        {{ $course->duration_hours }}h
                                                    </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                                         bg-gradient-to-r from-[#ed292a] to-[#7e0202] text-white
                                                         shadow-sm">
                                                {{ $course->category->name }}
                                            </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-[#1c1c1c] font-bold">
                                            @if ($course->is_free)
                                                <span class="text-green-600 text-sm font-semibold">Miễn phí</span>
                                            @else
                                                <div>
                                                    @if($course->discount_price && $course->discount_price < $course->price)
                                                        <div class="text-[#ed292a] font-bold text-sm">{{ number_format($course->discount_price, 0, ',', '.') }}đ</div>
                                                        <div class="text-xs text-gray-400 line-through">{{ number_format($course->price, 0, ',', '.') }}đ</div>
                                                    @else
                                                        <div class="text-sm font-bold">{{ number_format($course->price, 0, ',', '.') }}đ</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if ($course->status === 'published')
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                                             bg-green-50 text-green-700 border border-green-200">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                                                    Xuất bản
                                                </span>
                                        @elseif ($course->status === 'draft')
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                                             bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                                                    Nháp
                                                </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                                             bg-red-50 text-red-700 border border-red-200">
                                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
                                                    Lưu trữ
                                                </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.courses.edit', $course) }}"
                                               class="group inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium
                                                          bg-white text-[#1c1c1c] border border-gray-200 hover:text-[#ed292a] hover:border-[#ed292a]
                                                          shadow-sm hover:shadow-md transition-all duration-300"
                                               title="Sửa khóa học">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')"
                                                        class="group inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium
                                                                   bg-white text-[#1c1c1c] border border-gray-200 hover:text-red-600 hover:border-red-300
                                                                   shadow-sm hover:shadow-md transition-all duration-300"
                                                        title="Xóa khóa học">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100
                                                            shadow-[inset_8px_8px_16px_#d1d9e6,inset_-8px_-8px_16px_#ffffff]">
                                                <span class="text-4xl">📚</span>
                                            </div>
                                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Chưa có khóa học nào</h3>
                                            <p class="text-gray-500 mb-6">Hãy tạo khóa học đầu tiên của bạn</p>
                                            <a href="{{ route('admin.courses.create') }}"
                                               class="inline-flex items-center px-6 py-3 rounded-xl font-medium text-white
                                                          bg-gradient-to-r from-[#ed292a] to-[#7e0202]
                                                          shadow-[4px_4px_8px_#d1d9e6,-4px_-4px_8px_#ffffff]
                                                          hover:shadow-[6px_6px_12px_#d1d9e6,-6px_-6px_12px_#ffffff]
                                                          transition-all duration-300 transform hover:scale-105">
                                                <span class="mr-2">➕</span>
                                                Tạo khóa học ngay
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($courses, 'links') && $courses->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-[8px_8px_16px_#d1d9e6,-8px_-8px_16px_#ffffff]">
                                {{ $courses->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #ed292a;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #7e0202;
        }

        /* Custom pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }

        .pagination a {
            color: #6b7280;
            background: white;
            box-shadow: 2px 2px 4px #d1d9e6, -2px -2px 4px #ffffff;
        }

        .pagination a:hover {
            color: #ed292a;
            border-color: #ed292a;
            box-shadow: inset 2px 2px 4px #d1d9e6, inset -2px -2px 4px #ffffff;
        }

        .pagination .active span {
            color: white;
            background: linear-gradient(135deg, #ed292a, #7e0202);
            border-color: #ed292a;
            box-shadow: 2px 2px 4px #d1d9e6, -2px -2px 4px #ffffff;
        }

        .pagination .disabled span {
            color: #d1d5db;
            background: #f9fafb;
            cursor: not-allowed;
        }
    </style>

    <!-- JavaScript để handle search -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[placeholder="Tìm kiếm khóa học..."]');
            const tableRows = document.querySelectorAll('tbody tr:not(:last-child)');

            if (searchInput && tableRows.length > 0) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    tableRows.forEach(row => {
                        const title = row.querySelector('h3').textContent.toLowerCase();
                        const category = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                        if (title.includes(searchTerm) || category.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection
