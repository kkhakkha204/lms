@extends('layouts.app')

@section('title', 'Chỉnh sửa bài học')

@section('content')
    <div class="container mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa bài học</h1>
            <p class="text-gray-600 mt-2">{{ $lesson->title }}</p>
            <p class="text-sm text-gray-500">Khóa học: {{ $course->title }} - Chương: {{ $section->title }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <form action="{{ route('admin.courses.sections.lessons.update', [$course, $section, $lesson]) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Tiêu đề -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tiêu đề bài học <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $lesson->title) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nhập tiêu đề bài học"
                        required
                    >
                    @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Slug hiện tại: <code class="bg-gray-100 px-2 py-1 rounded">{{ $lesson->slug }}</code></p>
                </div>

                <!-- Nội dung -->
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nội dung bài học
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nhập nội dung bài học (văn bản, ghi chú, hướng dẫn...)"
                    >{{ old('content', $lesson->content) }}</textarea>
                    @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tóm tắt -->
                <div>
                    <label for="summary" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tóm tắt bài học
                    </label>
                    <textarea
                        id="summary"
                        name="summary"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Tóm tắt ngắn gọn về nội dung bài học"
                    >{{ old('summary', $lesson->summary) }}</textarea>
                    @error('summary')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Section -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Video bài học</h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <!-- URL Video -->
                            <div class="mb-4">
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL Video
                                </label>
                                <input
                                    type="url"
                                    id="video_url"
                                    name="video_url"
                                    value="{{ old('video_url', $lesson->video_url) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://youtube.com/watch?v=..."
                                >
                                @error('video_url')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Thông tin video -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="video_duration" class="block text-sm font-medium text-gray-700 mb-2">
                                        Thời lượng
                                    </label>
                                    <input
                                        type="text"
                                        id="video_duration"
                                        name="video_duration"
                                        value="{{ old('video_duration', $lesson->video_duration) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                        placeholder="00:05:30"
                                    >
                                    @error('video_duration')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="video_size" class="block text-sm font-medium text-gray-700 mb-2">
                                        Dung lượng (MB)
                                    </label>
                                    <input
                                        type="number"
                                        id="video_size"
                                        name="video_size"
                                        value="{{ old('video_size', $lesson->video_size) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                        placeholder="50"
                                    >
                                    @error('video_size')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Thông tin loại bài học -->
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <span class="font-medium">Loại bài học hiện tại:</span>
                                    @if($lesson->type === 'video')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Video</span>
                                    @elseif($lesson->type === 'text')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Văn bản</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Kết hợp</span>
                                    @endif
                                </p>
                                <p class="text-xs text-blue-600 mt-1">Loại sẽ được tự động cập nhật dựa trên nội dung</p>
                            </div>
                        </div>

                        <!-- Video Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Xem trước video
                            </label>
                            <div id="video-preview" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center min-h-[200px] flex items-center justify-center">
                                @if($lesson->video_url)
                                    @php
                                        $youtubeRegex = '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/';
                                        preg_match($youtubeRegex, $lesson->video_url, $matches);
                                    @endphp
                                    @if(isset($matches[1]))
                                        <iframe
                                            width="100%"
                                            height="200"
                                            src="https://www.youtube.com/embed/{{ $matches[1] }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            class="rounded-lg">
                                        </iframe>
                                    @else
                                        <video
                                            width="100%"
                                            height="200"
                                            controls
                                            class="rounded-lg">
                                            <source src="{{ $lesson->video_url }}" type="video/mp4">
                                            Trình duyệt không hỗ trợ video này
                                        </video>
                                    @endif
                                @else
                                    <p class="text-gray-500">Chưa có video</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tài liệu hiện có -->
                @if($lesson->materials->count() > 0)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tài liệu hiện có</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($lesson->materials as $material)
                                <div class="flex items-center justify-between bg-white p-3 rounded-lg border">
                                    <div class="flex items-center space-x-3">
                                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $material->title }}</p>
                                            <p class="text-xs text-gray-500">{{ number_format($material->file_size / 1024, 2) }} KB</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ Storage::url($material->file_path) }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <button type="button" onclick="deleteMaterial({{ $material->id }})"
                                                class="text-red-600 hover:text-red-800">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Thêm tài liệu mới -->
                <div>
                    <label for="materials" class="block text-sm font-semibold text-gray-700 mb-2">
                        Thêm tài liệu mới (PDF)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                        <input
                            type="file"
                            id="materials"
                            name="materials[]"
                            multiple
                            accept=".pdf"
                            class="hidden"
                        >
                        <label for="materials" class="cursor-pointer">
                            <div class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="text-gray-600">
                                    <span class="font-medium text-blue-600 hover:text-blue-500">Chọn file PDF</span>
                                    <span> hoặc kéo thả vào đây</span>
                                </div>
                                <p class="text-sm text-gray-500">Chỉ chấp nhận file PDF, tối đa 10MB mỗi file</p>
                            </div>
                        </label>
                    </div>
                    <div id="selected-files" class="mt-3 space-y-2"></div>
                    @error('materials.*')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cho phép xem trước -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="is_preview"
                        name="is_preview"
                        value="1"
                        {{ old('is_preview', $lesson->is_preview) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="is_preview" class="ml-2 block text-sm text-gray-700">
                        Cho phép học viên xem trước bài học này (không cần mua khóa học)
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.courses.edit', $course) }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Hủy
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Cập nhật bài học
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Video Preview
        const videoUrlInput = document.getElementById('video_url');
        const videoPreview = document.getElementById('video-preview');

        videoUrlInput.addEventListener('input', function() {
            const url = this.value.trim();

            if (!url) {
                videoPreview.innerHTML = '<p class="text-gray-500">Chưa có video</p>';
                return;
            }

            // Check if it's a YouTube URL
            const youtubeRegex = /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/;
            const youtubeMatch = url.match(youtubeRegex);

            if (youtubeMatch) {
                const videoId = youtubeMatch[1];
                const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                videoPreview.innerHTML = `
                    <iframe
                        width="100%"
                        height="200"
                        src="${embedUrl}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="rounded-lg">
                    </iframe>
                `;
            } else {
                // For other video URLs, show video element
                videoPreview.innerHTML = `
                    <video
                        width="100%"
                        height="200"
                        controls
                        class="rounded-lg"
                        onError="this.parentElement.innerHTML='<p class=\\'text-red-500\\'>Không thể tải video từ URL này</p>'">
                        <source src="${url}" type="video/mp4">
                        Trình duyệt không hỗ trợ video này
                    </video>
                `;
            }
        });

        // File Upload Preview
        const materialsInput = document.getElementById('materials');
        const selectedFiles = document.getElementById('selected-files');

        materialsInput.addEventListener('change', function() {
            const files = Array.from(this.files);
            selectedFiles.innerHTML = '';

            files.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between bg-blue-50 p-3 rounded-lg';
                fileItem.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                selectedFiles.appendChild(fileItem);
            });
        });

        function removeFile(index) {
            const dt = new DataTransfer();
            const files = Array.from(materialsInput.files);

            files.forEach((file, i) => {
                if (i !== index) dt.items.add(file);
            });

            materialsInput.files = dt.files;
            materialsInput.dispatchEvent(new Event('change', { bubbles: true }));
        }

        // Delete existing material
        function deleteMaterial(materialId) {
            if (confirm('Bạn có chắc chắn muốn xóa tài liệu này?')) {
                // You'll need to implement this route and method
                fetch(`/admin/materials/${materialId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra khi xóa tài liệu');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xóa tài liệu');
                    });
            }
        }
    </script>
@endsection
