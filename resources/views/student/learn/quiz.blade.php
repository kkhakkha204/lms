<div class="h-full overflow-y-auto" x-data="quizViewer()">
    <div class="max-w-4xl mx-auto p-6">
        <!-- Quiz Header -->
        <div class="bg-white rounded-lg border p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h1>

            @if($quiz->description)
                <p class="text-lg text-gray-600 mb-4">{{ $quiz->description }}</p>
            @endif

            <!-- Quiz Info -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $quiz->questions->count() }}</div>
                    <div class="text-sm text-blue-800">Câu hỏi</div>
                </div>
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $quiz->passing_score }}%</div>
                    <div class="text-sm text-green-800">Điểm đạt</div>
                </div>
                <div class="text-center p-3 bg-orange-50 rounded-lg">
                    <div class="text-2xl font-bold text-orange-600">{{ $quiz->time_limit ?? '∞' }}</div>
                    <div class="text-sm text-orange-800">Phút</div>
                </div>
                <div class="text-center p-3 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $quiz->max_attempts }}</div>
                    <div class="text-sm text-purple-800">Lần làm</div>
                </div>
            </div>

            <!-- Previous Attempts -->
            @php
                $quizProgress = $progress['quiz_' . $quiz->id] ?? null;
            @endphp

            @if($quizProgress && $quizProgress->quiz_attempts > 0)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Kết quả lần làm trước</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">
                                Lần thử: {{ $quizProgress->quiz_attempts }}/{{ $quiz->max_attempts }}
                            </span>
                            <span class="text-sm text-gray-600">
                                Điểm: <span class="font-semibold {{ $quizProgress->quiz_passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($quizProgress->quiz_score, 1) }}%
                                </span>
                            </span>
                        </div>
                        @if($quizProgress->quiz_passed)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>Đã đạt
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            @if($quiz->instructions)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">Hướng dẫn làm bài</h3>
                    <p class="text-yellow-700">{{ $quiz->instructions }}</p>
                </div>
            @endif

            <!-- Start Quiz Button -->
            <div class="text-center" x-show="!quizStarted">
                @if(!$quizProgress || $quizProgress->quiz_attempts < $quiz->max_attempts)
                    <button @click="startQuiz"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-play mr-2"></i>
                        {{ $quizProgress ? 'Làm lại bài quiz' : 'Bắt đầu làm bài' }}
                    </button>
                @else
                    <div class="text-red-600">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Bạn đã hết số lần làm bài cho quiz này.
                    </div>
                @endif
            </div>
        </div>

        <!-- Quiz Questions -->
        <div x-show="quizStarted && !showResults" class="space-y-6">
            <!-- Timer -->
            @if($quiz->time_limit)
                <div class="bg-white rounded-lg border p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Thời gian còn lại:</span>
                        <span class="text-lg font-bold" :class="timeLeft <= 300 ? 'text-red-600' : 'text-blue-600'" x-text="formatTime(timeLeft)"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000"
                             :style="`width: ${(timeLeft / totalTime) * 100}%`"></div>
                    </div>
                </div>
            @endif

            <!-- Questions -->
            @foreach($quiz->questions as $index => $question)
                <div class="bg-white rounded-lg border p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Câu {{ $index + 1 }}: {{ $question->question }}
                            <span class="text-sm font-normal text-gray-500">({{ $question->points }} điểm)</span>
                        </h3>
                    </div>

                    <!-- Single Choice / True False -->
                    @if(in_array($question->type, ['single_choice', 'true_false']))
                        <div class="space-y-3">
                            @foreach($question->options as $option)
                                <label class="quiz-option flex items-center p-3 border rounded-lg cursor-pointer"
                                       :class="getOptionClass({{ $question->id }}, {{ $option->id }})">
                                    <input type="radio"
                                           name="question_{{ $question->id }}"
                                           value="{{ $option->id }}"
                                           x-model="answers[{{ $question->id }}]"
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-900">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <!-- Multiple Choice -->
                    @if($question->type === 'multiple_choice')
                        <div class="space-y-3">
                            @foreach($question->options as $option)
                                <label class="quiz-option flex items-center p-3 border rounded-lg cursor-pointer"
                                       :class="getOptionClass({{ $question->id }}, {{ $option->id }})">
                                    <input type="checkbox"
                                           value="{{ $option->id }}"
                                           @change="toggleMultipleChoice({{ $question->id }}, {{ $option->id }})"
                                           :checked="isMultipleChoiceSelected({{ $question->id }}, {{ $option->id }})"
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-900">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <!-- Fill in the Blank -->
                    @if($question->type === 'fill_blank')
                        <div>
                            <input type="text"
                                   x-model="answers[{{ $question->id }}]"
                                   placeholder="Nhập câu trả lời của bạn..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    @endif

                    <!-- Show explanation after submission -->
                    <div x-show="showResults && '{{ $question->explanation }}'" class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Giải thích:</h4>
                        <p class="text-blue-800">{{ $question->explanation }}</p>
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="text-center">
                <button @click="submitQuiz"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Nộp bài
                </button>
            </div>
        </div>

        <!-- Results -->
        <div x-show="showResults" class="bg-white rounded-lg border p-6">
            <div class="text-center mb-6">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                     :class="quizResult.passed ? 'bg-green-100' : 'bg-red-100'">
                    <i :class="quizResult.passed ? 'fas fa-check text-green-600' : 'fas fa-times text-red-600'" class="text-3xl"></i>
                </div>

                <h2 class="text-2xl font-bold mb-2" :class="quizResult.passed ? 'text-green-600' : 'text-red-600'">
                    <span x-text="quizResult.passed ? 'Chúc mừng! Bạn đã đạt' : 'Chưa đạt yêu cầu'"></span>
                </h2>

                <div class="text-3xl font-bold mb-2" :class="quizResult.passed ? 'text-green-600' : 'text-red-600'">
                    <span x-text="quizResult.score"></span>%
                </div>

                <p class="text-gray-600">
                    Bạn trả lời đúng <span x-text="quizResult.correct_answers"></span> / <span x-text="quizResult.total_questions"></span> câu
                </p>
            </div>

            <!-- Score Breakdown -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <div class="text-xl font-bold text-blue-600" x-text="quizResult.score + '%'"></div>
                    <div class="text-sm text-blue-800">Điểm của bạn</div>
                </div>
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <div class="text-xl font-bold text-green-600">{{ $quiz->passing_score }}%</div>
                    <div class="text-sm text-green-800">Điểm yêu cầu</div>
                </div>
                <div class="text-center p-3 bg-orange-50 rounded-lg">
                    <div class="text-xl font-bold text-orange-600" x-text="quizResult.correct_answers"></div>
                    <div class="text-sm text-orange-800">Câu đúng</div>
                </div>
                <div class="text-center p-3 bg-purple-50 rounded-lg">
                    <div class="text-xl font-bold text-purple-600" x-text="quizResult.earned_points + '/' + quizResult.total_points"></div>
                    <div class="text-sm text-purple-800">Điểm số</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center space-x-4">
                <button @click="retryQuiz"
                        x-show="!quizResult.passed && canRetry"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-redo mr-2"></i>
                    Làm lại
                </button>

                <button @click="window.location.reload()"
                        x-show="quizResult.passed"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Tiếp tục học
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function quizViewer() {
        return {
            quizStarted: false,
            showResults: false,
            answers: {},
            quizResult: {},
            timeLeft: {{ $quiz->time_limit ? $quiz->time_limit * 60 : 0 }},
            totalTime: {{ $quiz->time_limit ? $quiz->time_limit * 60 : 0 }},
            timer: null,
            canRetry: {{ $quizProgress && $quizProgress->quiz_attempts < $quiz->max_attempts ? 'true' : 'false' }},

            startQuiz() {
                this.quizStarted = true;
                this.showResults = false;
                this.answers = {};

                // Khởi tạo answers cho multiple choice
                @foreach($quiz->questions as $question)
                    @if($question->type === 'multiple_choice')
                    this.answers[{{ $question->id }}] = [];
                @endif
                @endforeach

                // Start timer if needed
                if (this.timeLeft > 0) {
                    this.startTimer();
                }
            },

            startTimer() {
                this.timer = setInterval(() => {
                    this.timeLeft--;
                    if (this.timeLeft <= 0) {
                        this.submitQuiz();
                    }
                }, 1000);
            },

            formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            },

            toggleMultipleChoice(questionId, optionId) {
                if (!this.answers[questionId]) {
                    this.answers[questionId] = [];
                }

                const index = this.answers[questionId].indexOf(optionId);
                if (index > -1) {
                    this.answers[questionId].splice(index, 1);
                } else {
                    this.answers[questionId].push(optionId);
                }
            },

            isMultipleChoiceSelected(questionId, optionId) {
                return this.answers[questionId] && this.answers[questionId].includes(optionId);
            },

            getOptionClass(questionId, optionId) {
                if (!this.showResults) {
                    if (this.answers[questionId] === optionId || this.isMultipleChoiceSelected(questionId, optionId)) {
                        return 'selected';
                    }
                    return '';
                }

                // Show correct/incorrect after submission
                const isCorrect = this.isOptionCorrect(questionId, optionId);
                const isSelected = this.answers[questionId] === optionId || this.isMultipleChoiceSelected(questionId, optionId);

                if (isCorrect) {
                    return 'correct';
                } else if (isSelected && !isCorrect) {
                    return 'incorrect';
                }

                return '';
            },

            isOptionCorrect(questionId, optionId) {
                // This would need to be populated from server data
                // For now, we'll implement it in the backend response
                return false;
            },

            submitQuiz() {
                if (this.timer) {
                    clearInterval(this.timer);
                }

                fetch('/api/learning/submit-quiz', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken
                    },
                    body: JSON.stringify({
                        quiz_id: {{ $quiz->id }},
                        answers: this.answers
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.quizResult = data.result;
                            this.showResults = true;
                        } else {
                            alert('Có lỗi xảy ra: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting quiz:', error);
                        alert('Có lỗi xảy ra khi nộp bài');
                    });
            },

            retryQuiz() {
                this.startQuiz();
            }
        }
    }
</script>
