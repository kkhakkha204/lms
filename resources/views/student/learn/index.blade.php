<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentContent->title ?? 'Học tập' }} - {{ $course->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Custom styles for learning interface */
        .sidebar-scroll {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .content-area {
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .quiz-option {
            transition: all 0.2s ease;
        }

        .quiz-option:hover {
            background-color: #f3f4f6;
        }

        .quiz-option.selected {
            background-color: #dbeafe;
            border-color: #3b82f6;
        }

        .quiz-option.correct {
            background-color: #dcfce7;
            border-color: #16a34a;
        }

        .quiz-option.incorrect {
            background-color: #fee2e2;
            border-color: #dc2626;
        }
    </style>
</head>
<body class="bg-gray-100">
<!-- Header -->
<header class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
            <!-- Course Info -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('student.courses.show', $course->slug) }}"
                   class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 truncate max-w-md">
                        {{ $course->title }}
                    </h1>
                    <div class="text-sm text-gray-500">
                        {{ $currentContent->title ?? 'Chọn nội dung để học' }}
                    </div>
                </div>
            </div>

            <!-- Progress -->
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-600">
                    Tiến độ: <span class="font-semibold">{{ $completionPercentage ?? 0 }}%</span>
                </div>
                <div class="w-32 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                         style="width: {{ $completionPercentage ?? 0 }}%"></div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-2">
                    <img src="{{ auth()->user()->avatar_url }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-8 h-8 rounded-full">
                    <span class="text-sm text-gray-700 hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="flex h-screen">
    <!-- Sidebar - Curriculum -->
    <div class="w-80 bg-white shadow-sm border-r flex flex-col">
        <div class="p-4 border-b">
            <h2 class="font-semibold text-gray-900">Nội dung khóa học</h2>
        </div>

        <div class="flex-1 sidebar-scroll">
            @foreach($course->sections as $section)
                <div class="border-b">
                    <!-- Section Header -->
                    <div class="p-4 bg-gray-50">
                        <h3 class="font-medium text-gray-900">{{ $section->title }}</h3>
                        @if($section->description)
                            <p class="text-sm text-gray-600 mt-1">{{ $section->description }}</p>
                        @endif
                    </div>

                    <!-- Section Content -->
                    <div class="space-y-1">
                        <!-- Lessons -->
                        @foreach($section->lessons as $lesson)
                            @php
                                $lessonProgress = $progress['lesson_' . $lesson->id] ?? null;
                                $isCompleted = $lessonProgress && $lessonProgress->lesson_completed;
                                $isActive = isset($currentContent) && $currentContent && get_class($currentContent) === 'App\Models\Lesson' && $currentContent->id === $lesson->id;
                            @endphp

                            <a href="{{ route('learning.lesson', [$course->slug, $lesson->slug]) }}"
                               class="flex items-center p-3 hover:bg-gray-50 {{ $isActive ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                                <div class="flex-shrink-0 mr-3">
                                    @if($isCompleted)
                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                            <i class="fas fa-play text-white text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $lesson->title }}</p>
                                    @if($lesson->video_duration)
                                        <p class="text-xs text-gray-500">{{ $lesson->video_duration }}</p>
                                    @endif
                                </div>
                                @if($lesson->is_preview)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Xem trước</span>
                                @endif
                            </a>
                        @endforeach

                        <!-- Quizzes -->
                        @foreach($section->quizzes as $quiz)
                            @php
                                $quizProgress = $progress['quiz_' . $quiz->id] ?? null;
                                $isPassed = $quizProgress && $quizProgress->quiz_passed;
                                $isActive = isset($currentContent) && $currentContent && get_class($currentContent) === 'App\Models\Quiz' && $currentContent->id === $quiz->id;
                                $quizSlug = str_replace(' ', '-', strtolower($quiz->title));
                            @endphp

                            <a href="{{ route('learning.quiz', [$course->slug, $quizSlug]) }}"
                               class="flex items-center p-3 hover:bg-gray-50 {{ $isActive ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                                <div class="flex-shrink-0 mr-3">
                                    @if($isPassed)
                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 bg-orange-400 rounded-full flex items-center justify-center">
                                            <i class="fas fa-question text-white text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $quiz->title }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $quiz->questions->count() }} câu hỏi
                                        @if($quizProgress)
                                            - Điểm: {{ number_format($quizProgress->quiz_score, 1) }}%
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <div class="flex-1 content-area">
            @if(isset($currentContent) && $currentContent)
                @if(get_class($currentContent) === 'App\Models\Lesson')
                    @include('student.learn.lesson', ['lesson' => $currentContent])
                @elseif(get_class($currentContent) === 'App\Models\Quiz')
                    @include('student.learn.quiz', ['quiz' => $currentContent])
                @endif
            @else
                <!-- Welcome Screen -->
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-graduation-cap text-blue-600 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Chào mừng đến với khóa học!</h2>
                        <p class="text-gray-600 mb-6">Chọn một bài học từ danh sách bên trái để bắt đầu.</p>
                        <div class="text-sm text-gray-500">
                            Tiến độ hiện tại: {{ $completionPercentage ?? 0 }}% hoàn thành
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Global JavaScript -->
<script>
    // CSRF token for AJAX requests
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Course data
    window.courseData = {
        id: {{ $course->id }},
        slug: '{{ $course->slug }}'
    };
</script>
</body>
</html>
