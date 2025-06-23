<div class="min-h-screen bg-gradient-to-br from-[#1c1c1c] via-[#2a2a2a] to-[#1c1c1c]" x-data="lessonViewer()">
    <!-- Custom Video Player Section -->
    @if($lesson->video_url)
        @php
            $isYoutube = str_contains($lesson->video_url, 'youtube.com') || str_contains($lesson->video_url, 'youtu.be');
        @endphp

        <div class="relative">
            <!-- Video Container with Modern Design -->
            <div class="relative bg-black shadow-2xl">
                <!-- Video Player -->
                <div class="relative w-full aspect-video bg-black overflow-hidden">
                    @if($isYoutube)
                        @php
                            // Extract video ID from various YouTube URL formats
                            $videoId = '';
                            $url = $lesson->video_url;

                            if (str_contains($url, 'youtu.be/')) {
                                $parts = explode('youtu.be/', $url);
                                if (count($parts) > 1) {
                                    $videoId = explode('?', $parts[1])[0];
                                }
                            } elseif (str_contains($url, 'youtube.com/watch?v=')) {
                                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                $videoId = $query['v'] ?? '';
                            } elseif (str_contains($url, 'youtube.com/embed/')) {
                                $parts = explode('youtube.com/embed/', $url);
                                if (count($parts) > 1) {
                                    $videoId = explode('?', $parts[1])[0];
                                }
                            }

                            $videoId = preg_replace('/[^a-zA-Z0-9_-]/', '', explode('&', $videoId)[0]);
                        @endphp

                        @if($videoId)
                            <!-- Custom YouTube Player -->
                            <div class="relative w-full h-full">
                                <iframe
                                    id="youtube-player"
                                    src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&rel=0&modestbranding=1&playsinline=1&controls=0&showinfo=0&fs=0&cc_load_policy=0&iv_load_policy=3&autohide=1&disablekb=1"
                                    title="Lesson Video"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    class="w-full h-full"
                                    style="border: none;">
                                </iframe>

                                <!-- Simple Controls Overlay -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-6">
                                    <div class="flex items-center justify-between text-white">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-2 bg-[#ed292a]/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                                <div class="w-2 h-2 bg-[#ed292a] rounded-full animate-pulse"></div>
                                                <span class="text-sm font-medium">Đang phát</span>
                                            </div>
                                            @if($lesson->video_duration)
                                                <span class="text-sm opacity-80">{{ $lesson->video_duration }}</span>
                                            @endif
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <button onclick="openYouTubeFullscreen('{{ $videoId }}')"
                                                    class="p-2 hover:bg-white/20 rounded-full transition-colors"
                                                    title="Xem toàn màn hình">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zM16 4a1 1 0 00-1-1h-4a1 1 0 000 2h1.586l-2.293 2.293a1 1 0 001.414 1.414L13 6.414V8a1 1 0 002 0V4zM3 16a1 1 0 001 1h4a1 1 0 000-2H6.414l2.293-2.293a1 1 0 00-1.414-1.414L5 13.586V12a1 1 0 00-2 0v4zM16 16a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L13 13.586V12a1 1 0 012 0v4z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#7e0202] to-[#ed292a]">
                                <div class="text-center p-8">
                                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">Video không thể tải</h3>
                                    <p class="text-white/80 mb-4">URL video YouTube không hợp lệ</p>
                                    <a href="{{ $lesson->video_url }}" target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-white text-[#ed292a] font-semibold rounded-lg hover:bg-white/90 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                        </svg>
                                        Xem video gốc
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Local Video Player -->
                        <div class="relative w-full h-full bg-black">
                            <video
                                id="lesson-video"
                                controls
                                class="w-full h-full object-contain"
                                @loadedmetadata="initializeVideo"
                                @timeupdate="updateProgress"
                                @ended="markAsCompleted"
                                controlsList="nodownload"
                                style="background: linear-gradient(135deg, #1c1c1c 0%, #2a2a2a 100%);">
                                <source src="{{ asset('storage/' . $lesson->video_url) }}" type="video/mp4">
                                <div class="w-full h-full flex items-center justify-center text-white">
                                    <p>Trình duyệt của bạn không hỗ trợ video này.</p>
                                </div>
                            </video>
                        </div>
                    @endif
                </div>

                <!-- Progress Bar -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/30">
                    <div class="h-full bg-gradient-to-r from-[#7e0202] to-[#ed292a] transition-all duration-300 ease-out"
                         :style="`width: ${videoProgress}%`"></div>
                </div>
            </div>

            <!-- Video Info Bar -->
            <div class="bg-[#1c1c1c] border-b border-[#ed292a]/20">
                <div class="max-w-7xl mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full" :class="isCompleted ? 'bg-green-500' : 'bg-[#ed292a]'"></div>
                                <span class="text-white font-medium">Bài {{ $lesson->sort_order }}</span>
                            </div>
                            <div class="h-4 w-px bg-white/20"></div>
                            <span class="text-white/80 text-sm">Tiến độ: <span x-text="videoProgress" class="font-bold text-[#ed292a]"></span>%</span>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if($lesson->video_duration)
                                <div class="flex items-center space-x-2 text-white/60">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                    </svg>
                                    <span class="text-sm">{{ $lesson->video_duration }}</span>
                                </div>
                            @endif

                            <button @click="markAsCompleted"
                                    :disabled="isCompleted"
                                    :class="isCompleted ? 'bg-green-600 cursor-not-allowed' : 'bg-gradient-to-r from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202]'"
                                    class="px-6 py-2 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105">
                                <span x-show="!isCompleted" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Hoàn thành
                                </span>
                                <span x-show="isCompleted" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Đã hoàn thành
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Video State -->
        <div class="bg-gradient-to-br from-[#1c1c1c] to-[#2a2a2a] border-b border-[#ed292a]/20">
            <div class="max-w-7xl mx-auto px-6 py-12 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-[#7e0202] to-[#ed292a] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Bài học không có video</h3>
                <p class="text-white/60">Hãy tập trung vào nội dung bài học bên dưới</p>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Lesson Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-[#1c1c1c] to-[#2a2a2a] px-8 py-6">
                    <h1 class="text-3xl font-bold text-white mb-3">{{ $lesson->title }}</h1>
                    @if($lesson->summary)
                        <p class="text-white/80 text-lg leading-relaxed">{{ $lesson->summary }}</p>
                    @endif

                    <!-- Lesson Meta Info -->
                    <div class="flex items-center space-x-6 mt-4 text-sm text-white/60">
                        @if($lesson->video_duration)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                </svg>
                                <span>{{ $lesson->video_duration }}</span>
                            </div>
                        @endif

                        @if($lesson->video_size)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                </svg>
                                <span>{{ number_format($lesson->video_size / 1024 / 1024, 1) }} MB</span>
                            </div>
                        @endif

                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Bài học số {{ $lesson->sort_order }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lesson Content -->
        @if($lesson->content)
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] px-8 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            Nội dung bài học
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="lesson-rich-content prose prose-lg max-w-none">
                            {!! $lesson->content !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Lesson Materials -->
        @if($lesson->materials && $lesson->materials->count() > 0)
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-[#1c1c1c] to-[#2a2a2a] px-8 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                            </svg>
                            Tài liệu đính kèm
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="grid gap-4">
                            @foreach($lesson->materials as $material)
                                <div class="group bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 hover:from-[#ed292a]/5 hover:to-[#7e0202]/5 transition-all duration-300 border border-gray-200 hover:border-[#ed292a]/30">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-br from-[#7e0202] to-[#ed292a] rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 3a2 2 0 00-2 2v1.5h12V5a2 2 0 00-2-2H4z"/>
                                                    <path d="M2 8.5V15a2 2 0 002 2h8a2 2 0 002-2V8.5H2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-lg group-hover:text-[#ed292a] transition-colors">{{ $material->title }}</h3>
                                                <div class="flex items-center space-x-3 text-sm text-gray-500 mt-1">
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">PDF</span>
                                                    <span>{{ number_format($material->file_size / 1024 / 1024, 1) }} MB</span>
                                                    @if($material->download_count > 0)
                                                        <span>•</span>
                                                        <span>{{ number_format($material->download_count) }} lượt tải</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('learning.download-material', $material->id) }}"
                                           class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] text-white px-6 py-3 rounded-xl hover:from-[#ed292a] hover:to-[#7e0202] transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 font-semibold shadow-lg">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                                            </svg>
                                            <span>Tải xuống</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Completion Section -->
        <div class="text-center">
            <div class="bg-gradient-to-r from-[#1c1c1c] via-[#2a2a2a] to-[#1c1c1c] rounded-2xl p-8 shadow-2xl">
                <div x-show="!isCompleted" class="mb-6">
                    <h3 class="text-2xl font-bold text-white mb-2">Hoàn thành bài học này</h3>
                    <p class="text-white/70">Nhấn nút bên dưới để đánh dấu bài học đã hoàn thành</p>
                </div>

                <div x-show="isCompleted" class="mb-6">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">🎉 Tuyệt vời!</h3>
                    <p class="text-white/70">Bạn đã hoàn thành bài học này</p>
                </div>

                <button @click="markAsCompleted"
                        :disabled="isCompleted"
                        :class="isCompleted ? 'bg-green-600 cursor-not-allowed' : 'bg-gradient-to-r from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] transform hover:scale-105'"
                        class="px-8 py-4 text-white font-bold rounded-xl transition-all duration-300 text-lg shadow-2xl">
                    <span x-show="!isCompleted" class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                        Đánh dấu hoàn thành
                    </span>
                    <span x-show="isCompleted" class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                        Đã hoàn thành
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced CSS Styles -->
<style>
    /* Rich Content Styling */
    .lesson-rich-content {
        line-height: 1.8;
        color: #374151;
        font-size: 16px;
    }

    .lesson-rich-content h1,
    .lesson-rich-content h2,
    .lesson-rich-content h3,
    .lesson-rich-content h4,
    .lesson-rich-content h5,
    .lesson-rich-content h6 {
        color: #1c1c1c;
        margin-top: 2em;
        margin-bottom: 1em;
        font-weight: 700;
        line-height: 1.3;
    }

    .lesson-rich-content h1 {
        font-size: 2.5em;
        background: linear-gradient(135deg, #7e0202, #ed292a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .lesson-rich-content h2 {
        font-size: 2em;
        color: #7e0202;
    }
    .lesson-rich-content h3 {
        font-size: 1.75em;
        color: #ed292a;
    }
    .lesson-rich-content h4 { font-size: 1.5em; }
    .lesson-rich-content h5 { font-size: 1.25em; }
    .lesson-rich-content h6 { font-size: 1.125em; }

    .lesson-rich-content p {
        margin-bottom: 1.5em;
        line-height: 1.8;
        text-align: justify;
    }

    .lesson-rich-content ul,
    .lesson-rich-content ol {
        margin-bottom: 1.5em;
        padding-left: 2em;
    }

    .lesson-rich-content li {
        margin-bottom: 0.75em;
        line-height: 1.7;
    }

    .lesson-rich-content blockquote {
        border-left: 6px solid #ed292a;
        margin: 2em 0;
        padding: 1.5em 2em;
        background: linear-gradient(135deg, #ed292a08, #7e020208);
        border-radius: 0 12px 12px 0;
        color: #1c1c1c;
        font-style: italic;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(237, 41, 42, 0.1);
    }

    .lesson-rich-content code {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        padding: 0.375em 0.75em;
        border-radius: 8px;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Courier New', monospace;
        font-size: 0.9em;
        color: #7e0202;
        font-weight: 600;
        border: 1px solid #ed292a20;
    }

    .lesson-rich-content pre {
        background: linear-gradient(135deg, #1c1c1c, #2a2a2a);
        color: #f9fafb;
        padding: 2em;
        border-radius: 16px;
        overflow-x: auto;
        margin: 2em 0;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', 'Courier New', monospace;
        line-height: 1.6;
        border: 1px solid #ed292a30;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .lesson-rich-content table {
        border-collapse: collapse;
        width: 100%;
        margin: 2em 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .lesson-rich-content th,
    .lesson-rich-content td {
        border: 1px solid #e5e7eb;
        padding: 1em 1.5em;
        text-align: left;
    }

    .lesson-rich-content th {
        background: linear-gradient(135deg, #1c1c1c, #2a2a2a);
        font-weight: 700;
        color: white;
    }

    .lesson-rich-content tr:nth-child(even) {
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
    }

    .lesson-rich-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 2em 0;
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    }

    .lesson-rich-content a {
        color: #ed292a;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .lesson-rich-content a:hover {
        color: #7e0202;
    }

    .lesson-rich-content strong {
        font-weight: 700;
        color: #1c1c1c;
    }

    .lesson-rich-content em {
        font-style: italic;
        color: #7e0202;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .lesson-rich-content {
            font-size: 14px;
        }

        .lesson-rich-content h1 { font-size: 2em; }
        .lesson-rich-content h2 { font-size: 1.75em; }
        .lesson-rich-content h3 { font-size: 1.5em; }
    }
</style>

<script>
    function lessonViewer() {
        return {
            videoProgress: {{ $progress['lesson_' . $lesson->id]->video_watched_seconds ?? 0 }} > 0 ? Math.round(({{ $progress['lesson_' . $lesson->id]->video_watched_seconds ?? 0 }} / 60) * 100) : 0,
            isCompleted: {{ $progress['lesson_' . $lesson->id]->lesson_completed ?? 'false' }},
            watchedSeconds: {{ $progress['lesson_' . $lesson->id]->video_watched_seconds ?? 0 }},
            video: null,
            progressTimer: null,
            isYouTube: {{ (str_contains($lesson->video_url ?? '', 'youtube') || str_contains($lesson->video_url ?? '', 'youtu.be')) ? 'true' : 'false' }},

            init() {
                console.log('Lesson viewer initialized');

                if (!this.isYouTube) {
                    this.$nextTick(() => {
                        this.initializeVideo();
                    });
                }
            },

            initializeVideo() {
                if (this.isYouTube) {
                    console.log('YouTube video detected');
                    return;
                }

                this.video = document.getElementById('lesson-video');
                if (this.video && this.watchedSeconds > 0) {
                    this.video.currentTime = this.watchedSeconds;
                    console.log('Video resumed at:', this.watchedSeconds, 'seconds');
                }
            },

            updateProgress() {
                if (!this.video || this.isYouTube) return;

                const currentTime = this.video.currentTime;
                const duration = this.video.duration;

                if (duration > 0) {
                    this.videoProgress = Math.round((currentTime / duration) * 100);
                    this.watchedSeconds = Math.floor(currentTime);

                    if (this.progressTimer) clearTimeout(this.progressTimer);
                    this.progressTimer = setTimeout(() => {
                        this.saveProgress(false);
                    }, 15000);

                    if (this.videoProgress >= 95 && !this.isCompleted) {
                        this.markAsCompleted();
                    }
                }
            },

            markAsCompleted() {
                if (this.isCompleted) return;

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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
                    },
                    body: JSON.stringify({
                        lesson_id: {{ $lesson->id }},
                        watched_seconds: this.watchedSeconds,
                        completed: completed || this.isCompleted
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Progress saved:', data);

                        if (data.success) {
                            if (completed && data.course_completed) {
                                this.showCompletionNotification();
                                setTimeout(() => {
                                    window.location.href = `/learn/{{ $lesson->course->slug }}/summary`;
                                }, 3000);
                            } else if (completed) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error saving progress:', error);
                    });
            },

            showCompletionNotification() {
                const notification = document.createElement('div');
                notification.className = 'fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50';
                notification.innerHTML = `
                    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">🎉 Xuất sắc!</h3>
                        <p class="text-gray-600 mb-6 text-lg">Bạn đã hoàn thành toàn bộ khóa học!</p>
                        <div class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] text-white px-6 py-3 rounded-xl inline-block">
                            <p class="font-semibold">Đang chuyển đến trang tổng kết...</p>
                        </div>
                    </div>
                `;
                document.body.appendChild(notification);
            }
        }
    }

    // YouTube fullscreen function
    function openYouTubeFullscreen(videoId) {
        const fullscreenUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&fs=1&rel=0&modestbranding=1`;
        const newWindow = window.open(fullscreenUrl, '_blank', 'width=1280,height=720,scrollbars=no,resizable=yes');
        if (newWindow) {
            newWindow.focus();
        }
    }

    // Add CSRF token to window if available
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            window.csrfToken = csrfToken.getAttribute('content');
        }
    });
</script>
