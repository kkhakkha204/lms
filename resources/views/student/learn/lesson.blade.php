<div class="h-full flex flex-col" x-data="lessonViewer()">
    <!-- Video Section -->
    @if($lesson->video_url)
        @php
            $isYoutube = str_contains($lesson->video_url, 'youtube.com') || str_contains($lesson->video_url, 'youtu.be');
        @endphp

        @if($isYoutube)
            <!-- YouTube Video Container -->
            <div class="bg-black relative w-full" style="padding-bottom: 56.25%; height: 0;">
                @php
                    // Extract video ID from various YouTube URL formats
                    $videoId = '';
                    $url = $lesson->video_url;

                    if (str_contains($url, 'youtu.be/')) {
                        // Format: https://youtu.be/VIDEO_ID
                        $parts = explode('youtu.be/', $url);
                        if (count($parts) > 1) {
                            $videoId = explode('?', $parts[1])[0];
                        }
                    } elseif (str_contains($url, 'youtube.com/watch?v=')) {
                        // Format: https://youtube.com/watch?v=VIDEO_ID
                        parse_str(parse_url($url, PHP_URL_QUERY), $query);
                        $videoId = $query['v'] ?? '';
                    } elseif (str_contains($url, 'youtube.com/embed/')) {
                        // Format: https://youtube.com/embed/VIDEO_ID
                        $parts = explode('youtube.com/embed/', $url);
                        if (count($parts) > 1) {
                            $videoId = explode('?', $parts[1])[0];
                        }
                    }

                    // Clean video ID
                    $videoId = preg_replace('/[^a-zA-Z0-9_-]/', '', explode('&', $videoId)[0]);
                @endphp

                @if($videoId)
                    <iframe
                        id="youtube-player"
                        src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&playsinline=1"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                        class="absolute top-0 left-0 w-full h-full"
                        style="border: none;">
                    </iframe>

                    <!-- Fallback link -->
                    <div class="absolute bottom-4 right-4 z-10">
                        <a href="https://www.youtube.com/watch?v={{ $videoId }}"
                           target="_blank"
                           class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                            <i class="fab fa-youtube mr-1"></i>
                            Xem trên YouTube
                        </a>
                    </div>
                @else
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center text-white bg-red-600">
                        <div class="text-center p-4">
                            <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                            <p class="text-lg">Không thể phân tích video YouTube</p>
                            <p class="text-sm mt-2 opacity-75">URL: {{ $lesson->video_url }}</p>
                            <a href="{{ $lesson->video_url }}" target="_blank"
                               class="inline-block mt-4 bg-white text-red-600 px-4 py-2 rounded hover:bg-gray-100">
                                Xem video gốc
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Local Video -->
            <div class="bg-black">
                <div class="video-container">
                    <video
                        id="lesson-video"
                        controls
                        class="w-full h-full"
                        @loadedmetadata="initializeVideo"
                        @timeupdate="updateProgress"
                        @ended="markAsCompleted">
                        <source src="{{ asset('storage/' . $lesson->video_url) }}" type="video/mp4">
                        <div class="w-full h-full flex items-center justify-center text-white">
                            <p>Trình duyệt của bạn không hỗ trợ video này.</p>
                        </div>
                    </video>
                </div>
            </div>
        @endif
    @else
        <!-- No Video -->
        <div class="bg-gray-100 p-8 text-center">
            <i class="fas fa-video text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600">Bài học này không có video</p>
        </div>
    @endif

    <!-- Content Section -->
    <div class="flex-1 overflow-y-auto">
        <div class="max-w-4xl mx-auto p-6">
            <!-- Lesson Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $lesson->title }}</h1>

                @if($lesson->summary)
                    <p class="text-lg text-gray-600 mb-4">{{ $lesson->summary }}</p>
                @endif

                <!-- Lesson Meta -->
                <div class="flex items-center space-x-6 text-sm text-gray-500 mb-4">
                    @if($lesson->video_duration)
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $lesson->video_duration }}
                        </span>
                    @endif

                    @if($lesson->video_size)
                        <span class="flex items-center">
                            <i class="fas fa-file-video mr-1"></i>
                            {{ number_format($lesson->video_size / 1024 / 1024, 1) }} MB
                        </span>
                    @endif

                    <span class="flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        Bài {{ $lesson->sort_order }}
                    </span>
                </div>

                <!-- Progress Indicator -->
                <div class="bg-gray-200 rounded-full h-2 mb-4">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                         :style="`width: ${videoProgress}%`"></div>
                </div>

                <div class="flex justify-between text-sm text-gray-600">
                    <span>Tiến độ xem: <span x-text="videoProgress"></span>%</span>
                    <span x-show="isCompleted" class="text-green-600 font-medium">
                        <i class="fas fa-check mr-1"></i>Đã hoàn thành
                    </span>
                </div>
            </div>

            <!-- Lesson Content với TinyMCE rich content -->
            @if($lesson->content)
                <div class="mb-8">
                    <div class="bg-white rounded-lg border overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-book-open mr-2 text-blue-600"></i>
                                Nội dung bài học
                            </h2>
                        </div>
                        <div class="p-6">
                            <!-- Rich content display với styling tương tự TinyMCE -->
                            <div class="lesson-rich-content prose prose-lg max-w-none">
                                {!! $lesson->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lesson Materials -->
            @if($lesson->materials && $lesson->materials->count() > 0)
                <div class="bg-white rounded-lg border mb-8">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-download mr-2 text-green-600"></i>
                            Tài liệu đính kèm
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($lesson->materials as $material)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-file-pdf text-red-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $material->title }}</h3>
                                            <p class="text-sm text-gray-500">
                                                PDF • {{ number_format($material->file_size / 1024 / 1024, 1) }} MB
                                                @if($material->download_count > 0)
                                                    • {{ number_format($material->download_count) }} lượt tải
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('learning.download-material', $material->id) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                        <i class="fas fa-download mr-2"></i>
                                        Tải xuống
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Complete Lesson Button -->
            <div class="text-center">
                <button @click="markAsCompleted"
                        :disabled="isCompleted"
                        :class="isCompleted ? 'bg-green-600 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                        class="px-8 py-3 text-white font-semibold rounded-lg transition-colors text-lg">
                    <i :class="isCompleted ? 'fas fa-check' : 'fas fa-check-circle'" class="mr-2"></i>
                    <span x-text="isCompleted ? 'Đã hoàn thành' : 'Đánh dấu hoàn thành'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS cho rich content display -->
<style>
    .lesson-rich-content {
        line-height: 1.7;
        color: #374151;
    }

    .lesson-rich-content h1,
    .lesson-rich-content h2,
    .lesson-rich-content h3,
    .lesson-rich-content h4,
    .lesson-rich-content h5,
    .lesson-rich-content h6 {
        color: #2563eb;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        font-weight: 600;
        line-height: 1.3;
    }

    .lesson-rich-content h1 { font-size: 2.25em; }
    .lesson-rich-content h2 { font-size: 1.875em; }
    .lesson-rich-content h3 { font-size: 1.5em; }
    .lesson-rich-content h4 { font-size: 1.25em; }
    .lesson-rich-content h5 { font-size: 1.125em; }
    .lesson-rich-content h6 { font-size: 1em; }

    .lesson-rich-content p {
        margin-bottom: 1em;
        line-height: 1.7;
    }

    .lesson-rich-content ul,
    .lesson-rich-content ol {
        margin-bottom: 1em;
        padding-left: 2em;
    }

    .lesson-rich-content li {
        margin-bottom: 0.5em;
        line-height: 1.6;
    }

    .lesson-rich-content blockquote {
        border-left: 4px solid #3b82f6;
        margin: 1.5em 0;
        padding: 1em 1.5em;
        background-color: #eff6ff;
        border-radius: 0.5rem;
        color: #1e40af;
        font-style: italic;
    }

    .lesson-rich-content code {
        background-color: #f3f4f6;
        padding: 0.25em 0.5em;
        border-radius: 0.375rem;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Courier New', monospace;
        font-size: 0.9em;
        color: #dc2626;
        font-weight: 500;
    }

    .lesson-rich-content pre {
        background-color: #1f2937;
        color: #f9fafb;
        padding: 1.5em;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 1.5em 0;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Courier New', monospace;
        line-height: 1.5;
    }

    .lesson-rich-content pre code {
        background: none;
        padding: 0;
        color: inherit;
        font-size: inherit;
        border-radius: 0;
    }

    .lesson-rich-content table {
        border-collapse: collapse;
        width: 100%;
        margin: 1.5em 0;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .lesson-rich-content th,
    .lesson-rich-content td {
        border: 1px solid #e5e7eb;
        padding: 0.75em 1em;
        text-align: left;
    }

    .lesson-rich-content th {
        background-color: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .lesson-rich-content tr:nth-child(even) {
        background-color: #f9fafb;
    }

    .lesson-rich-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.5em 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .lesson-rich-content a {
        color: #2563eb;
        text-decoration: underline;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .lesson-rich-content a:hover {
        color: #1d4ed8;
    }

    .lesson-rich-content strong {
        font-weight: 600;
        color: #111827;
    }

    .lesson-rich-content em {
        font-style: italic;
    }

    .lesson-rich-content hr {
        border: none;
        border-top: 2px solid #e5e7eb;
        margin: 2em 0;
    }

    /* Highlight class nếu có */
    .lesson-rich-content .highlight {
        background-color: #fef3c7;
        padding: 0.25em 0.5em;
        border-radius: 0.375rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .lesson-rich-content {
            font-size: 14px;
        }

        .lesson-rich-content h1 { font-size: 1.875em; }
        .lesson-rich-content h2 { font-size: 1.5em; }
        .lesson-rich-content h3 { font-size: 1.25em; }

        .lesson-rich-content pre {
            padding: 1em;
            font-size: 0.9em;
        }

        .lesson-rich-content table {
            font-size: 0.9em;
        }

        .lesson-rich-content th,
        .lesson-rich-content td {
            padding: 0.5em 0.75em;
        }
    }
</style>

<script>
    function lessonViewer() {
        return {
            videoProgress: 0,
            isCompleted: {{ $progress['lesson_' . $lesson->id]->lesson_completed ?? 'false' }},
            watchedSeconds: {{ $progress['lesson_' . $lesson->id]->video_watched_seconds ?? 0 }},
            video: null,
            progressTimer: null,
            isYouTube: {{ (str_contains($lesson->video_url ?? '', 'youtube') || str_contains($lesson->video_url ?? '', 'youtu.be')) ? 'true' : 'false' }},

            init() {
                console.log('Lesson viewer initialized');
                console.log('Is YouTube:', this.isYouTube);
                console.log('Video URL:', '{{ $lesson->video_url ?? "No video" }}');
            },

            initializeVideo() {
                if (this.isYouTube) {
                    // YouTube videos - tracking is limited due to iframe restrictions
                    console.log('YouTube video detected - limited progress tracking');
                    return;
                }

                this.video = document.getElementById('lesson-video');
                if (this.video && this.watchedSeconds > 0) {
                    this.video.currentTime = this.watchedSeconds;
                    console.log('Resumed video at:', this.watchedSeconds, 'seconds');
                }
            },

            updateProgress() {
                if (!this.video || this.isYouTube) return;

                const currentTime = this.video.currentTime;
                const duration = this.video.duration;

                if (duration > 0) {
                    this.videoProgress = Math.round((currentTime / duration) * 100);
                    this.watchedSeconds = Math.floor(currentTime);

                    // Tự động save progress mỗi 10 giây
                    if (this.progressTimer) clearTimeout(this.progressTimer);
                    this.progressTimer = setTimeout(() => {
                        this.saveProgress(false);
                    }, 10000);
                }
            },

            markAsCompleted() {
                this.isCompleted = true;
                if (!this.isYouTube) {
                    this.videoProgress = 100;
                }
                this.saveProgress(true);
            },

            saveProgress(completed = false) {
                console.log('Saving progress:', {
                    completed,
                    watchedSeconds: this.watchedSeconds,
                    videoProgress: this.videoProgress
                });

                fetch('/api/learning/video-progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken
                    },
                    body: JSON.stringify({
                        lesson_id: {{ $lesson->id }},
                        watched_seconds: this.watchedSeconds,
                        completed: completed || this.isCompleted
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('API Response:', data);

                        if (data.success) {
                            console.log('Progress saved successfully');
                            console.log('Completion percentage:', data.completion_percentage);
                            console.log('Course completed:', data.course_completed);

                            if (completed && data.course_completed) {
                                console.log('Course completed! Redirecting to summary...');
                                this.showCompletionNotification();

                                setTimeout(() => {
                                    window.location.href = `/learn/{{ $lesson->course->slug }}/summary`;
                                }, 3000);
                            } else if (completed) {
                                console.log('Lesson completed but course not finished yet');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error saving progress:', error);
                    });
            },

            showCompletionNotification() {
                const notification = document.createElement('div');
                notification.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                notification.innerHTML = `
                <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">🎉 Chúc mừng!</h3>
                    <p class="text-gray-600 mb-4">Bạn đã hoàn thành khóa học!</p>
                    <p class="text-sm text-gray-500">Đang chuyển đến trang tổng kết...</p>
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            `;
                document.body.appendChild(notification);
            }
        }
    }
</script>
