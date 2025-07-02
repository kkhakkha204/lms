@extends('layouts.admin')

@section('title', 'Chỉnh sửa câu hỏi')

@section('content')
    <div class="container mx-auto p-4" x-data="editQuestionForm()">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Chỉnh sửa câu hỏi: "{{ $quiz->title }}"</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.courses.sections.quizzes.questions.update', [$course, $section, $quiz, $question]) }}"
              method="POST" class="bg-white p-6 rounded-lg shadow-lg" @submit="validateForm">
            @csrf
            @method('PUT')

            <!-- Câu hỏi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Câu hỏi <span class="text-red-500">*</span>
                </label>
                <textarea name="question" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Nhập nội dung câu hỏi..."
                          x-model="questionText">{{ old('question', $question->question) }}</textarea>
                <p class="text-sm text-gray-500 mt-1" x-text="'Số ký tự: ' + questionText.length + '/1000'"></p>
            </div>

            <!-- Loại câu hỏi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Loại câu hỏi <span class="text-red-500">*</span>
                </label>
                <select name="type" x-model="type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        @change="handleTypeChange()">
                    <option value="single_choice" {{ old('type', $question->type) == 'single_choice' ? 'selected' : '' }}>
                        Trắc nghiệm một đáp án
                    </option>
                    <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>
                        Trắc nghiệm nhiều đáp án
                    </option>
                    <option value="fill_blank" {{ old('type', $question->type) == 'fill_blank' ? 'selected' : '' }}>
                        Điền vào chỗ trống
                    </option>
                    <option value="true_false" {{ old('type', $question->type) == 'true_false' ? 'selected' : '' }}>
                        Đúng/Sai
                    </option>
                </select>
                <div class="mt-2 text-sm text-gray-600">
                    <div x-show="type === 'single_choice'">Học viên chỉ được chọn một đáp án đúng</div>
                    <div x-show="type === 'multiple_choice'">Học viên có thể chọn nhiều đáp án đúng</div>
                    <div x-show="type === 'fill_blank'">Học viên nhập đáp án vào ô trống</div>
                    <div x-show="type === 'true_false'">Câu hỏi có 2 lựa chọn: Đúng hoặc Sai</div>
                </div>
            </div>

            <!-- Tùy chọn cho các loại câu hỏi có lựa chọn -->
            <div class="mb-6" x-show="type !== 'fill_blank'">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tùy chọn <span class="text-red-500">*</span>
                </label>

                <!-- True/False options -->
                <template x-if="type === 'true_false'">
                    <div class="space-y-3">
                        <div class="flex items-center p-3 border rounded-md">
                            <input type="text" name="options[0][option_text]" value="Đúng" readonly
                                   class="flex-1 border-0 bg-gray-50 text-gray-700">
                            <input type="hidden" name="options[0][is_correct]" :value="options[0] && options[0].is_correct ? '1' : '0'">
                            <input type="radio" name="true_false_correct" value="0"
                                   :checked="options[0] && options[0].is_correct"
                                   @change="options[0].is_correct = true; options[1].is_correct = false"
                                   class="ml-3">
                            <span class="ml-2 text-sm text-gray-600">Đáp án đúng</span>
                        </div>
                        <div class="flex items-center p-3 border rounded-md">
                            <input type="text" name="options[1][option_text]" value="Sai" readonly
                                   class="flex-1 border-0 bg-gray-50 text-gray-700">
                            <input type="hidden" name="options[1][is_correct]" :value="options[1] && options[1].is_correct ? '1' : '0'">
                            <input type="radio" name="true_false_correct" value="1"
                                   :checked="options[1] && options[1].is_correct"
                                   @change="options[1].is_correct = true; options[0].is_correct = false"
                                   class="ml-3">
                            <span class="ml-2 text-sm text-gray-600">Đáp án đúng</span>
                        </div>
                    </div>
                </template>

                <!-- Single/Multiple choice options -->
                <template x-if="type === 'single_choice' || type === 'multiple_choice'">
                    <div class="space-y-3">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex items-center p-3 border rounded-md" :class="{'bg-green-50 border-green-200': option.is_correct}">
                                <div class="flex-1 mr-3">
                                    <input type="text"
                                           :name="'options[' + index + '][option_text]'"
                                           x-model="option.text"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           :placeholder="'Nhập tùy chọn ' + (index + 1) + '...'"
                                           maxlength="500">
                                </div>

                                <!-- Hidden input để gửi giá trị is_correct -->
                                <input type="hidden" :name="'options[' + index + '][is_correct]'" :value="option.is_correct ? '1' : '0'">

                                <template x-if="type === 'single_choice'">
                                    <input type="radio"
                                           name="single_correct"
                                           :value="index"
                                           :checked="option.is_correct"
                                           @change="setSingleCorrect(index)"
                                           class="mr-2">
                                </template>

                                <template x-if="type === 'multiple_choice'">
                                    <input type="checkbox"
                                           :id="'option_' + index"
                                           x-model="option.is_correct"
                                           class="mr-2">
                                </template>

                                <span class="mr-3 text-sm text-gray-600">Đúng</span>

                                <button type="button"
                                        @click="removeOption(index)"
                                        class="text-red-600 hover:text-red-800"
                                        x-show="options.length > getMinOptions()"
                                        title="Xóa tùy chọn">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <button type="button"
                                @click="addOption()"
                                class="w-full py-2 px-4 border-2 border-dashed border-gray-300 rounded-md text-gray-600 hover:border-blue-500 hover:text-blue-600 transition-colors"
                                x-show="options.length < 10">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Thêm tùy chọn
                        </button>

                        <div class="text-sm text-gray-500" x-text="getOptionHint()"></div>
                    </div>
                </template>
            </div>

            <!-- Đáp án đúng cho fill_blank -->
            <div class="mb-6" x-show="type === 'fill_blank'">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Đáp án đúng <span class="text-red-500">*</span>
                </label>

                <!-- Hướng dẫn cách tạo chỗ trống -->
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">💡 Cách tạo chỗ trống trong câu hỏi:</h4>
                    <div class="text-sm text-blue-700 space-y-1">
                        <div>• Sử dụng dấu gạch dưới: <code class="bg-blue-100 px-1 rounded">_____</code></div>
                        <div>• Sử dụng từ khóa: <code class="bg-blue-100 px-1 rounded">[BLANK]</code></div>
                        <div>• Sử dụng ba dấu chấm: <code class="bg-blue-100 px-1 rounded">...</code></div>
                    </div>
                </div>

                <!-- Ví dụ câu hỏi -->
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                    <h4 class="text-sm font-medium text-green-800 mb-2">📝 Ví dụ:</h4>
                    <div class="text-sm text-green-700">
                        <div class="mb-2">
                            <strong>Câu hỏi:</strong> Laravel là một _____ framework của PHP.
                        </div>
                        <div>
                            <strong>Đáp án đúng:</strong> <code class="bg-green-100 px-1 rounded">web</code>
                        </div>
                    </div>
                </div>

                <input type="text" name="correct_answer"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Nhập đáp án đúng (ví dụ: web, Controller, Laravel...)"
                       :value="correctAnswer"
                       maxlength="500">

                <div class="mt-2 space-y-1">
                    <p class="text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Đáp án sẽ được so sánh không phân biệt hoa thường
                    </p>
                    <p class="text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Khoảng trắng thừa sẽ được tự động loại bỏ
                    </p>
                </div>

                <!-- Preview câu hỏi với đáp án -->
                <div class="mt-4 p-3 bg-gray-50 border rounded-md" x-show="questionText.length > 0">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">🔍 Preview câu hỏi:</h5>
                    <div class="text-sm text-gray-600" x-html="getQuestionPreview()"></div>
                </div>
            </div>

            <!-- Giải thích -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giải thích (tùy chọn)</label>
                <textarea name="explanation" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Giải thích đáp án đúng..."
                          maxlength="2000">{{ old('explanation', $question->explanation) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Giải thích sẽ hiển thị sau khi học viên hoàn thành câu hỏi</p>
            </div>

            <!-- Điểm số và cài đặt -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Điểm số <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="points" step="0.1" min="0.1" max="100"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('points', $question->points) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thứ tự</label>
                    <input type="number" name="sort_order" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('sort_order', $question->sort_order) }}">
                </div>

                <div class="flex items-center pt-6">
                    <input type="checkbox" name="is_required" value="1"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{ old('is_required', $question->is_required) ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-700">Bắt buộc trả lời</label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Hủy
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-[#1c1c1c] text-white rounded-md hover:bg-blue-700 transition-colors">
                    Cập nhật câu hỏi
                </button>
            </div>
        </form>

        <!-- Delete confirmation modal -->
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
        function editQuestionForm() {
            return {
                questionText: '{{ old('question', $question->question) }}',
                type: '{{ old('type', $question->type) }}',
                options: @json(old('options', $question->options->map(function($option) {
                    return ['text' => $option->option_text, 'is_correct' => $option->is_correct];
                })->values()->toArray())),
                correctAnswer: '{{ $question->type === 'fill_blank' && $question->options->first() ? $question->options->first()->option_text : '' }}',
                showDeleteModal: false,
                deleteUrl: '{{ route('admin.courses.sections.quizzes.questions.destroy', [$course, $section, $quiz, $question]) }}',

                init() {
                    if (this.options.length === 0) {
                        this.resetOptions();
                    }
                    this.handleTypeChange();
                },

                handleTypeChange() {
                    if (this.type === 'true_false') {
                        this.options = [
                            { text: 'Đúng', is_correct: this.options[0]?.is_correct || false },
                            { text: 'Sai', is_correct: this.options[1]?.is_correct || false }
                        ];
                    } else if (this.type === 'fill_blank') {
                        // Keep current correct answer for fill_blank
                    } else {
                        // Ensure minimum options for other types
                        const minOptions = this.getMinOptions();
                        while (this.options.length < minOptions) {
                            this.options.push({ text: '', is_correct: false });
                        }
                    }
                },

                resetOptions() {
                    const minOptions = this.getMinOptions();
                    this.options = Array(minOptions).fill().map(() => ({ text: '', is_correct: false }));
                },

                addOption() {
                    if (this.options.length < 10) {
                        this.options.push({ text: '', is_correct: false });
                    }
                },

                removeOption(index) {
                    if (this.options.length > this.getMinOptions()) {
                        this.options.splice(index, 1);
                    }
                },

                setSingleCorrect(index) {
                    this.options.forEach((option, i) => {
                        option.is_correct = i === index;
                    });
                },

                getMinOptions() {
                    switch(this.type) {
                        case 'single_choice': return 2;
                        case 'multiple_choice': return 3;
                        case 'true_false': return 2;
                        default: return 0;
                    }
                },

                getOptionHint() {
                    switch(this.type) {
                        case 'single_choice':
                            return 'Chọn một tùy chọn đúng. Tối thiểu 2 tùy chọn.';
                        case 'multiple_choice':
                            return 'Chọn một hoặc nhiều tùy chọn đúng. Tối thiểu 3 tùy chọn.';
                        case 'true_false':
                            return 'Chọn đáp án đúng: Đúng hoặc Sai.';
                        default: return '';
                    }
                },

                getQuestionPreview() {
                    if (!this.questionText) return '';

                    let preview = this.questionText;

                    // Thay thế các dạng chỗ trống bằng input field
                    preview = preview.replace(/_{3,}/g, '<input type="text" class="border-b-2 border-blue-300 bg-transparent px-2 py-1 text-blue-600 font-medium" placeholder="..." readonly style="width: 100px;">');
                    preview = preview.replace(/\[BLANK\]/gi, '<input type="text" class="border-b-2 border-blue-300 bg-transparent px-2 py-1 text-blue-600 font-medium" placeholder="..." readonly style="width: 100px;">');
                    preview = preview.replace(/\.{3}/g, '<input type="text" class="border-b-2 border-blue-300 bg-transparent px-2 py-1 text-blue-600 font-medium" placeholder="..." readonly style="width: 100px;">');

                    return preview;
                },

                validateForm(event) {
                    // Kiểm tra basic validation trước khi submit
                    if (this.type !== 'fill_blank') {
                        const hasCorrect = this.options.some(option => option.is_correct);
                        if (!hasCorrect) {
                            alert('Vui lòng chọn ít nhất một đáp án đúng.');
                            event.preventDefault();
                            return false;
                        }
                    } else {
                        // Validation cho fill_blank
                        const correctAnswer = document.querySelector('input[name="correct_answer"]').value.trim();
                        if (!correctAnswer) {
                            alert('Vui lòng nhập đáp án đúng cho câu hỏi điền chỗ trống.');
                            event.preventDefault();
                            return false;
                        }

                        // Kiểm tra xem câu hỏi có chỗ trống không
                        const hasBlank = /_{3,}|\[BLANK\]|\.{3}/.test(this.questionText);
                        if (!hasBlank) {
                            const confirm = window.confirm('Câu hỏi của bạn không có chỗ trống rõ ràng (_____, [BLANK], hoặc ...). Bạn có muốn tiếp tục?');
                            if (!confirm) {
                                event.preventDefault();
                                return false;
                            }
                        }
                    }

                    return true;
                },

                confirmDelete() {
                    this.showDeleteModal = true;
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
@endsection
