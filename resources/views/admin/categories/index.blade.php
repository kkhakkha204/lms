@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
    <style>
        /* Neumorphism Variables */
        :root {
            --primary-dark: #1c1c1c;
            --primary-red: #7e0202;
            --accent-red: #ed292a;
            --bg-white: #ffffff;
            --bg-light: #f8f9fa;
            --shadow-light: rgba(255, 255, 255, 0.8);
            --shadow-dark: rgba(0, 0, 0, 0.1);
            --shadow-inset-light: inset 2px 2px 5px rgba(0, 0, 0, 0.05);
            --shadow-inset-dark: inset -2px -2px 5px rgba(255, 255, 255, 0.8);
        }

        /* Base Neumorphism Styles */
        .neuro-card {
            background: var(--bg-white);
            box-shadow: 8px 8px 20px var(--shadow-dark), -8px -8px 20px var(--shadow-light);
            border-radius: 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .neuro-card:hover {
            box-shadow: 12px 12px 25px var(--shadow-dark), -12px -12px 25px var(--shadow-light);
            transform: translateY(-2px);
        }

        .neuro-btn {
            box-shadow: 4px 4px 10px var(--shadow-dark), -4px -4px 10px var(--shadow-light);
            border: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .neuro-btn:hover {
            box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
            transform: translateY(1px);
        }

        .neuro-btn:active {
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark);
            transform: translateY(2px);
        }

        .neuro-btn-primary {
            background: linear-gradient(145deg, var(--primary-red), var(--accent-red));
            color: white;
            box-shadow: 4px 4px 10px rgba(126, 2, 2, 0.3), -4px -4px 10px rgba(237, 41, 42, 0.1);
        }

        .neuro-btn-primary:hover {
            box-shadow: 2px 2px 5px rgba(126, 2, 2, 0.4), -2px -2px 5px rgba(237, 41, 42, 0.2);
            color: white;
        }

        .neuro-input {
            background: var(--bg-white);
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark);
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .neuro-input:focus {
            outline: none;
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark), 0 0 0 3px rgba(237, 41, 42, 0.1);
        }

        .neuro-table {
            background: var(--bg-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 8px 8px 20px var(--shadow-dark), -8px -8px 20px var(--shadow-light);
        }

        .neuro-table-row {
            transition: all 0.2s ease;
            background: var(--bg-white);
        }

        .neuro-table-row:hover {
            background: var(--bg-light);
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            background: var(--bg-white);
            box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .status-badge.active {
            background: linear-gradient(145deg, #10b981, #059669);
            color: white;
            box-shadow: 2px 2px 5px rgba(16, 185, 129, 0.3);
        }

        .status-badge.inactive {
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 2px 2px 5px rgba(239, 68, 68, 0.3);
        }

        .action-btn {
            background: var(--bg-white);
            box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
            border: none;
            border-radius: 8px;
            padding: 8px;
            transition: all 0.2s ease;
            color: var(--primary-dark);
        }

        .action-btn:hover {
            box-shadow: 1px 1px 3px var(--shadow-dark), -1px -1px 3px var(--shadow-light);
            color: var(--accent-red);
            transform: translateY(1px);
        }

        .gradient-header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .modal-overlay {
            background: rgba(28, 28, 28, 0.8);
            backdrop-filter: blur(10px);
        }

        .modal-content {
            background: var(--bg-white);
            border-radius: 25px;
            border: none;
        }

        .image-preview {
            background: var(--bg-white);
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark);
            border-radius: 15px;
            padding: 4px;
        }

        .color-display {
            box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
            border-radius: 8px;
        }

        .alert-success {
            background: var(--bg-white);
            box-shadow: 4px 4px 15px rgba(16, 185, 129, 0.2), -4px -4px 15px var(--shadow-light);
            border: 2px solid #10b981;
            border-radius: 15px;
            color: #065f46;
        }

        .empty-state {
            background: var(--bg-white);
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark);
            border-radius: 20px;
            margin: 20px;
            padding: 40px;
        }

        /* Search and Filter Enhancement */
        .search-container {
            background: var(--bg-white);
            box-shadow: 6px 6px 15px var(--shadow-dark), -6px -6px 15px var(--shadow-light);
            border-radius: 18px;
            padding: 24px;
        }

        /* Bulk Actions Enhancement */
        .bulk-actions {
            background: linear-gradient(145deg, var(--bg-light), var(--bg-white));
            box-shadow: 4px 4px 10px var(--shadow-dark), -4px -4px 10px var(--shadow-light);
            border-radius: 15px;
            padding: 16px 24px;
        }

        /* Custom Checkbox */
        .neuro-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            background: var(--bg-white);
            box-shadow: var(--shadow-inset-light), var(--shadow-inset-dark);
            border-radius: 6px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .neuro-checkbox:checked {
            background: linear-gradient(145deg, var(--primary-red), var(--accent-red));
            box-shadow: 2px 2px 5px rgba(126, 2, 2, 0.3);
        }

        .neuro-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, var(--bg-light) 25%, var(--bg-white) 50%, var(--bg-light) 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Responsive Enhancements */
        @media (max-width: 768px) {
            .neuro-card {
                box-shadow: 4px 4px 10px var(--shadow-dark), -4px -4px 10px var(--shadow-light);
                border-radius: 15px;
            }

            .modal-content {
                margin: 10px;
                border-radius: 20px;
            }
        }
    </style>

    <div class="min-h-screen" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-4xl font-bold mb-2 tracking-wide" style="font-family: 'CustomTitle', sans-serif; ">Quản lý danh mục</h1>
                    <p class="text-gray-600">Tạo và quản lý các danh mục khóa học của bạn</p>
                </div>
                <button onclick="openCreateModal()"
                        class="neuro-btn neuro-btn-primary px-6 py-3 flex items-center gap-3 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tạo danh mục mới
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="search-container mb-8">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Tìm kiếm danh mục..."
                               class="neuro-input w-full text-gray-700 placeholder-gray-400">
                    </div>
                    <div class="md:w-48">
                        <select name="status" class="neuro-input w-full text-gray-700">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tắt</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="neuro-btn bg-[#1c1c1c] px-6 py-3 font-semibold text-gray-100">
                            Tìm kiếm
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                           class="neuro-btn px-6 py-3 font-semibold text-gray-500">
                            Xóa bộ lọc
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions mb-6" id="bulk-actions" style="display: none;">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600">Đã chọn <span id="selected-count">0</span> mục</span>
                    <button onclick="bulkDelete()" class="neuro-btn neuro-btn-primary px-4 py-2 text-sm font-semibold">
                        Xóa đã chọn
                    </button>
                    <button onclick="clearSelection()" class="neuro-btn px-4 py-2 text-sm font-semibold text-gray-600">
                        Bỏ chọn
                    </button>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="neuro-table mb-8">
                @if(session('success'))
                    <div class="alert-success px-6 py-4 mb-6 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-white">
                            <th class="p-4 text-left">
                                <input type="checkbox" id="select-all" class="neuro-checkbox">
                            </th>
                            <th class="p-4 text-left font-bold text-gray-700">Thứ tự</th>
                            <th class="p-4 text-left font-bold text-gray-700">Hình ảnh</th>
                            <th class="p-4 text-left font-bold text-gray-700">Tên danh mục</th>
                            <th class="p-4 text-left font-bold text-gray-700">Mô tả</th>
                            <th class="p-4 text-left font-bold text-gray-700">Màu sắc</th>
                            <th class="p-4 text-left font-bold text-gray-700">Trạng thái</th>
                            <th class="p-4 text-left font-bold text-gray-700">Hành động</th>
                        </tr>
                        </thead>
                        <tbody id="sortable-categories">
                        @forelse ($categories as $category)
                            <tr class="neuro-table-row border-b border-gray-100 category-row" data-id="{{ $category->id }}" data-sort-order="{{ $category->sort_order }}">
                                <td class="p-4">
                                    <input type="checkbox" class="neuro-checkbox category-checkbox" value="{{ $category->id }}">
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-center">
                                        <span class="text-sm font-semibold text-gray-600 bg-white px-3 py-1 rounded-full shadow-inner">{{ $category->sort_order }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if ($category->image)
                                        <div class="image-preview w-16 h-16">
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                 class="w-full h-full object-cover rounded-lg">
                                        </div>
                                    @else
                                        <div class="image-preview w-16 h-16 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $category->name }}</div>
                                    <div class="text-sm text-gray-500 font-medium">{{ $category->slug }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="max-w-xs text-gray-600">
                                        {{ Str::limit($category->description, 80) }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="color-display w-6 h-6" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-sm font-medium text-gray-600">{{ $category->color }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <button onclick="toggleStatus({{ $category->id }})"
                                            class="status-badge {{ $category->is_active ? 'active' : 'inactive' }}">
                                        {{ $category->is_active ? 'Kích hoạt' : 'Tắt' }}
                                    </button>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditModal({{ json_encode($category) }})"
                                                class="action-btn" title="Chỉnh sửa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn text-red-500" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-0">
                                    <div class="empty-state text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="neuro-card p-6 inline-block">
                                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-700 mb-2">Chưa có danh mục nào</h3>
                                                <p class="text-gray-500 mb-4">Tạo danh mục đầu tiên để bắt đầu tổ chức khóa học</p>
                                                <button onclick="openCreateModal()" class="neuro-btn neuro-btn-primary px-6 py-3 font-semibold">
                                                    Tạo danh mục đầu tiên
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="create-modal" class="fixed inset-0 modal-overlay flex items-center justify-center z-50 hidden">
            <div class="modal-content p-8 w-full max-w-md max-h-[90vh] overflow-y-auto m-4">
                <h2 class="text-2xl font-bold gradient-header mb-6">Tạo danh mục mới</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-3">Tên danh mục</label>
                        <input type="text" name="name" id="name"
                               class="neuro-input w-full @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-3">Mô tả</label>
                        <textarea name="description" id="description" rows="3"
                                  class="neuro-input w-full resize-none"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-3">Hình ảnh</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="neuro-input w-full"
                               onchange="previewImage(this, 'create-preview')">
                        <div id="create-preview" class="mt-4 hidden">
                            <div class="image-preview w-24 h-24">
                                <img class="w-full h-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="color" class="block text-sm font-bold text-gray-700 mb-3">Màu sắc</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="color" id="color" value="#7e0202"
                                   class="neuro-input w-16 h-12 cursor-pointer">
                            <input type="text" id="color-text" value="#7e0202"
                                   class="neuro-input flex-1"
                                   onchange="updateColorPicker(this.value)">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" checked
                                   class="neuro-checkbox">
                            <span class="text-sm font-semibold text-gray-700">Kích hoạt danh mục</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeCreateModal()"
                                class="neuro-btn px-6 py-3 font-semibold text-gray-600">
                            Hủy
                        </button>
                        <button type="submit"
                                class="neuro-btn neuro-btn-primary px-6 py-3 font-semibold">
                            Tạo danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="edit-modal" class="fixed inset-0 modal-overlay flex items-center justify-center z-50 hidden">
            <div class="modal-content p-8 w-full max-w-md max-h-[90vh] overflow-y-auto m-4">
                <h2 class="text-2xl font-bold gradient-header mb-6">Chỉnh sửa danh mục</h2>
                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-6">
                        <label for="edit_name" class="block text-sm font-bold text-gray-700 mb-3">Tên danh mục</label>
                        <input type="text" name="name" id="edit_name"
                               class="neuro-input w-full"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="edit_description" class="block text-sm font-bold text-gray-700 mb-3">Mô tả</label>
                        <textarea name="description" id="edit_description" rows="3"
                                  class="neuro-input w-full resize-none"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="edit_image" class="block text-sm font-bold text-gray-700 mb-3">Hình ảnh</label>
                        <input type="file" name="image" id="edit_image" accept="image/*"
                               class="neuro-input w-full"
                               onchange="previewImage(this, 'edit-preview')">
                        <div id="edit-preview" class="mt-4">
                            <div class="image-preview w-24 h-24">
                                <img class="w-full h-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="edit_color" class="block text-sm font-bold text-gray-700 mb-3">Màu sắc</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="color" id="edit_color"
                                   class="neuro-input w-16 h-12 cursor-pointer">
                            <input type="text" id="edit_color_text"
                                   class="neuro-input flex-1"
                                   onchange="updateEditColorPicker(this.value)">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                   class="neuro-checkbox">
                            <span class="text-sm font-semibold text-gray-700">Kích hoạt danh mục</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeEditModal()"
                                class="neuro-btn px-6 py-3 font-semibold text-gray-600">
                            Hủy
                        </button>
                        <button type="submit"
                                class="neuro-btn neuro-btn-primary px-6 py-3 font-semibold">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Add smooth entrance animation
            setTimeout(() => {
                document.querySelector('#create-modal .modal-content').style.transform = 'scale(1)';
                document.querySelector('#create-modal .modal-content').style.opacity = '1';
            }, 10);
        }

        function closeCreateModal() {
            const modal = document.getElementById('create-modal');
            const content = modal.querySelector('.modal-content');

            content.style.transform = 'scale(0.95)';
            content.style.opacity = '0';

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                // Reset form
                document.querySelector('#create-modal form').reset();
                document.getElementById('create-preview').classList.add('hidden');
                content.style.transform = 'scale(0.95)';
                content.style.opacity = '0';
            }, 200);
        }

        function openEditModal(category) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-form');

            form.action = `/admin/categories/${category.id}`;
            document.getElementById('edit_name').value = category.name;
            document.getElementById('edit_description').value = category.description || '';
            document.getElementById('edit_color').value = category.color;
            document.getElementById('edit_color_text').value = category.color;
            document.getElementById('edit_is_active').checked = category.is_active;

            // Show current image if exists
            const preview = document.querySelector('#edit-preview img');
            if (category.image) {
                preview.src = `/storage/${category.image}`;
                document.getElementById('edit-preview').classList.remove('hidden');
            } else {
                document.getElementById('edit-preview').classList.add('hidden');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Add smooth entrance animation
            setTimeout(() => {
                document.querySelector('#edit-modal .modal-content').style.transform = 'scale(1)';
                document.querySelector('#edit-modal .modal-content').style.opacity = '1';
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            const content = modal.querySelector('.modal-content');

            content.style.transform = 'scale(0.95)';
            content.style.opacity = '0';

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                content.style.transform = 'scale(0.95)';
                content.style.opacity = '0';
            }, 200);
        }

        // Image preview with enhanced styling
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const img = preview.querySelector('img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                    // Add entrance animation
                    preview.style.transform = 'scale(0.8)';
                    preview.style.opacity = '0';
                    setTimeout(() => {
                        preview.style.transform = 'scale(1)';
                        preview.style.opacity = '1';
                    }, 10);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }

        // Color picker sync with enhanced feedback
        function updateColorPicker(value) {
            document.getElementById('color').value = value;
            // Add visual feedback
            const input = document.getElementById('color-text');
            input.style.borderColor = value;
            setTimeout(() => {
                input.style.borderColor = '';
            }, 1000);
        }

        function updateEditColorPicker(value) {
            document.getElementById('edit_color').value = value;
            // Add visual feedback
            const input = document.getElementById('edit_color_text');
            input.style.borderColor = value;
            setTimeout(() => {
                input.style.borderColor = '';
            }, 1000);
        }

        // Color input change handlers
        document.getElementById('color').addEventListener('change', function() {
            document.getElementById('color-text').value = this.value;
        });

        document.getElementById('edit_color').addEventListener('change', function() {
            document.getElementById('edit_color_text').value = this.value;
        });

        // Enhanced bulk selection with animations
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach((cb, index) => {
                setTimeout(() => {
                    cb.checked = this.checked;
                    if (this.checked) {
                        cb.parentElement.parentElement.style.backgroundColor = '#f8f9fa';
                    } else {
                        cb.parentElement.parentElement.style.backgroundColor = '';
                    }
                }, index * 50);
            });
            updateBulkActions();
        });

        document.querySelectorAll('.category-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                // Add visual feedback
                if (this.checked) {
                    this.parentElement.parentElement.style.backgroundColor = '#f8f9fa';
                } else {
                    this.parentElement.parentElement.style.backgroundColor = '';
                }
                updateBulkActions();
            });
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.category-checkbox:checked');
            const bulkActions = document.getElementById('bulk-actions');
            const selectedCount = document.getElementById('selected-count');

            if (checked.length > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = checked.length;
                // Add entrance animation
                bulkActions.style.transform = 'translateY(-10px)';
                bulkActions.style.opacity = '0';
                setTimeout(() => {
                    bulkActions.style.transform = 'translateY(0)';
                    bulkActions.style.opacity = '1';
                }, 10);
            } else {
                bulkActions.style.opacity = '0';
                bulkActions.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    bulkActions.style.display = 'none';
                }, 200);
            }
        }

        function clearSelection() {
            document.querySelectorAll('.category-checkbox').forEach(cb => {
                cb.checked = false;
                cb.parentElement.parentElement.style.backgroundColor = '';
            });
            document.getElementById('select-all').checked = false;
            updateBulkActions();
        }

        function bulkDelete() {
            const checked = document.querySelectorAll('.category-checkbox:checked');
            if (checked.length === 0) return;

            if (confirm(`Bạn có chắc muốn xóa ${checked.length} danh mục đã chọn?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.categories.bulk-delete") }}';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                checked.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Enhanced toggle status with visual feedback
        function toggleStatus(categoryId) {
            const button = event.target;
            const originalText = button.textContent;

            // Show loading state
            button.textContent = '...';
            button.style.opacity = '0.7';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/categories/${categoryId}/toggle-status`;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        }

        // Enhanced sortable functionality
        let draggedElement = null;
        let draggedOverElement = null;

        function initializeSortable() {
            const tbody = document.getElementById('sortable-categories');
            const rows = tbody.querySelectorAll('.category-row');

            rows.forEach(row => {
                row.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                    this.style.transform = 'rotate(2deg)';
                });

                row.addEventListener('dragend', function(e) {
                    this.style.opacity = '';
                    this.style.transform = '';
                    this.draggable = false;

                    if (draggedOverElement && draggedElement !== draggedOverElement) {
                        updateSortOrder();
                    }

                    draggedElement = null;
                    draggedOverElement = null;
                });

                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    draggedOverElement = this;
                    this.style.backgroundColor = '#f0f9ff';
                });

                row.addEventListener('dragleave', function(e) {
                    this.style.backgroundColor = '';
                });

                row.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.backgroundColor = '';

                    if (draggedElement !== this) {
                        const tbody = this.parentNode;
                        const draggedIndex = Array.from(tbody.children).indexOf(draggedElement);
                        const targetIndex = Array.from(tbody.children).indexOf(this);

                        if (draggedIndex < targetIndex) {
                            tbody.insertBefore(draggedElement, this.nextSibling);
                        } else {
                            tbody.insertBefore(draggedElement, this);
                        }
                    }
                });

                // Add drag handle cursor on hover
                row.addEventListener('mouseenter', function() {
                    this.style.cursor = 'grab';
                    this.draggable = true;
                });

                row.addEventListener('mouseleave', function() {
                    this.style.cursor = '';
                    this.draggable = false;
                });
            });
        }

        function updateSortOrder() {
            const rows = document.querySelectorAll('.category-row');
            const items = [];

            rows.forEach((row, index) => {
                items.push({
                    id: row.dataset.id,
                    sort_order: index + 1
                });

                // Update displayed sort order with animation
                const orderSpan = row.querySelector('td:nth-child(2) span');
                orderSpan.style.transform = 'scale(1.2)';
                orderSpan.style.color = '#ed292a';
                orderSpan.textContent = index + 1;

                setTimeout(() => {
                    orderSpan.style.transform = 'scale(1)';
                    orderSpan.style.color = '';
                }, 300);
            });

            fetch('{{ route("admin.categories.update-sort-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessMessage('Đã cập nhật thứ tự sắp xếp');
                    }
                })
                .catch(error => {
                    console.error('Error updating sort order:', error);
                    showErrorMessage('Có lỗi xảy ra khi cập nhật thứ tự');
                });
        }

        // Enhanced success/error messages
        function showSuccessMessage(message) {
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-6 right-6 bg-white px-6 py-4 rounded-2xl shadow-lg border-2 border-green-500 text-green-700 font-semibold z-50 transform translate-x-full opacity-0 transition-all duration-300';
            successMsg.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    ${message}
                </div>
            `;
            document.body.appendChild(successMsg);

            setTimeout(() => {
                successMsg.style.transform = 'translate(0)';
                successMsg.style.opacity = '1';
            }, 100);

            setTimeout(() => {
                successMsg.style.transform = 'translate(100%)';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 300);
            }, 3000);
        }

        function showErrorMessage(message) {
            const errorMsg = document.createElement('div');
            errorMsg.className = 'fixed top-6 right-6 bg-white px-6 py-4 rounded-2xl shadow-lg border-2 border-red-500 text-red-700 font-semibold z-50 transform translate-x-full opacity-0 transition-all duration-300';
            errorMsg.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    ${message}
                </div>
            `;
            document.body.appendChild(errorMsg);

            setTimeout(() => {
                errorMsg.style.transform = 'translate(0)';
                errorMsg.style.opacity = '1';
            }, 100);

            setTimeout(() => {
                errorMsg.style.transform = 'translate(100%)';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 300);
            }, 4000);
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeSortable();

            // Initialize modal animations
            document.querySelectorAll('.modal-content').forEach(content => {
                content.style.transform = 'scale(0.95)';
                content.style.opacity = '0';
                content.style.transition = 'all 0.2s ease';
            });

            // Close modals when clicking outside
            document.getElementById('create-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCreateModal();
                }
            });

            document.getElementById('edit-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });

            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCreateModal();
                    closeEditModal();
                }
            });

            // Add loading states to buttons
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Đang xử lý...
                        `;
                        submitBtn.disabled = true;
                    }
                });
            });
        });

        // Auto-hide success messages with enhanced animation
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(alert => {
                alert.style.transition = 'all 0.5s ease';
                alert.style.transform = 'translateY(-20px)';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Add intersection observer for table rows animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.category-row').forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            row.style.transition = `all 0.3s ease ${index * 0.1}s`;
            observer.observe(row);
        });
    </script>
@endsection
