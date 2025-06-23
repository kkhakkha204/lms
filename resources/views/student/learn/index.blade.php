<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentContent->title ?? 'Học tập' }} - {{ $course->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #1c1c1c;
            --primary-red: #ed292a;
            --primary-red-dark: #7e0202;
            --white: #ffffff;
            --gray-50: #fafafa;
            --gray-100: #f5f5f5;
            --gray-200: #e5e5e5;
            --gray-300: #d4d4d4;
            --gray-400: #a3a3a3;
            --gray-500: #737373;
            --gray-600: #525252;
            --gray-700: #404040;
            --gray-800: #262626;
            --gray-900: #171717;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            min-height: 100vh;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Header styles */
        .header-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(237, 41, 42, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Sidebar styles */
        .sidebar {
            background: var(--white);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--gray-200);
        }

        .sidebar-scroll {
            max-height: calc(100vh - 180px);
            overflow-y: auto;
        }

        /* Section header styling */
        .section-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--gray-800) 100%);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .section-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(237, 41, 42, 0.1));
            pointer-events: none;
        }

        /* Content item styles */
        .content-item {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
        }

        .content-item:hover {
            background: linear-gradient(90deg, var(--gray-50), var(--white));
            border-left-color: var(--primary-red);
            transform: translateX(2px);
            box-shadow: 0 4px 12px rgba(237, 41, 42, 0.1);
        }

        .content-item.active {
            background: linear-gradient(90deg, rgba(237, 41, 42, 0.05), rgba(237, 41, 42, 0.02));
            border-left-color: var(--primary-red);
            box-shadow: inset 0 0 0 1px rgba(237, 41, 42, 0.1);
        }

        .content-item.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: var(--primary-red);
            border-radius: 2px 0 0 2px;
        }

        /* Progress indicators */
        .progress-indicator {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .progress-indicator.completed {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .progress-indicator.pending {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
            box-shadow: 0 2px 8px rgba(237, 41, 42, 0.3);
        }

        .progress-indicator.quiz {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        /* Progress bar styling */
        .progress-bar-container {
            background: var(--gray-200);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary-red), var(--primary-red-dark));
            height: 6px;
            border-radius: 10px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }

        /* Content area styles */
        .content-area {
            height: calc(100vh - 80px);
            overflow-y: auto;
            background: var(--white);
            border-radius: 12px 0 0 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Video container */
        .video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Quiz styles */
        .quiz-option {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .quiz-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent, rgba(237, 41, 42, 0.02));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .quiz-option:hover {
            border-color: var(--primary-red);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(237, 41, 42, 0.15);
        }

        .quiz-option:hover::before {
            opacity: 1;
        }

        .quiz-option.selected {
            border-color: var(--primary-red);
            background: rgba(237, 41, 42, 0.05);
            box-shadow: 0 4px 16px rgba(237, 41, 42, 0.2);
        }

        .quiz-option.correct {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
        }

        .quiz-option.incorrect {
            border-color: var(--primary-red);
            background: rgba(237, 41, 42, 0.05);
            box-shadow: 0 4px 16px rgba(237, 41, 42, 0.2);
        }

        /* Welcome screen */
        .welcome-screen {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
        }

        .welcome-icon {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
            box-shadow: 0 8px 32px rgba(237, 41, 42, 0.3);
        }

        /* Buttons and interactive elements */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(237, 41, 42, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(237, 41, 42, 0.4);
        }

        /* Tags and badges */
        .badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: var(--white);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Avatar styling */
        .avatar {
            border: 2px solid var(--primary-red);
            box-shadow: 0 2px 8px rgba(237, 41, 42, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -320px;
                top: 80px;
                bottom: 0;
                width: 320px;
                z-index: 40;
                transition: left 0.3s ease;
            }

            .sidebar.open {
                left: 0;
            }
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="header-glass sticky top-0 z-50">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Course Info -->
            <div class="flex items-center space-x-4">
                <button class="md:hidden text-gray-600 hover:text-red-600 transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <a href="{{ route('student.courses.show', $course->slug) }}"
                   class="text-gray-600 hover:text-red-600 transition-all duration-300 hover:scale-110">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 truncate max-w-md">
                        {{ $course->title }}
                    </h1>
                    <div class="text-sm text-gray-600 font-medium">
                        {{ $currentContent->title ?? 'Chọn nội dung để học' }}
                    </div>
                </div>
            </div>

            <!-- Progress & User -->
            <div class="flex items-center space-x-6">
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="text-sm text-gray-700 font-medium">
                        Tiến độ: <span class="font-bold text-red-600">{{ $completionPercentage ?? 0 }}%</span>
                    </div>
                    <div class="w-32 progress-bar-container">
                        <div class="progress-bar" style="width: {{ $completionPercentage ?? 0 }}%"></div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-3">
                    <img src="{{ auth()->user()->avatar_url }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-10 h-10 rounded-full avatar">
                    <span class="text-sm font-medium text-gray-800 hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="flex">
    <!-- Sidebar - Curriculum -->
    <div class="w-80 sidebar flex flex-col" id="sidebar">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Nội dung khóa học</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $course->sections->count() }} chương học</p>
        </div>

        <div class="flex-1 sidebar-scroll custom-scrollbar">
            @foreach($course->sections as $sectionIndex => $section)
                <div class="border-b border-gray-100 last:border-b-0">
                    <!-- Section Header -->
                    <div class="section-header p-4 relative">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-white">{{ $section->title }}</h3>
                                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">
                                    {{ $sectionIndex + 1 }}
                                </span>
                            </div>
                            @if($section->description)
                                <p class="text-gray-200 text-sm mt-2 opacity-90">{{ $section->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Section Content -->
                    <div>
                        <!-- Lessons -->
                        @foreach($section->lessons as $lesson)
                            @php
                                $lessonProgress = $progress['lesson_' . $lesson->id] ?? null;
                                $isCompleted = $lessonProgress && $lessonProgress->lesson_completed;
                                $isActive = isset($currentContent) && $currentContent && get_class($currentContent) === 'App\Models\Lesson' && $currentContent->id === $lesson->id;
                            @endphp

                            <a href="{{ route('learning.lesson', [$course->slug, $lesson->slug]) }}"
                               class="content-item flex items-center p-4 {{ $isActive ? 'active' : '' }}">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="progress-indicator {{ $isCompleted ? 'completed' : 'pending' }}">
                                        @if($isCompleted)
                                            <i class="fas fa-check text-white text-xs"></i>
                                        @else
                                            <i class="fas fa-play text-white text-xs"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $lesson->title }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($lesson->video_duration)
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>{{ $lesson->video_duration }}
                                            </span>
                                        @endif
                                        @if($lesson->is_preview)
                                            <span class="badge">Xem trước</span>
                                        @endif
                                    </div>
                                </div>
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
                               class="content-item flex items-center p-4 {{ $isActive ? 'active' : '' }}">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="progress-indicator {{ $isPassed ? 'completed' : 'quiz' }}">
                                        @if($isPassed)
                                            <i class="fas fa-check text-white text-xs"></i>
                                        @else
                                            <i class="fas fa-question text-white text-xs"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $quiz->title }}</p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clipboard-question mr-1"></i>
                                        {{ $quiz->questions->count() }} câu hỏi
                                        @if($quizProgress)
                                            • Điểm: <span class="font-semibold">{{ number_format($quizProgress->quiz_score, 1) }}%</span>
                                        @endif
                                    </div>
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
        <div class="flex-1 content-area custom-scrollbar">
            @if(isset($currentContent) && $currentContent)
                <div class="fade-in">
                    @if(get_class($currentContent) === 'App\Models\Lesson')
                        @include('student.learn.lesson', ['lesson' => $currentContent])
                    @elseif(get_class($currentContent) === 'App\Models\Quiz')
                        @include('student.learn.quiz', ['quiz' => $currentContent])
                    @endif
                </div>
            @else
                <!-- Welcome Screen -->
                <div class="welcome-screen flex items-center justify-center h-full">
                    <div class="text-center fade-in">
                        <div class="welcome-icon w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-graduation-cap text-white text-4xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Chào mừng đến với khóa học!</h2>
                        <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">
                            Chọn một bài học từ danh sách bên trái để bắt đầu hành trình học tập của bạn.
                        </p>
                        <div class="inline-flex items-center space-x-3 bg-white px-6 py-3 rounded-xl shadow-lg">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <div class="text-gray-700 font-medium">
                                Tiến độ hiện tại: <span class="font-bold text-red-600">{{ $completionPercentage ?? 0 }}%</span> hoàn thành
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile overlay -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" id="sidebarOverlay" onclick="toggleSidebar()"></div>

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

    // Mobile sidebar toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
        }
    }

    // Close sidebar on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
        }
    });

    // Smooth scroll for content area
    document.addEventListener('DOMContentLoaded', function() {
        const contentArea = document.querySelector('.content-area');
        if (contentArea) {
            contentArea.style.scrollBehavior = 'smooth';
        }
    });
</script>
</body>
</html>
