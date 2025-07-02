@extends('layouts.admin')

@section('title', 'Tạo bài học mới')

@section('content')
    <div class="min-h-screen bg-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <!-- Header Section -->
            <div class="mb-12">
                <div class="text-center space-y-6">
                    <h1 class="text-5xl font-bold text-primary tracking-tight">Tạo bài học mới</h1>
                    <div class="inline-flex items-center px-8 py-4 bg-white rounded-2xl shadow-neumorph">
                        <i class="fas fa-graduation-cap text-accent mr-4 text-xl"></i>
                        <div class="text-left">
                            <p class="text-lg font-semibold text-primary">{{ $course->title }}</p>
                            <p class="text-gray-600">Chương: <span class="font-medium text-accent">{{ $section->title }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-3xl shadow-neumorph overflow-hidden">
                <!-- Card Header -->
                <div class="relative px-8 py-8 bg-gradient-to-br from-accent via-danger to-accent">
                    <div class="absolute inset-0 bg-black bg-opacity-10 rounded-t-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                                <i class="fas fa-play-circle text-2xl text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Thông tin bài học</h2>
                                <p class="text-white text-opacity-90 mt-1 text-lg">
                                    Tạo nội dung học tập chất lượng cao cho học viên
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('admin.courses.sections.lessons.store', [$course, $section]) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-12">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="space-y-8">
                        <h3 class="text-2xl font-bold text-primary flex items-center">
                            <i class="fas fa-info-circle text-accent mr-3"></i>
                            Thông tin cơ bản
                        </h3>

                        <!-- Title Field -->
                        <div class="space-y-4">
                            <label for="title" class="flex items-center text-lg font-bold text-primary">
                                <i class="fas fa-heading text-accent mr-3"></i>
                                Tiêu đề bài học
                                <span class="text-danger ml-2">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       placeholder="Nhập tiêu đề bài học..."
                                       class="w-full px-6 py-5 text-lg bg-white border-0 rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium"
                                       required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="fas fa-edit text-gray-400"></i>
                                </div>
                            </div>
                            @error('title')
                            <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                                <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                                <span class="text-danger font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="flex items-center p-4 bg-blue-50 rounded-xl border-l-4 border-accent">
                                <i class="fas fa-lightbulb text-accent mr-3"></i>
                                <p class="text-gray-700 text-sm">Slug sẽ được tự động tạo từ tiêu đề</p>
                            </div>
                        </div>

                        <!-- Summary Field -->
                        <div class="space-y-4">
                            <label for="summary" class="flex items-center text-lg font-bold text-primary">
                                <i class="fas fa-list-alt text-accent mr-3"></i>
                                Tóm tắt bài học
                            </label>
                            <div class="relative">
                            <textarea id="summary"
                                      name="summary"
                                      rows="4"
                                      placeholder="Tóm tắt ngắn gọn về nội dung bài học..."
                                      class="w-full px-6 py-5 text-lg bg-white border-0 rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium resize-none">{{ old('summary') }}</textarea>
                                <div class="absolute top-5 right-0 flex items-center pr-6">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </div>
                            </div>
                            @error('summary')
                            <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                                <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                                <span class="text-danger font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="space-y-8">
                        <h3 class="text-2xl font-bold text-primary flex items-center">
                            <i class="fas fa-file-alt text-accent mr-3"></i>
                            Nội dung bài học
                        </h3>

                        <div class="space-y-4">
                            <label for="content" class="flex items-center text-lg font-bold text-primary">
                                <i class="fas fa-code text-accent mr-3"></i>
                                Nội dung chi tiết
                            </label>
                            <div class="relative">
                            <textarea id="content"
                                      name="content"
                                      rows="20"
                                      placeholder="Nhập nội dung bài học..."
                                      class="w-full px-6 py-5 text-lg bg-white border-0 rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium resize-none">{{ old('content') }}</textarea>
                            </div>
                            @error('content')
                            <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                                <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                                <span class="text-danger font-medium">{{ $message }}</span>
                            </div>
                            @enderror

                            <!-- Rich Text Editor Instructions -->
                            <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-neumorph-inset border-l-4 border-accent">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-accent bg-opacity-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-tools text-accent text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-primary mb-3">Hướng dẫn sử dụng</h4>
                                        <ul class="space-y-2 text-gray-700">
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-accent mr-2"></i>
                                                Sử dụng toolbar để định dạng văn bản (đậm, nghiêng, gạch chân...)
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-accent mr-2"></i>
                                                Chèn hình ảnh, bảng, liên kết, code snippet
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-accent mr-2"></i>
                                                Tạo danh sách có thứ tự hoặc không có thứ tự
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-accent mr-2"></i>
                                                Thêm màu sắc cho văn bản và nền
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Section -->
                    <div class="space-y-8">
                        <h3 class="text-2xl font-bold text-primary flex items-center">
                            <i class="fas fa-video text-accent mr-3"></i>
                            Video bài học
                        </h3>

                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-neumorph-inset p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Video Input -->
                                <div class="space-y-6">
                                    <!-- URL Video -->
                                    <div class="space-y-4">
                                        <label for="video_url" class="flex items-center text-lg font-bold text-primary">
                                            <i class="fas fa-link text-accent mr-3"></i>
                                            URL Video
                                        </label>
                                        <div class="relative">
                                            <input type="url"
                                                   id="video_url"
                                                   name="video_url"
                                                   value="{{ old('video_url') }}"
                                                   placeholder="https://youtube.com/watch?v=..."
                                                   class="w-full px-6 py-4 text-lg bg-white border-0 rounded-xl shadow-neumorph-sm focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                <i class="fas fa-globe text-gray-400"></i>
                                            </div>
                                        </div>
                                        @error('video_url')
                                        <div class="flex items-center p-3 bg-danger bg-opacity-5 rounded-lg border border-danger border-opacity-20">
                                            <i class="fas fa-exclamation-triangle text-danger mr-2 text-sm"></i>
                                            <span class="text-danger text-sm font-medium">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Video Duration -->
                                    <div class="space-y-4">
                                        <label for="video_duration" class="flex items-center text-lg font-bold text-primary">
                                            <i class="fas fa-clock text-accent mr-3"></i>
                                            Thời lượng
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                   id="video_duration"
                                                   name="video_duration"
                                                   value="{{ old('video_duration') }}"
                                                   placeholder="00:05:30"
                                                   class="w-full px-6 py-4 text-lg bg-white border-0 rounded-xl shadow-neumorph-sm focus:shadow-neumorph transition-all duration-300 placeholder-gray-400 text-primary font-medium">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                <i class="fas fa-stopwatch text-gray-400"></i>
                                            </div>
                                        </div>
                                        @error('video_duration')
                                        <div class="flex items-center p-3 bg-danger bg-opacity-5 rounded-lg border border-danger border-opacity-20">
                                            <i class="fas fa-exclamation-triangle text-danger mr-2 text-sm"></i>
                                            <span class="text-danger text-sm font-medium">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Video Preview -->
                                <div class="space-y-4">
                                    <label class="flex items-center text-lg font-bold text-primary">
                                        <i class="fas fa-eye text-accent mr-3"></i>
                                        Xem trước video
                                    </label>
                                    <div id="video-preview" class="bg-white rounded-xl shadow-neumorph-inset p-8 text-center min-h-[250px] flex items-center justify-center border-2 border-dashed border-gray-200">
                                        <div class="space-y-4">
                                            <i class="fas fa-play-circle text-6xl text-gray-400"></i>
                                            <p class="text-gray-500 font-medium">Nhập URL video để xem trước</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Materials Section -->
                    <div class="space-y-8">
                        <h3 class="text-2xl font-bold text-primary flex items-center">
                            <i class="fas fa-paperclip text-accent mr-3"></i>
                            Tài liệu đính kèm
                        </h3>

                        <div class="space-y-4">
                            <label for="materials" class="flex items-center text-lg font-bold text-primary">
                                <i class="fas fa-file-pdf text-accent mr-3"></i>
                                Tài liệu PDF
                            </label>
                            <div class="bg-white rounded-2xl shadow-neumorph-inset border-2 border-dashed border-gray-300 p-12 text-center hover:border-accent transition-colors duration-300">
                                <input type="file"
                                       id="materials"
                                       name="materials[]"
                                       multiple
                                       accept=".pdf"
                                       class="hidden">
                                <label for="materials" class="cursor-pointer">
                                    <div class="space-y-6">
                                        <div class="w-20 h-20 mx-auto bg-accent bg-opacity-10 rounded-2xl flex items-center justify-center">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-accent"></i>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-xl font-bold text-primary">
                                                <span class="text-accent">Chọn file PDF</span> hoặc kéo thả vào đây
                                            </p>
                                            <p class="text-gray-600">Chỉ chấp nhận file PDF, tối đa 10MB mỗi file</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div id="selected-files" class="space-y-3"></div>
                            @error('materials.*')
                            <div class="flex items-center p-4 bg-danger bg-opacity-5 rounded-xl border border-danger border-opacity-20">
                                <i class="fas fa-exclamation-triangle text-danger mr-3"></i>
                                <span class="text-danger font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Option -->
                    <div class="space-y-6">
                        <h3 class="text-2xl font-bold text-primary flex items-center">
                            <i class="fas fa-cog text-accent mr-3"></i>
                            Cài đặt
                        </h3>


                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-6 pt-8 border-t border-gray-100">
                        <a href="{{ route('admin.courses.edit', $course) }}"
                           class="group inline-flex items-center px-10 py-5 text-lg font-bold text-gray-700 transition-all duration-300 rounded-2xl shadow-neumorph hover:shadow-neumorph-inset neumorph-button">
                            <i class="fas fa-times mr-3 group-hover:rotate-90 transition-transform duration-300"></i>
                            Hủy
                        </a>
                        <button type="submit"
                                class="group inline-flex items-center px-12 py-5 text-lg font-bold text-white bg-gradient-to-r from-accent to-danger rounded-2xl shadow-neumorph hover:shadow-neumorph-inset transition-all duration-300 transform hover:scale-105 hover:from-danger hover:to-accent">
                            <i class="fas fa-plus mr-3 group-hover:rotate-180 transition-transform duration-300"></i>
                            Tạo bài học
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TinyMCE CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>


    <script>
        // Initialize TinyMCE với config đầy đủ inline
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: 'file edit view insert format tools table help',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample',
                'emoticons', 'template', 'paste', 'textcolor', 'colorpicker'
            ],
            toolbar: [
                'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough',
                'forecolor backcolor | alignleft aligncenter alignright alignjustify',
                'bullist numlist outdent indent | removeformat | help',
                'link image media table | codesample emoticons | fullscreen preview code'
            ].join(' | '),

            block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6; Preformatted=pre',

            font_family_formats: [
                'System=-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'Arial=arial,helvetica,sans-serif',
                'Georgia=georgia,palatino',
                'Times New Roman=times new roman,times',
                'Courier New=courier new,courier,monospace'
            ].join('; '),

            font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt 48pt',

            // Image upload handler
            images_upload_handler: function (blobInfo, success, failure, progress) {
                const xhr = new XMLHttpRequest();
                const formData = new FormData();

                xhr.withCredentials = false;
                xhr.open('POST', '/admin/upload-image');

                xhr.upload.onprogress = function (e) {
                    if (progress && e.lengthComputable) {
                        progress(e.loaded / e.total * 100);
                    }
                };

                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location !== 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    } catch (e) {
                        failure('JSON Parse Error: ' + e.message);
                    }
                };

                xhr.onerror = function() {
                    failure('Network Error');
                };

                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.send(formData);
            },

            // Content styling
            content_style: `
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    font-size: 14px;
                    line-height: 1.6;
                    color: #333;
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 20px;
                }
                h1, h2, h3, h4, h5, h6 {
                    color: #2563eb;
                    margin-top: 1.5em;
                    margin-bottom: 0.5em;
                    font-weight: 600;
                }
                p { margin-bottom: 1em; }
                ul, ol { margin-bottom: 1em; padding-left: 2em; }
                blockquote {
                    border-left: 4px solid #e5e7eb;
                    margin: 1.5em 0;
                    padding-left: 1em;
                    color: #6b7280;
                    background-color: #f9fafb;
                    padding: 1em;
                    border-radius: 0.375rem;
                }
                code {
                    background-color: #f3f4f6;
                    padding: 0.2em 0.4em;
                    border-radius: 0.25em;
                    font-family: 'Courier New', monospace;
                    color: #ef4444;
                }
                table {
                    border-collapse: collapse;
                    width: 100%;
                    margin: 1em 0;
                    border: 1px solid #e5e7eb;
                }
                th, td {
                    border: 1px solid #e5e7eb;
                    padding: 0.75em 1em;
                    text-align: left;
                }
                th {
                    background-color: #f9fafb;
                    font-weight: 600;
                }
                img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 0.5em;
                    margin: 1em 0;
                }
            `,

            // Setup function
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },

            // Basic settings
            branding: false,
            promotion: false,
            resize: true,
            statusbar: true,
            elementpath: false,

            // Templates
            templates: [
                {
                    title: 'Bài học cơ bản',
                    description: 'Template cơ bản cho bài học',
                    content: `
                        <h2>📚 Mục tiêu học tập</h2>
                        <ul>
                            <li>Mục tiêu 1</li>
                            <li>Mục tiêu 2</li>
                            <li>Mục tiêu 3</li>
                        </ul>

                        <h2>Giới thiệu</h2>
                        <p>Mô tả ngắn gọn về chủ đề bài học...</p>

                        <h2>Nội dung chính</h2>

                        <h3>Phần 1: Khái niệm cơ bản</h3>
                        <p>Giải thích các khái niệm cơ bản...</p>

                        <blockquote>
                            <p><strong>💡 Ghi chú quan trọng:</strong> Điểm quan trọng cần lưu ý...</p>
                        </blockquote>

                        <h3>Phần 2: Ví dụ thực tế</h3>
                        <p>Ví dụ minh họa...</p>

                        <h2>Tóm tắt</h2>
                        <p>Tóm tắt những điểm chính đã học...</p>

                        <h2>Bài tập thực hành</h2>
                        <ol>
                            <li>Bài tập 1</li>
                            <li>Bài tập 2</li>
                            <li>Bài tập 3</li>
                        </ol>
                    `
                },
                {
                    title: 'Bài học lập trình',
                    description: 'Template cho bài học lập trình',
                    content: `
                        <h2>Giới thiệu</h2>
                        <p>Mô tả ngắn gọn về chủ đề lập trình...</p>

                        <h2>Cú pháp cơ bản</h2>
                        <pre><code class="language-javascript">// Ví dụ code JavaScript
function example() {
    console.log("Hello World!");
    return true;
}</code></pre>

                        <h2>Ví dụ thực tế</h2>
                        <p>Giải thích chi tiết về ví dụ:</p>

                        <pre><code class="language-javascript">// Code example với comment chi tiết
const students = [
    { name: "An", score: 85 },
    { name: "Bình", score: 92 }
];

// Tính điểm trung bình
const average = students.reduce((sum, student) => sum + student.score, 0) / students.length;
console.log("Điểm trung bình:", average);</code></pre>

                        <blockquote>
                            <p><strong>⚠️ Lưu ý:</strong> Những điểm cần chú ý khi viết code...</p>
                        </blockquote>

                        <h2>Thực hành</h2>
                        <p>Hãy thử viết code để:</p>
                        <ol>
                            <li>Tạo function tính tổng</li>
                            <li>Xử lý mảng dữ liệu</li>
                            <li>Kiểm tra kết quả</li>
                        </ol>
                    `
                }
            ],

            // Code sample languages
            codesample_languages: [
                { text: 'HTML/XML', value: 'markup' },
                { text: 'JavaScript', value: 'javascript' },
                { text: 'CSS', value: 'css' },
                { text: 'PHP', value: 'php' },
                { text: 'Python', value: 'python' },
                { text: 'Java', value: 'java' },
                { text: 'C++', value: 'cpp' },
                { text: 'SQL', value: 'sql' }
            ],

            // Thêm automatic uploads
            automatic_uploads: true,

            // File picker callback (alternative method)
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        fetch('/admin/upload-image', {
                            method: 'POST',
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.location) {
                                    callback(data.location, { alt: file.name });
                                } else {
                                    console.error('Upload failed:', data);
                                }
                            })
                            .catch(error => {
                                console.error('Upload error:', error);
                            });
                    };

                    input.click();
                }
            }
        });

        // Test route connectivity
        console.log('Testing upload route...');
        fetch('/admin/upload-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        }).then(response => {
            console.log('Route test response:', response.status);
        }).catch(error => {
            console.error('Route test failed:', error);
        });

        // Video Preview functionality
        const videoUrlInput = document.getElementById('video_url');
        const videoPreview = document.getElementById('video-preview');

        videoUrlInput.addEventListener('input', function() {
            const url = this.value.trim();

            if (!url) {
                videoPreview.innerHTML = '<p class="text-gray-500">Nhập URL video để xem trước</p>';
                return;
            }

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
