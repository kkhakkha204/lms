@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Quản lý danh mục</h1>
            <button onclick="openCreateModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tạo danh mục mới
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Tìm kiếm danh mục..."
                           class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <select name="status" class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tắt</option>
                    </select>
                </div>
                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                    Tìm kiếm
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                    Xóa bộ lọc
                </a>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6" id="bulk-actions" style="display: none;">
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Đã chọn <span id="selected-count">0</span> mục</span>
                <button onclick="bulkDelete()" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition text-sm">
                    Xóa đã chọn
                </button>
                <button onclick="clearSelection()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition text-sm">
                    Bỏ chọn
                </button>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if(session('success'))
                <div class="alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">
                            <input type="checkbox" id="select-all" class="rounded">
                        </th>
                        <th class="p-3 text-left">Thứ tự</th>
                        <th class="p-3 text-left">Hình ảnh</th>
                        <th class="p-3 text-left">Tên danh mục</th>
                        <th class="p-3 text-left">Mô tả</th>
                        <th class="p-3 text-left">Màu sắc</th>
                        <th class="p-3 text-left">Trạng thái</th>
                        <th class="p-3 text-left">Hành động</th>
                    </tr>
                    </thead>
                    <tbody id="sortable-categories">
                    @forelse ($categories as $category)
                        <tr class="border-b category-row" data-id="{{ $category->id }}" data-sort-order="{{ $category->sort_order }}">
                            <td class="p-3">
                                <input type="checkbox" class="category-checkbox rounded" value="{{ $category->id }}">
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center">
                                    <span class="text-sm text-center">{{ $category->sort_order }}</span>
                                </div>
                            </td>
                            <td class="p-3">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                         class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="font-medium">{{ $category->name }}</div>
                                <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                            </td>
                            <td class="p-3">
                                <div class="max-w-xs">
                                    {{ Str::limit($category->description, 80) }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $category->color }}"></div>
                                    <span class="text-sm text-gray-600">{{ $category->color }}</span>
                                </div>
                            </td>
                            <td class="p-3">
                                <button onclick="toggleStatus({{ $category->id }})"
                                        class="px-3 py-1 rounded-full text-sm font-medium transition {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $category->is_active ? 'Kích hoạt' : 'Tắt' }}
                                </button>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <button onclick="openEditModal({{ json_encode($category) }})"
                                            class="text-blue-600 hover:text-blue-800 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition"
                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <p>Chưa có danh mục nào</p>
                                    <button onclick="openCreateModal()" class="text-blue-600 hover:text-blue-800">
                                        Tạo danh mục đầu tiên
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="create-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-semibold mb-4">Tạo danh mục mới</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục</label>
                        <input type="text" name="name" id="name"
                               class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full p-2 border border-gray-300 rounded-md"
                               onchange="previewImage(this, 'create-preview')">
                        <div id="create-preview" class="mt-2 hidden">
                            <img class="w-24 h-24 object-cover rounded-lg border">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Màu sắc</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="color" id="color" value="#3B82F6"
                                   class="w-12 h-10 border border-gray-300 rounded-md cursor-pointer">
                            <input type="text" id="color-text" value="#3B82F6"
                                   class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   onchange="updateColorPicker(this.value)">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Kích hoạt danh mục</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeCreateModal()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                            Hủy
                        </button>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Tạo danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-semibold mb-4">Chỉnh sửa danh mục</h2>
                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục</label>
                        <input type="text" name="name" id="edit_name"
                               class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                        <textarea name="description" id="edit_description" rows="3"
                                  class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="edit_image" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
                        <input type="file" name="image" id="edit_image" accept="image/*"
                               class="w-full p-2 border border-gray-300 rounded-md"
                               onchange="previewImage(this, 'edit-preview')">
                        <div id="edit-preview" class="mt-2">
                            <img class="w-24 h-24 object-cover rounded-lg border">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="edit_color" class="block text-sm font-medium text-gray-700 mb-1">Màu sắc</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="color" id="edit_color"
                                   class="w-12 h-10 border border-gray-300 rounded-md cursor-pointer">
                            <input type="text" id="edit_color_text"
                                   class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   onchange="updateEditColorPicker(this.value)">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Kích hoạt danh mục</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEditModal()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                            Hủy
                        </button>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
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
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form
            document.querySelector('#create-modal form').reset();
            document.getElementById('create-preview').classList.add('hidden');
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
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Image preview
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const img = preview.querySelector('img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }

        // Color picker sync
        function updateColorPicker(value) {
            document.getElementById('color').value = value;
        }

        function updateEditColorPicker(value) {
            document.getElementById('edit_color').value = value;
        }

        // Color input change handlers
        document.getElementById('color').addEventListener('change', function() {
            document.getElementById('color-text').value = this.value;
        });

        document.getElementById('edit_color').addEventListener('change', function() {
            document.getElementById('edit_color_text').value = this.value;
        });

        // Bulk selection
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActions();
        });

        document.querySelectorAll('.category-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.category-checkbox:checked');
            const bulkActions = document.getElementById('bulk-actions');
            const selectedCount = document.getElementById('selected-count');

            if (checked.length > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = checked.length;
            } else {
                bulkActions.style.display = 'none';
            }
        }

        function clearSelection() {
            document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = false);
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

        // Toggle status
        function toggleStatus(categoryId) {
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

        // Sortable functionality
        let draggedElement = null;
        let draggedOverElement = null;

        function initializeSortable() {
            const tbody = document.getElementById('sortable-categories');
            const rows = tbody.querySelectorAll('.category-row');

            rows.forEach(row => {
                const handle = row.querySelector('.sort-handle');

                handle.addEventListener('mousedown', function(e) {
                    row.draggable = true;
                    row.style.cursor = 'grabbing';
                });

                row.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                });

                row.addEventListener('dragend', function(e) {
                    this.style.opacity = '';
                    this.draggable = false;
                    this.style.cursor = '';

                    if (draggedOverElement && draggedElement !== draggedOverElement) {
                        updateSortOrder();
                    }

                    draggedElement = null;
                    draggedOverElement = null;
                });

                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    draggedOverElement = this;
                });

                row.addEventListener('drop', function(e) {
                    e.preventDefault();

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

                // Update displayed sort order
                row.querySelector('td:nth-child(7) span:last-child').textContent = index + 1;
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
                        // Show success message
                        const successMsg = document.createElement('div');
                        successMsg.className = 'alert-success fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
                        successMsg.textContent = 'Đã cập nhật thứ tự sắp xếp';
                        document.body.appendChild(successMsg);

                        setTimeout(() => {
                            successMsg.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error updating sort order:', error);
                });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeSortable();

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
        });

        // Auto-hide success messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
@endsection
