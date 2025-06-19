@extends('layouts.app')

@section('title', $course->title . ' - Học tập')

@section('content')
    <div class="min-h-screen bg-gray-50/30">
        <div class="container mx-auto px-6 py-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $course->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Tiến độ học tập của bạn</p>
                    </div>
                    <a href="{{ route('student.courses.show', $course) }}"
                       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Quay lại chi tiết khóa học
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar: Course Content -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden sticky top-6">
                        <!-- Progress Overview -->
                        <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <h2 class="text-sm font-semibold text-gray-900 mb-3">Tổng quan tiến độ</h2>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-600">Hoàn thành</span>
                                    <span class="font-medium text-gray-900">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2 rounded-full transition-all duration-500"
                                         style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mt-3 text-xs">
                                <div class="text-center">
                                    <div class="font-semibold text-gray-900">{{ $enrollment->lessons_completed }}</div>
                                    <div class="text-gray-500">Bài học</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold text-gray-900">{{ $enrollment->quizzes_completed }}</div>
                                    <div class="text-gray-500">Kiểm tra</div>
                                </div>
                            </div>
                            @if ($enrollment->average_quiz_score > 0)
                                <div class="text-center mt-2 text-xs">
                                    <div class="font-semibold text-indigo-600">{{ $enrollment->average_quiz_score }}%</div>
                                    <div class="text-gray-500">Điểm TB</div>
                                </div>
                            @endif
                        </div>

                        <!-- Course Content Navigation -->
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Nội dung khóa học</h3>
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach ($course->sections as $sectionIndex => $section)
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-5 h-5 bg-gray-100 text-gray-600 rounded text-xs flex items-center justify-center font-medium">
                                                {{ $sectionIndex + 1 }}
                                            </div>
                                            <h4 class="text-xs font-medium text-gray-800 line-clamp-2">{{ $section->title }}</h4>
                                        </div>
                                        <div class="ml-7 space-y-1">
                                            @foreach ($section->lessons as $lesson)
                                                <a href="{{ route('student.courses.learn', [$course, 'lesson' => $lesson->id]) }}"
                                                   class="group flex items-center space-x-2 p-2 rounded-md text-xs transition-colors duration-200
                                                      {{ request()->query('lesson') == $lesson->id ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'hover:bg-gray-50 text-gray-600' }}">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="flex-1 truncate">{{ $lesson->title }}</span>
                                                    @if ($progress->get('lesson_' . $lesson->id)?->lesson_completed)
                                                        <svg class="w-3 h-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </a>
                                            @endforeach
                                            @foreach ($section->quizzes as $quiz)
                                                <a href="{{ route('student.courses.learn', [$course, 'quiz' => $quiz->id]) }}"
                                                   class="group flex items-center space-x-2 p-2 rounded-md text-xs transition-colors duration-200
                                                      {{ request()->query('quiz') == $quiz->id ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'hover:bg-gray-50 text-gray-600' }}">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                    </svg>
                                                    <span class="flex-1 truncate">{{ $quiz->title }}</span>
                                                    @if ($progress->get('quiz_' . $quiz->id)?->quiz_passed)
                                                        <div class="flex items-center space-x-1">
                                                            <span class="text-xs font-medium">{{ $progress->get('quiz_' . $quiz->id)->quiz_score }}%</span>
                                                            <svg class="w-3 h-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Lesson or Quiz -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                        @if (request()->query('lesson'))
                            @php
                                $lesson = $course->lessons->find(request()->query('lesson'));
                                $lessonProgress = $progress->get('lesson_' . $lesson->id);
                            @endphp
                            @if ($lesson)
                                <!-- Lesson Header -->
                                <div class="p-6 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg font-semibold text-gray-900">{{ $lesson->title }}</h2>
                                            <p class="text-sm text-gray-500 mt-1">Bài học</p>
                                        </div>
                                        @if ($lessonProgress && $lessonProgress->lesson_completed)
                                            <div class="flex items-center space-x-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>Đã hoàn thành</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Lesson Content -->
                                <div class="p-6 space-y-6">
                                    @if ($lesson->video_url)
                                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                            @if (Str::contains($lesson->video_url, 'youtube.com') || Str::contains($lesson->video_url, 'youtu.be'))
                                                <iframe class="w-full h-full" src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            @else
                                                <video controls class="w-full h-full object-cover" id="lesson-video">
                                                    <source src="{{ asset('storage/' . $lesson->video_url) }}" type="video/mp4">
                                                    Trình duyệt của bạn không hỗ trợ video.
                                                </video>
                                            @endif
                                        </div>
                                    @endif

                                    @if ($lesson->content)
                                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                                            {!! $lesson->content !!}
                                        </div>
                                    @endif

                                    @if ($lesson->materials && $lesson->materials->count() > 0)
                                        <div class="border-t border-gray-100 pt-6">
                                            <h3 class="text-base font-semibold text-gray-900 mb-4">Tài liệu đính kèm</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach ($lesson->materials as $material)
                                                    @if ($material->is_active)
                                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                                           class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200">
                                                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="text-sm font-medium text-gray-900 truncate">{{ $material->title }}</div>
                                                                <div class="text-xs text-gray-500">{{ $material->file_type }} • {{ number_format($material->file_size / 1024, 1) }} KB</div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Lesson Completion -->
                                    @if (!($lessonProgress && $lessonProgress->lesson_completed))
                                        <div class="border-t border-gray-100 pt-6">
                                            <form action="{{ route('student.progress.lesson', [$course, $lesson]) }}" method="POST" class="space-y-4">
                                                @csrf
                                                <input type="hidden" name="video_watched_seconds" id="video-watched-seconds" value="0">
                                                <div class="flex items-center space-x-3 p-4 bg-blue-50 rounded-lg">
                                                    <input type="checkbox" name="lesson_completed" id="lesson-completed" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label for="lesson-completed" class="text-sm font-medium text-blue-900 flex-1">
                                                        Tôi đã hoàn thành bài học này
                                                    </label>
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                        Lưu tiến độ
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-12 text-center">
                                    <div class="text-red-400 mb-4">
                                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900 mb-2">Bài học không tồn tại</h3>
                                    <p class="text-sm text-gray-500">Vui lòng chọn một bài học khác từ danh sách bên trái.</p>
                                </div>
                            @endif

                        @elseif (request()->query('quiz'))
                            @php
                                $quiz = $course->quizzes->find(request()->query('quiz'));
                                $quizProgress = $progress->get('quiz_' . $quiz->id);
                                $quizResults = session('quiz_results');
                            @endphp
                            @if ($quiz)
                                <!-- Quiz Header -->
                                <div class="p-6 border-b border-gray-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h2 class="text-lg font-semibold text-gray-900">{{ $quiz->title }}</h2>
                                            <p class="text-sm text-gray-500 mt-1">Bài kiểm tra</p>
                                        </div>
                                        @if ($quizProgress && $quizProgress->quiz_passed)
                                            <div class="flex items-center space-x-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>Đã qua ({{ $quizProgress->quiz_score }}%)</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Quiz Info -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-600">{{ $quiz->time_limit }} phút</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-gray-600">Qua: {{ $quiz->passing_score }}%</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span class="text-gray-600">{{ $quiz->max_attempts }} lượt</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-600">{{ $quiz->questions->count() }} câu</span>
                                        </div>
                                    </div>

                                    @if ($quiz->description)
                                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                            <div class="text-sm text-blue-900">{!! $quiz->description !!}</div>
                                        </div>
                                    @endif

                                    @if ($quiz->instructions)
                                        <div class="mt-3 p-3 bg-amber-50 rounded-lg">
                                            <div class="text-sm text-amber-900"><strong>Hướng dẫn:</strong> {!! $quiz->instructions !!}</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Quiz Content -->
                                <div class="p-6">
                                    <!-- Quiz Results Display -->
                                    @if ($quizResults && $quizResults['show_results'] && $quizResults['results'])
                                        <div class="mb-8 border border-blue-200 rounded-lg overflow-hidden">
                                            <!-- Results Header -->
                                            <div class="px-6 py-4 {{ $quizResults['passed'] ? 'bg-emerald-50 border-b border-emerald-200' : 'bg-red-50 border-b border-red-200' }}">
                                                <div class="flex items-center space-x-3">
                                                    @if ($quizResults['passed'])
                                                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-semibold text-emerald-900">Chúc mừng! Bạn đã vượt qua bài kiểm tra</h3>
                                                            <p class="text-sm text-emerald-700">Kết quả đã được lưu vào tiến độ học tập</p>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-semibold text-red-900">Bạn chưa vượt qua bài kiểm tra</h3>
                                                            <p class="text-sm text-red-700">Hãy xem lại kết quả và thử lần nữa</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Results Stats -->
                                            <div class="px-6 py-4 bg-white border-b border-gray-100">
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold {{ $quizResults['passed'] ? 'text-emerald-600' : 'text-red-600' }}">
                                                            {{ $quizResults['score'] }}%
                                                        </div>
                                                        <div class="text-xs text-gray-500">Điểm của bạn</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-blue-600">{{ $quizResults['passing_score'] }}%</div>
                                                        <div class="text-xs text-gray-500">Điểm qua</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-gray-600">{{ $quizResults['attempts_used'] }}</div>
                                                        <div class="text-xs text-gray-500">Đã làm</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-gray-600">{{ $quizResults['attempts_left'] }}</div>
                                                        <div class="text-xs text-gray-500">Còn lại</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detailed Results -->
                                            <div class="px-6 py-4 space-y-4 max-h-96 overflow-y-auto">
                                                <h4 class="font-semibold text-gray-900">Chi tiết đáp án:</h4>
                                                @foreach ($quizResults['results'] as $index => $result)
                                                    <div class="border rounded-lg overflow-hidden {{ $result['is_correct'] ? 'border-emerald-200' : 'border-red-200' }}">
                                                        <div class="p-4 {{ $result['is_correct'] ? 'bg-emerald-50' : 'bg-red-50' }}">
                                                            <div class="flex items-start space-x-3">
                                                                <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-medium {{ $result['is_correct'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                                    {{ $index + 1 }}
                                                                </div>
                                                                <div class="flex-1">
                                                                    <h5 class="font-medium text-gray-900 mb-3">{{ $result['question'] }}</h5>

                                                                    <div class="space-y-2 text-sm">
                                                                        <div class="flex items-center space-x-2">
                                                                            <span class="font-medium text-gray-700">Bạn chọn:</span>
                                                                            <span class="px-2 py-1 rounded text-xs {{ $result['is_correct'] ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                                                            {{ $result['user_answer'] }}
                                                                        </span>
                                                                        </div>

                                                                        @if (!$result['is_correct'])
                                                                            <div class="flex items-center space-x-2">
                                                                                <span class="font-medium text-gray-700">Đáp án đúng:</span>
                                                                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded text-xs">
                                                                                {{ $result['correct_answer'] }}
                                                                            </span>
                                                                            </div>
                                                                        @endif

                                                                        <div class="flex items-center space-x-2">
                                                                            <span class="font-medium text-gray-700">Điểm:</span>
                                                                            <span class="text-xs">{{ $result['points_earned'] }}/{{ $result['points_possible'] }}</span>
                                                                        </div>

                                                                        @if ($result['explanation'])
                                                                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded">
                                                                                <div class="flex items-start space-x-2">
                                                                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                                    </svg>
                                                                                    <div>
                                                                                        <div class="text-xs font-medium text-blue-800">Giải thích:</div>
                                                                                        <div class="text-xs text-blue-700 mt-1">{{ $result['explanation'] }}</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if ($quizResults['attempts_left'] > 0 && !$quizResults['passed'])
                                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                                                    <a href="{{ route('student.courses.learn', [$course, 'quiz' => $quiz->id]) }}"
                                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                        Làm lại bài kiểm tra
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Quiz Status Messages -->
                                    @if ($quizProgress && $quizProgress->quiz_passed)
                                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="text-emerald-700 font-medium">Bạn đã hoàn thành bài kiểm tra này với điểm số: {{ $quizProgress->quiz_score }}%</span>
                                            </div>
                                        </div>
                                    @elseif ($quizProgress && $quizProgress->quiz_attempts >= $quiz->max_attempts)
                                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="text-red-700 font-medium">Bạn đã hết lượt làm bài kiểm tra này. Điểm số cuối cùng: {{ $quizProgress->quiz_score }}%</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Quiz Form -->
                                    @if (!($quizProgress && $quizProgress->quiz_passed) && !($quizProgress && $quizProgress->quiz_attempts >= $quiz->max_attempts) && !session('quiz_results'))
                                        <form action="{{ route('student.progress.quiz', [$course, $quiz]) }}" method="POST" class="space-y-6" id="quiz-form">
                                            @csrf
                                            @foreach ($quiz->questions as $index => $question)
                                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                                                        <div class="flex items-start space-x-3">
                                                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-medium">
                                                                {{ $index + 1 }}
                                                            </div>
                                                            <h4 class="font-medium text-gray-900 flex-1">{{ $question->question }}</h4>
                                                        </div>
                                                    </div>

                                                    @if ($question->type === 'single_choice')
                                                        <div class="p-4 space-y-3">
                                                            @foreach ($question->options as $option)
                                                                <label class="flex items-center p-3 border border-gray-200 rounded-md hover:bg-blue-50 hover:border-blue-300 transition-colors duration-200 cursor-pointer">
                                                                    <input type="radio"
                                                                           name="answers[{{ $index }}]"
                                                                           value="{{ $option->id }}"
                                                                           {{ $quizProgress && isset($quizProgress->quiz_answers[$index]) && $quizProgress->quiz_answers[$index] == $option->id ? 'checked' : '' }}
                                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                                           required>
                                                                    <span class="ml-3 text-gray-700 flex-1">{{ $option->option_text }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                            <div class="text-center pt-6 border-t border-gray-100">
                                                <div class="space-y-3">
                                                    <button type="submit"
                                                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn nộp bài? Bạn sẽ không thể thay đổi câu trả lời sau khi nộp.')">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                        </svg>
                                                        Nộp bài kiểm tra
                                                    </button>
                                                    <p class="text-sm text-gray-500">
                                                        Lượt làm bài:
                                                        @if ($quizProgress)
                                                            {{ $quizProgress->quiz_attempts + 1 }}/{{ $quiz->max_attempts }}
                                                        @else
                                                            1/{{ $quiz->max_attempts }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    @endif

                                    <!-- Show Review for Completed Quiz -->
                                    @if (($quizProgress && $quizProgress->quiz_passed) || ($quizProgress && $quizProgress->quiz_attempts >= $quiz->max_attempts))
                                        @if ($quiz->show_results && !session('quiz_results'))
                                            <div class="space-y-4">
                                                <h4 class="font-semibold text-gray-900 border-b border-gray-200 pb-2">Xem lại đáp án</h4>
                                                @foreach ($quiz->questions as $index => $question)
                                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                                                            <div class="flex items-start space-x-3">
                                                                <div class="flex-shrink-0 w-6 h-6 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center text-xs font-medium">
                                                                    {{ $index + 1 }}
                                                                </div>
                                                                <h5 class="font-medium text-gray-900 flex-1">{{ $question->question }}</h5>
                                                            </div>
                                                        </div>

                                                        @if ($question->type === 'single_choice')
                                                            <div class="p-4 space-y-2">
                                                                @foreach ($question->options as $option)
                                                                    <div class="flex items-center p-2 rounded {{ $option->is_correct ? 'bg-emerald-50 border border-emerald-200' : '' }}">
                                                                        <input type="radio" disabled
                                                                               {{ $quizProgress && isset($quizProgress->quiz_answers[$index]) && $quizProgress->quiz_answers[$index] == $option->id ? 'checked' : '' }}
                                                                               class="h-4 w-4 text-blue-600">
                                                                        <span class="ml-3 text-gray-700 {{ $option->is_correct ? 'font-medium text-emerald-700' : '' }}">
                                                                        {{ $option->option_text }}
                                                                            @if ($option->is_correct)
                                                                                <span class="text-emerald-600 text-sm font-medium ml-2">✓ Đáp án đúng</span>
                                                                            @endif
                                                                    </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            @if ($question->explanation)
                                                                <div class="p-4 bg-blue-50 border-t border-blue-200">
                                                                    <div class="flex items-start space-x-2">
                                                                        <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                        </svg>
                                                                        <div>
                                                                            <div class="text-sm font-medium text-blue-800">Giải thích:</div>
                                                                            <div class="text-sm text-blue-700 mt-1">{{ $question->explanation }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @else
                                <div class="p-12 text-center">
                                    <div class="text-red-400 mb-4">
                                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900 mb-2">Bài kiểm tra không tồn tại</h3>
                                    <p class="text-sm text-gray-500">Vui lòng chọn một bài kiểm tra khác từ danh sách bên trái.</p>
                                </div>
                            @endif

                        @else
                            <!-- Welcome State -->
                            <div class="p-12 text-center">
                                <div class="text-blue-400 mb-6">
                                    <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Chào mừng đến với khóa học</h3>
                                <p class="text-gray-500 mb-6">Chọn một bài học hoặc bài kiểm tra từ danh sách bên trái để bắt đầu hành trình học tập của bạn.</p>
                                <div class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Bắt đầu học ngay
                                </div>
                            </div>
                        @endif
                    </div>
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
    </style>

    <script>
        // Update video watched seconds before form submission
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('lesson-video');
            const watchedSecondsInput = document.getElementById('video-watched-seconds');
            if (video && watchedSecondsInput) {
                video.addEventListener('timeupdate', function () {
                    watchedSecondsInput.value = Math.floor(video.currentTime);
                });
            }

            // Auto-scroll to quiz results if they exist
            const quizResults = document.querySelector('.border-blue-200');
            if (quizResults && {{ session('quiz_results') ? 'true' : 'false' }}) {
                quizResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>
@endsection
