@extends('layouts.admin')

@section('title', 'Tạo câu hỏi mới')

@section('content')
    <div class="container mx-auto p-6 bg-white min-h-screen" x-data="questionForm()">
        <!-- Header Section -->
        <div class="flex items-center mb-8 p-4 bg-white rounded-2xl shadow-neumorph">
            <a href="{{ route('admin.courses.edit', $course) }}"
               class="neumorph-button p-3 rounded-xl text-primary hover:text-accent transition-all duration-300 mr-6">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-primary mb-1">Tạo câu hỏi mới</h1>
                <p class="text-gray-600 font-medium">cho "{{ $quiz->title }}"</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-danger text-red-800 px-6 py-4 rounded-2xl shadow-neumorph-sm mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-danger mr-3 mt-1"></i>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Form -->
        <form action="{{ route('admin.courses.sections.quizzes.questions.store', [$course, $section, $quiz]) }}"
              method="POST" class="bg-white p-8 rounded-3xl shadow-neumorph" @submit="validateForm">
            @csrf

            <!-- Question Input -->
            <div class="mb-8">
                <label class="flex items-center text-lg font-semibold text-primary mb-4">
                    <i class="fas fa-question-circle text-accent mr-3"></i>
                    Câu hỏi <span class="text-danger ml-1">*</span>
                </label>
                <div class="relative">
                <textarea name="question" rows="4"
                          class="w-full p-4 border-0 bg-white rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 resize-none text-gray-800 placeholder-gray-500"
                          placeholder="Nhập nội dung câu hỏi..."
                          x-model="question">{{ old('question') }}</textarea>
                    <div class="absolute bottom-3 right-4 text-sm text-gray-500 bg-white px-2 py-1 rounded-lg shadow-neumorph-sm"
                         x-text="question.length + '/1000'"></div>
                </div>
            </div>

            <!-- Question Type -->
            <div class="mb-8">
                <label class="flex items-center text-lg font-semibold text-primary mb-4">
                    <i class="fas fa-list-ul text-accent mr-3"></i>
                    Loại câu hỏi <span class="text-danger ml-1">*</span>
                </label>
                <select name="type" x-model="type"
                        class="w-full p-4 border-0 bg-white rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 text-gray-800"
                        @change="resetOptions()">
                    <option value="single_choice" {{ old('type') == 'single_choice' ? 'selected' : '' }}>
                        🔘 Trắc nghiệm một đáp án
                    </option>
                    <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>
                        ☑️ Trắc nghiệm nhiều đáp án
                    </option>
                    <option value="fill_blank" {{ old('type') == 'fill_blank' ? 'selected' : '' }}>
                        ✍️ Điền vào chỗ trống
                    </option>
                    <option value="true_false" {{ old('type') == 'true_false' ? 'selected' : '' }}>
                        ✅ Đúng/Sai
                    </option>
                </select>

                <!-- Type Descriptions -->
                <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-neumorph-sm">
                    <div x-show="type === 'single_choice'" class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span>Học viên chỉ được chọn một đáp án đúng</span>
                    </div>
                    <div x-show="type === 'multiple_choice'" class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span>Học viên có thể chọn nhiều đáp án đúng</span>
                    </div>
                    <div x-show="type === 'fill_blank'" class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span>Học viên nhập đáp án vào ô trống</span>
                    </div>
                    <div x-show="type === 'true_false'" class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span>Câu hỏi có 2 lựa chọn: Đúng hoặc Sai</span>
                    </div>
                </div>
            </div>

            <!-- Options for Choice Questions -->
            <div class="mb-8" x-show="type !== 'fill_blank'">
                <label class="flex items-center text-lg font-semibold text-primary mb-4">
                    <i class="fas fa-tasks text-accent mr-3"></i>
                    Tùy chọn <span class="text-danger ml-1">*</span>
                </label>

                <!-- True/False options -->
                <template x-if="type === 'true_false'">
                    <div class="space-y-4">
                        <div class="flex items-center p-5 bg-white rounded-2xl shadow-neumorph hover:shadow-neumorph-sm transition-all duration-300">
                            <div class="flex-1 flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-4 text-xl"></i>
                                <input type="text" name="options[0][option_text]" value="Đúng" readonly
                                       class="flex-1 border-0 bg-transparent text-gray-800 font-medium text-lg">
                            </div>
                            <input type="hidden" name="options[0][is_correct]" :value="options[0] && options[0].is_correct ? '1' : '0'">
                            <div class="flex items-center ml-4">
                                <input type="radio" name="true_false_correct" value="0"
                                       @change="options[0].is_correct = true; options[1].is_correct = false"
                                       class="w-5 h-5 text-accent border-2 border-gray-300 focus:ring-accent">
                                <span class="ml-3 text-gray-600 font-medium">Đáp án đúng</span>
                            </div>
                        </div>
                        <div class="flex items-center p-5 bg-white rounded-2xl shadow-neumorph hover:shadow-neumorph-sm transition-all duration-300">
                            <div class="flex-1 flex items-center">
                                <i class="fas fa-times-circle text-red-500 mr-4 text-xl"></i>
                                <input type="text" name="options[1][option_text]" value="Sai" readonly
                                       class="flex-1 border-0 bg-transparent text-gray-800 font-medium text-lg">
                            </div>
                            <input type="hidden" name="options[1][is_correct]" :value="options[1] && options[1].is_correct ? '1' : '0'">
                            <div class="flex items-center ml-4">
                                <input type="radio" name="true_false_correct" value="1"
                                       @change="options[1].is_correct = true; options[0].is_correct = false"
                                       class="w-5 h-5 text-accent border-2 border-gray-300 focus:ring-accent">
                                <span class="ml-3 text-gray-600 font-medium">Đáp án đúng</span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Single/Multiple choice options -->
                <template x-if="type === 'single_choice' || type === 'multiple_choice'">
                    <div class="space-y-4">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex items-center p-5 bg-white rounded-2xl shadow-neumorph hover:shadow-neumorph-sm transition-all duration-300"
                                 :class="{'ring-2 ring-green-300 bg-gradient-to-r from-green-50 to-emerald-50': option.is_correct}">
                                <div class="flex-1 mr-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-edit text-gray-400 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-600" x-text="'Tùy chọn ' + (index + 1)"></span>
                                    </div>
                                    <input type="text"
                                           :name="'options[' + index + '][option_text]'"
                                           x-model="option.text"
                                           class="w-full border-0 bg-transparent rounded-xl p-3 shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 text-gray-800"
                                           :placeholder="'Nhập tùy chọn ' + (index + 1) + '...'"
                                           maxlength="500">
                                </div>

                                <!-- Hidden input để gửi giá trị is_correct -->
                                <input type="hidden" :name="'options[' + index + '][is_correct]'" :value="option.is_correct ? '1' : '0'">

                                <div class="flex items-center space-x-3">
                                    <template x-if="type === 'single_choice'">
                                        <div class="flex items-center">
                                            <input type="radio"
                                                   name="single_correct"
                                                   :value="index"
                                                   @change="setSingleCorrect(index)"
                                                   class="w-5 h-5 text-accent border-2 border-gray-300 focus:ring-accent">
                                            <span class="ml-2 text-sm text-gray-600 font-medium">Đúng</span>
                                        </div>
                                    </template>

                                    <template x-if="type === 'multiple_choice'">
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                   :id="'option_' + index"
                                                   x-model="option.is_correct"
                                                   class="w-5 h-5 text-accent border-2 border-gray-300 rounded focus:ring-accent">
                                            <span class="ml-2 text-sm text-gray-600 font-medium">Đúng</span>
                                        </div>
                                    </template>

                                    <button type="button"
                                            @click="removeOption(index)"
                                            class="neumorph-button p-2 rounded-xl text-danger hover:text-red-800 transition-all duration-300"
                                            x-show="options.length > getMinOptions()"
                                            title="Xóa tùy chọn">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <button type="button"
                                @click="addOption()"
                                class="w-full py-4 px-6 bg-white rounded-2xl shadow-neumorph border-2 border-dashed border-gray-300 text-gray-600 hover:border-accent hover:text-accent hover:shadow-neumorph-sm transition-all duration-300"
                                x-show="options.length < 10">
                            <i class="fas fa-plus mr-3"></i>
                            Thêm tùy chọn
                        </button>

                        <div class="text-center p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow-neumorph-sm">
                            <span class="text-sm text-gray-600 font-medium" x-text="getOptionHint()"></span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Fill Blank Answer -->
            <div class="mb-8" x-show="type === 'fill_blank'">
                <label class="flex items-center text-lg font-semibold text-primary mb-4">
                    <i class="fas fa-pen text-accent mr-3"></i>
                    Đáp án đúng <span class="text-danger ml-1">*</span>
                </label>

                <!-- Instructions -->
                <div class="mb-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-neumorph-sm border-l-4 border-blue-400">
                    <h4 class="flex items-center text-blue-800 font-semibold mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Cách tạo chỗ trống trong câu hỏi:
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700">
                        <div class="flex items-center p-3 bg-white rounded-xl shadow-neumorph-sm">
                            <span>Dấu gạch dưới: <code class="bg-blue-100 px-2 py-1 rounded font-mono">_____</code></span>
                        </div>
                        <div class="flex items-center p-3 bg-white rounded-xl shadow-neumorph-sm">
                            <span>Từ khóa: <code class="bg-blue-100 px-2 py-1 rounded font-mono">[BLANK]</code></span>
                        </div>
                        <div class="flex items-center p-3 bg-white rounded-xl shadow-neumorph-sm">
                            <span>Ba dấu chấm: <code class="bg-blue-100 px-2 py-1 rounded font-mono">...</code></span>
                        </div>
                    </div>
                </div>

                <!-- Example -->
                <div class="mb-6 p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-neumorph-sm border-l-4 border-green-400">
                    <h4 class="flex items-center text-green-800 font-semibold mb-3">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Ví dụ:
                    </h4>
                    <div class="space-y-3 text-sm text-green-700">
                        <div class="p-3 bg-white rounded-xl shadow-neumorph-sm">
                            <strong>Câu hỏi:</strong> Laravel là một _____ framework của PHP.
                        </div>
                        <div class="p-3 bg-white rounded-xl shadow-neumorph-sm">
                            <strong>Đáp án đúng:</strong> <code class="bg-green-100 px-2 py-1 rounded font-mono">web</code>
                        </div>
                    </div>
                </div>

                <input type="text" name="correct_answer"
                       class="w-full p-4 border-0 bg-white rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 text-gray-800 placeholder-gray-500"
                       placeholder="Nhập đáp án đúng (ví dụ: web, Controller, Laravel...)"
                       value="{{ old('correct_answer') }}"
                       maxlength="500">

                <div class="mt-4 space-y-3">
                    <div class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-neumorph-sm">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Đáp án sẽ được so sánh không phân biệt hoa thường</span>
                    </div>
                    <div class="flex items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-neumorph-sm">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-sm text-gray-700">Khoảng trắng thừa sẽ được tự động loại bỏ</span>
                    </div>
                </div>

                <!-- Preview -->
                <div class="mt-6 p-5 bg-white rounded-2xl shadow-neumorph-inset" x-show="question.length > 0">
                    <h5 class="flex items-center text-gray-700 font-semibold mb-3">
                        <i class="fas fa-eye mr-2"></i>
                        Preview câu hỏi:
                    </h5>
                    <div class="text-gray-600 bg-gray-50 p-4 rounded-xl" x-html="getQuestionPreview()"></div>
                </div>
            </div>

            <!-- Explanation -->
            <div class="mb-8">
                <label class="flex items-center text-lg font-semibold text-primary mb-4">
                    <i class="fas fa-comment-alt text-accent mr-3"></i>
                    Giải thích <span class="text-gray-500 text-base font-normal">(tùy chọn)</span>
                </label>
                <textarea name="explanation" rows="3"
                          class="w-full p-4 border-0 bg-white rounded-2xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 resize-none text-gray-800 placeholder-gray-500"
                          placeholder="Giải thích đáp án đúng..."
                          maxlength="2000">{{ old('explanation') }}</textarea>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Giải thích sẽ hiển thị sau khi học viên hoàn thành câu hỏi
                </p>
            </div>

            <!-- Settings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-5 bg-white rounded-2xl shadow-neumorph">
                    <label class="flex items-center text-base font-semibold text-primary mb-3">
                        <i class="fas fa-star text-accent mr-3"></i>
                        Điểm số <span class="text-danger ml-1">*</span>
                    </label>
                    <input type="number" name="points" step="0.1" min="0.1" max="100"
                           class="w-full p-3 border-0 bg-white rounded-xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 text-gray-800"
                           value="{{ old('points', 1) }}">
                </div>

                <div class="p-5 bg-white rounded-2xl shadow-neumorph">
                    <label class="flex items-center text-base font-semibold text-primary mb-3">
                        <i class="fas fa-sort-numeric-down text-accent mr-3"></i>
                        Thứ tự
                    </label>
                    <input type="number" name="sort_order" min="0"
                           class="w-full p-3 border-0 bg-white rounded-xl shadow-neumorph-inset focus:shadow-neumorph transition-all duration-300 text-gray-800"
                           value="{{ old('sort_order', $nextSortOrder) }}">
                </div>

                <div class="p-5 bg-white rounded-2xl shadow-neumorph flex items-center justify-center">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_required" value="1"
                               class="w-5 h-5 rounded border-2 border-gray-300 text-accent shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50"
                            {{ old('is_required') ? 'checked' : '' }}>
                        <label class="ml-3 text-base font-medium text-gray-700 flex items-center">
                            <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
                            Bắt buộc trả lời
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="px-8 py-3 bg-white text-gray-700 rounded-2xl shadow-neumorph hover:shadow-neumorph-sm hover:text-gray-900 transition-all duration-300 font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Hủy
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-primary text-white rounded-2xl shadow-neumorph hover:shadow-neumorph-sm hover:bg-accent transition-all duration-300 font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Tạo câu hỏi
                </button>
            </div>
        </form>
    </div>

    <script>
        function questionForm() {
            return {
                question: '{{ old('question') }}',
                type: '{{ old('type', 'single_choice') }}',
                options: [
                    { text: '', is_correct: false },
                    { text: '', is_correct: false }
                ],

                init() {
                    this.resetOptions();
                },

                resetOptions() {
                    if (this.type === 'true_false') {
                        this.options = [
                            { text: 'Đúng', is_correct: false },
                            { text: 'Sai', is_correct: false }
                        ];
                    } else {
                        const minOptions = this.getMinOptions();
                        this.options = Array(minOptions).fill().map(() => ({ text: '', is_correct: false }));
                    }
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
                    if (!this.question) return '';

                    let preview = this.question;

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
                        const hasBlank = /_{3,}|\[BLANK\]|\.{3}/.test(this.question);
                        if (!hasBlank) {
                            const confirm = window.confirm('Câu hỏi của bạn không có chỗ trống rõ ràng (_____, [BLANK], hoặc ...). Bạn có muốn tiếp tục?');
                            if (!confirm) {
                                event.preventDefault();
                                return false;
                            }
                        }
                    }

                    return true;
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
@endsection
