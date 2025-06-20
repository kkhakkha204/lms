@extends('layouts.app')

@section('title', 'Tạo bài học mới')

@section('content')
    <div class="container mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tạo bài học mới</h1>
            <p class="text-gray-600 mt-2">Khóa học: {{ $course->title }} - Chương: {{ $section->title }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <form action="{{ route('admin.courses.sections.lessons.store', [$course, $section]) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Tiêu đề -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tiêu đề bài học <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nhập tiêu đề bài học"
                        required
                    >
                    @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Slug sẽ được tự động tạo từ tiêu đề</p>
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
                    >{{ old('content') }}</textarea>
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
                    >{{ old('summary') }}</textarea>
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
                                    value="{{ old('video_url') }}"
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
                                        value="{{ old('video_duration') }}"
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
                                        value="{{ old('video_size') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                        placeholder="50"
                                    >
                                    @error('video_size')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Video Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Xem trước video
                            </label>
                            <div id="video-preview" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center min-h-[200px] flex items-center justify-center">
                                <p class="text-gray-500">Nhập URL video để xem trước</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tài liệu đính kèm -->
                <div>
                    <label for="materials" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tài liệu đính kèm (PDF)
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
                        {{ old('is_preview') ? 'checked' : '' }}
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
                        Tạo bài học
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
                videoPreview.innerHTML = '<p class="text-gray-500">Nhập URL video để xem trước</p>';
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
    </script>
@endsection
