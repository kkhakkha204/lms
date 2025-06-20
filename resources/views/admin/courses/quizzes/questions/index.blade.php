@extends('layouts.app')

@section('title', 'Danh sách câu hỏi')

@section('content')
    <div class="container mx-auto p-4" x-data="questionsManager()">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold">Câu hỏi trong "{{ $quiz->title }}"</h1>
                    <p class="text-gray-600 mt-1">{{ $questions->count() }} câu hỏi</p>
                </div>
            </div>

            <a href="{{ route('admin.courses.sections.quizzes.questions.create', [$course, $section, $quiz]) }}"
               class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Thêm câu hỏi
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($questions->count() > 0)
            <!-- Quiz Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="text-2xl font-bold text-blue-600">{{ $questions->count() }}</div>
                    <div class="text-sm text-gray-600">Tổng câu hỏi</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="text-2xl font-bold text-green-600">{{ $questions->sum('points') }}</div>
                    <div class="text-sm text-gray-600">Tổng điểm</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="text-2xl font-bold text-purple-600">{{ $questions->where('is_required', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Câu bắt buộc</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="text-2xl font-bold text-orange-600">{{ $questions->groupBy('type')->count() }}</div>
                    <div class="text-sm text-gray-600">Loại khác nhau</div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Danh sách câu hỏi</h2>
                    <div class="flex items-center space-x-2">
                        <button @click="toggleReorderMode()"
                                class="text-blue-600 hover:text-blue-800 px-3 py-1 rounded border border-blue-300 hover:bg-blue-50 transition-colors text-sm">
                            <span x-text="reorderMode ? 'Hoàn thành' : 'Sắp xếp'"></span>
                        </button>
                    </div>
                </div>

                <div x-show="reorderMode" class="p-4 bg-blue-50 border-b">
                    <p class="text-sm text-blue-700">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kéo thả để sắp xếp lại thứ tự câu hỏi
                    </p>
                </div>

                <div x-ref="questionsList" class="divide-y divide-gray-200">
                    @foreach($questions as $question)
                        <div class="p-4 hover:bg-gray-50 transition-colors question-item"
                             data-question-id="{{ $question->id }}"
                             :class="{ 'cursor-move': reorderMode }">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($question->type)
                                                @case('single_choice') bg-blue-100 text-blue-800 @break
                                                @case('multiple_choice') bg-green-100 text-green-800 @break
                                                @case('fill_blank') bg-purple-100 text-purple-800 @break
                                                @case('true_false') bg-orange-100 text-orange-800 @break
                                            @endswitch">
                                            @switch($question->type)
                                                @case('single_choice') Một đáp án @break
                                                @case('multiple_choice') Nhiều đáp án @break
                                                @case('fill_blank') Điền chỗ trống @break
                                                @case('true_false') Đúng/Sai @break
                                            @endswitch
                                        </span>

                                        @if($question->is_required)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Bắt buộc
                                            </span>
                                        @endif

                                        <span class="ml-2 text-sm text-gray-500">
                                            {{ $question->points }} điểm
                                        </span>

                                        <span class="ml-2 text-sm text-gray-400">
                                            #{{ $question->sort_order }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        {{ Str::limit($question->question, 100) }}
                                    </h3>

                                    @if($question->options->count() > 0)
                                        <div class="text-sm text-gray-600">
                                            <strong>Tùy chọn:</strong>
                                            <ul class="mt-1 space-y-1">
                                                @foreach($question->options->take(3) as $option)
                                                    <li class="flex items-center">
                                                        @if($option->is_correct)
                                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-gray-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        @endif
                                                        {{ Str::limit($option->option_text, 50) }}
                                                    </li>
                                                @endforeach
                                                @if($question->options->count() > 3)
                                                    <li class="text-gray-400 text-xs">
                                                        và {{ $question->options->count() - 3 }} tùy chọn khác...
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif

                                    @if($question->explanation)
                                        <div class="mt-2 text-sm text-gray-600">
                                            <strong>Giải thích:</strong> {{ Str::limit($question->explanation, 100) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center space-x-2 ml-4" x-show="!reorderMode">
                                    <a href="{{ route('admin.courses.sections.quizzes.questions.edit', [$course, $section, $quiz, $question]) }}"
                                       class="text-blue-600 hover:text-blue-800 p-2 rounded-md hover:bg-blue-50 transition-colors"
                                       title="Chỉnh sửa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <button @click="confirmDelete({{ $question->id }})"
                                            class="text-red-600 hover:text-red-800 p-2 rounded-md hover:bg-red-50 transition-colors"
                                            title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center ml-4" x-show="reorderMode">
                                    <svg class="w-6 h-6 text-gray-400 cursor-move drag-handle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2M16 4h2a2 2 0 012 2v2M16 20h2a2 2 0 002-2v-2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có câu hỏi nào</h3>
                <p class="text-gray-500 mb-6">Hãy tạo câu hỏi đầu tiên cho quiz này</p>
                <a href="{{ route('admin.courses.sections.quizzes.questions.create', [$course, $section, $quiz]) }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tạo câu hỏi đầu tiên
                </a>
            </div>
        @endif

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal"
             class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Xóa câu hỏi</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Bạn có chắc chắn muốn xóa câu hỏi này? Hành động này không thể hoàn tác.
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button @click="showDeleteModal = false"
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Hủy
                        </button>
                        <form :action="deleteUrl" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function questionsManager() {
            return {
                reorderMode: false,
                showDeleteModal: false,
                deleteUrl: '',
                sortable: null,

                init() {
                    this.initSortable();
                },

                toggleReorderMode() {
                    this.reorderMode = !this.reorderMode;

                    if (this.reorderMode) {
                        this.enableSortable();
                    } else {
                        this.disableSortable();
                        this.saveNewOrder();
                    }
                },

                initSortable() {
                    // Initialize sortable functionality when needed
                    if (typeof Sortable !== 'undefined') {
                        this.sortable = Sortable.create(this.$refs.questionsList, {
                            handle: '.drag-handle',
                            disabled: true,
                            animation: 150,
                            ghostClass: 'sortable-ghost',
                            chosenClass: 'sortable-chosen',
                            dragClass: 'sortable-drag'
                        });
                    }
                },

                enableSortable() {
                    if (this.sortable) {
                        this.sortable.option('disabled', false);
                    }
                },

                disableSortable() {
                    if (this.sortable) {
                        this.sortable.option('disabled', true);
                    }
                },

                saveNewOrder() {
                    const items = this.$refs.questionsList.querySelectorAll('.question-item');
                    const questions = Array.from(items).map((item, index) => ({
                        id: item.dataset.questionId,
                        sort_order: index
                    }));

                    // Send AJAX request to save new order
                    fetch('{{ route('admin.courses.sections.quizzes.questions.reorder', [$course, $section, $quiz]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ questions: questions })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                this.showMessage('Thứ tự câu hỏi đã được cập nhật.', 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.showMessage('Có lỗi xảy ra khi cập nhật thứ tự.', 'error');
                        });
                },

                confirmDelete(questionId) {
                    this.deleteUrl = `{{ route('admin.courses.sections.quizzes.questions.destroy', [$course, $section, $quiz, ':id']) }}`.replace(':id', questionId);
                    this.showDeleteModal = true;
                },

                showMessage(message, type) {
                    // Simple toast notification
                    const toast = document.createElement('div');
                    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                    }`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            }
        }
    </script>

    <!-- Add Sortable.js for drag & drop functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>

    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #f3f4f6;
        }

        .sortable-chosen {
            transform: rotate(5deg);
        }

        .sortable-drag {
            transform: rotate(5deg);
        }

        .question-item {
            transition: all 0.2s ease;
        }

        .question-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
