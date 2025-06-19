@extends('layouts.app')

@section('title', 'Chỉnh sửa câu hỏi')

@section('content')
    <div class="container mx-auto p-4" x-data="{
    type: '{{ old('type', $question->type) }}',
    options: @json(old('options', $question->options->map(fn($option) => ['text' => $option->option_text, 'is_correct' => $option->is_correct])->toArray())),
    addOption() { this.options.push({ text: '', is_correct: false }) },
    removeOption(index) { if (this.options.length > 2) this.options.splice(index, 1) }
}">
        <h1 class="text-3xl font-bold mb-6">Chỉnh sửa câu hỏi: {{ $quiz->title }}</h1>
        <form action="{{ route('admin.courses.sections.quizzes.questions.update', [$course, $section, $quiz, $question]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Câu hỏi</label>
                <textarea name="question" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('question', $question->question) }}</textarea>
                @error('question')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Loại câu hỏi</label>
                <select name="type" x-model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="single_choice" {{ old('type', $question->type) == 'single_choice' ? 'selected' : '' }}>Trắc nghiệm một đáp án</option>
                    <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>Trắc nghiệm nhiều đáp án</option>
                    <option value="fill_blank" {{ old('type', $question->type) == 'fill_blank' ? 'selected' : '' }}>Điền vào chỗ trống</option>
                    <option value="true_false" {{ old('type', $question->type) == 'true_false' ? 'selected' : '' }}>Đúng/Sai</option>
                </select>
                @error('type')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" x-show="type !== 'fill_blank'">
                <label class="block text-sm font-medium text-gray-700">Tùy chọn</label>
                <template x-for="(option, index) in options" :key="index">
                    <div class="flex items-center mb-2">
                        <input type="text" :name="'options[' + index + '][option_text]'" x-model="option.text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nhập tùy chọn">
                        <input type="hidden" :name="'options[' + index + '][is_correct]'" value="0">
                        <input type="checkbox" :name="'options[' + index + '][is_correct]'" value="1" x-model="option.is_correct" class="ml-2">
                        <span class="ml-2 text-sm text-gray-600">Đúng</span>
                        <button type="button" @click="removeOption(index)" class="ml-2 text-red-600 hover:underline" x-show="options.length > 2">Xóa</button>
                    </div>
                </template>
                <button type="button" @click="addOption" class="text-blue-600 hover:underline mt-2">Thêm tùy chọn</button>
                @error('options.*.option_text')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @error('options.*.is_correct')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Giải thích</label>
                <textarea name="explanation" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('explanation', $question->explanation) }}</textarea>
                @error('explanation')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Điểm</label>
                <input type="number" name="points" value="{{ old('points', $question->points) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('points')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bắt buộc</label>
                <input type="checkbox" name="is_required" value="1" {{ old('is_required', $question->is_required) ? 'checked' : '' }} class="mt-1">
                @error('is_required')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $question->sort_order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('sort_order')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cập nhật</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
@endsection
