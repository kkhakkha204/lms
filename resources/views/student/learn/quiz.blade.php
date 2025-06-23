<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="quizViewer()">
    <div class="max-w-4xl mx-auto p-4 md:p-8">
        <!-- Quiz Header -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-[#1c1c1c] via-[#7e0202] to-[#ed292a] p-8 text-white">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $quiz->title }}</h1>
                @if($quiz->description)
                    <p class="text-gray-100 text-lg opacity-90">{{ $quiz->description }}</p>
                @endif
            </div>

            <div class="p-8">
                <!-- Quiz Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $quiz->questions->count() }}</div>
                        <div class="text-sm text-blue-500 font-medium">Câu hỏi</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="text-2xl font-bold text-green-600 mb-1">{{ $quiz->passing_score }}%</div>
                        <div class="text-sm text-green-500 font-medium">Điểm đạt</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-xl border border-orange-100">
                        <div class="text-2xl font-bold text-orange-600 mb-1">{{ $quiz->time_limit ?? '∞' }}</div>
                        <div class="text-sm text-orange-500 font-medium">Phút</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="text-2xl font-bold text-purple-600 mb-1">{{ $quiz->max_attempts }}</div>
                        <div class="text-sm text-purple-500 font-medium">Lần làm</div>
                    </div>
                </div>

                <!-- Previous Attempts -->
                @php
                    $quizProgress = $progress['quiz_' . $quiz->id] ?? null;
                @endphp

                @if($quizProgress && $quizProgress->quiz_attempts > 0)
                    <div class="bg-gray-900 rounded-xl p-6 mb-8 text-white">
                        <h3 class="font-semibold text-lg mb-4 flex items-center">
                            <i class="fas fa-history mr-2 text-[#ed292a]"></i>
                            Lần làm trước
                        </h3>
                        <div class="flex items-center justify-between text-sm">
                            <span>Lần thử: {{ $quizProgress->quiz_attempts }}/{{ $quiz->max_attempts }}</span>
                            <span class="font-bold {{ $quizProgress->quiz_passed ? 'text-green-400' : 'text-[#ed292a]' }}">
                                {{ number_format($quizProgress->quiz_score, 1) }}%
                            </span>
                            @if($quizProgress->quiz_passed)
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-check mr-1"></i>Đã đạt
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Instructions -->
                @if($quiz->instructions)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-r-xl p-6 mb-8">
                        <h3 class="font-semibold text-yellow-800 mb-2 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Hướng dẫn
                        </h3>
                        <p class="text-yellow-700">{{ $quiz->instructions }}</p>
                    </div>
                @endif

                <!-- Start Button -->
                <div class="text-center" x-show="!quizStarted">
                    @if(!$quizProgress || $quizProgress->quiz_attempts < $quiz->max_attempts)
                        <button @click="startQuiz"
                                class="bg-gradient-to-r from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-play mr-2"></i>
                            {{ $quizProgress ? 'Làm lại bài quiz' : 'Bắt đầu làm bài' }}
                        </button>
                    @else
                        <div class="text-center p-6 bg-red-50 rounded-xl border border-red-200">
                            <i class="fas fa-exclamation-triangle text-[#ed292a] text-2xl mb-2"></i>
                            <p class="text-[#ed292a] font-medium">Bạn đã hết số lần làm bài cho quiz này.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quiz Content -->
        <div x-show="quizStarted && !showResults" class="space-y-6">
            <!-- Timer -->
            @if($quiz->time_limit)
                <div class="bg-white rounded-xl shadow-lg border p-4 sticky top-4 z-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-clock mr-2"></i>Thời gian còn lại:
                        </span>
                        <span class="text-xl font-bold" :class="timeLeft <= 300 ? 'text-[#ed292a]' : 'text-[#1c1c1c]'" x-text="formatTime(timeLeft)"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-1000"
                             :class="timeLeft <= 300 ? 'bg-[#ed292a]' : 'bg-[#7e0202]'"
                             :style="`width: ${Math.max(0, (timeLeft / totalTime) * 100)}%`"></div>
                    </div>
                </div>
            @endif

            <!-- Questions -->
            @foreach($quiz->questions as $index => $question)
                <div class="bg-white rounded-xl shadow-lg border p-6">
                    <div class="flex items-start mb-6">
                        <span class="w-8 h-8 bg-[#1c1c1c] text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0">{{ $index + 1 }}</span>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $question->question }}</h3>
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">{{ $question->points }} điểm</span>
                        </div>
                    </div>

                    <!-- Single Choice / True False -->
                    @if(in_array($question->type, ['single_choice', 'true_false']))
                        <div class="space-y-3">
                            @foreach($question->options as $optionIndex => $option)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all hover:bg-gray-50"
                                       :class="answers[{{ $question->id }}] == {{ $option->id }} ? 'border-[#ed292a] bg-red-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="selectSingleChoice({{ $question->id }}, {{ $option->id }})">
                                    <div class="w-4 h-4 border-2 rounded-full mr-3 flex items-center justify-center"
                                         :class="answers[{{ $question->id }}] == {{ $option->id }} ? 'border-[#ed292a] bg-[#ed292a]' : 'border-gray-300'">
                                        <div class="w-2 h-2 bg-white rounded-full" x-show="answers[{{ $question->id }}] == {{ $option->id }}"></div>
                                    </div>
                                    <span class="font-medium mr-3 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-sm text-gray-600">{{ chr(65 + $optionIndex) }}</span>
                                    <span class="text-gray-800">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <!-- Multiple Choice -->
                    @if($question->type === 'multiple_choice')
                        <div class="space-y-3">
                            @foreach($question->options as $optionIndex => $option)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all hover:bg-gray-50"
                                       :class="isMultipleChoiceSelected({{ $question->id }}, {{ $option->id }}) ? 'border-[#ed292a] bg-red-50' : 'border-gray-200 hover:border-gray-300'"
                                       @click="toggleMultipleChoice({{ $question->id }}, {{ $option->id }})">
                                    <div class="w-4 h-4 border-2 rounded mr-3 flex items-center justify-center"
                                         :class="isMultipleChoiceSelected({{ $question->id }}, {{ $option->id }}) ? 'border-[#ed292a] bg-[#ed292a]' : 'border-gray-300'">
                                        <i class="fas fa-check text-white text-xs" x-show="isMultipleChoiceSelected({{ $question->id }}, {{ $option->id }})"></i>
                                    </div>
                                    <span class="font-medium mr-3 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-sm text-gray-600">{{ chr(65 + $optionIndex) }}</span>
                                    <span class="text-gray-800">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <!-- Fill in the Blank -->
                    @if($question->type === 'fill_blank')
                        <input type="text"
                               x-model="answers[{{ $question->id }}]"
                               placeholder="Nhập câu trả lời..."
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#ed292a] focus:ring-1 focus:ring-[#ed292a] outline-none transition-colors">
                    @endif
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="text-center py-6">
                <button @click="submitQuiz"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-colors shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Nộp bài
                </button>
            </div>
        </div>

        <!-- Results -->
        <div x-show="showResults" class="space-y-8">
            <!-- Score Card -->
            <div class="bg-white rounded-2xl shadow-xl border p-8 text-center">
                <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center"
                     :class="quizResult.passed ? 'bg-green-500' : 'bg-[#ed292a]'">
                    <i :class="quizResult.passed ? 'fas fa-trophy' : 'fas fa-times'" class="text-white text-3xl"></i>
                </div>

                <h2 class="text-3xl font-bold mb-4" :class="quizResult.passed ? 'text-green-600' : 'text-[#ed292a]'">
                    <span x-text="quizResult.passed ? 'Chúc mừng! Bạn đã đạt' : 'Chưa đạt yêu cầu'"></span>
                </h2>

                <div class="text-5xl font-bold mb-6" :class="quizResult.passed ? 'text-green-600' : 'text-[#ed292a]'">
                    <span x-text="Math.round(quizResult.score)"></span>%
                </div>

                <p class="text-gray-600 text-lg mb-8">
                    Bạn trả lời đúng <span class="font-bold text-[#1c1c1c]" x-text="quizResult.correct_answers"></span>
                    / <span class="font-bold text-[#1c1c1c]" x-text="quizResult.total_questions"></span> câu
                </p>

                <!-- Score Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <div class="text-xl font-bold text-blue-600" x-text="Math.round(quizResult.score) + '%'"></div>
                        <div class="text-sm text-blue-500">Điểm số</div>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl">
                        <div class="text-xl font-bold text-green-600">{{ $quiz->passing_score }}%</div>
                        <div class="text-sm text-green-500">Yêu cầu</div>
                    </div>
                    <div class="p-4 bg-orange-50 rounded-xl">
                        <div class="text-xl font-bold text-orange-600" x-text="quizResult.correct_answers"></div>
                        <div class="text-sm text-orange-500">Câu đúng</div>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl">
                        <div class="text-xl font-bold text-purple-600" x-text="quizResult.earned_points + '/' + quizResult.total_points"></div>
                        <div class="text-sm text-purple-500">Điểm</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4">
                    <button x-show="!quizResult.passed && canRetry" @click="retryQuiz"
                            class="bg-[#7e0202] hover:bg-[#ed292a] text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-redo mr-2"></i>Làm lại
                    </button>
                    <button x-show="quizResult.passed" @click="window.location.reload()"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-arrow-right mr-2"></i>Tiếp tục
                    </button>
                </div>
            </div>

            <!-- Review Questions -->
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-[#1c1c1c] flex items-center">
                    <i class="fas fa-list-check mr-3 text-[#ed292a]"></i>
                    Xem lại đáp án
                </h3>

                @foreach($quiz->questions as $index => $question)
                    <div class="bg-white rounded-xl shadow-lg border p-6">
                        <div class="flex items-start mb-6">
                            <span class="w-8 h-8 bg-[#1c1c1c] text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0">{{ $index + 1 }}</span>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $question->question }}</h4>
                            </div>
                            <span :class="isQuestionCorrect({{ $question->id }}) ? 'text-green-600' : 'text-[#ed292a]'">
                                <i :class="isQuestionCorrect({{ $question->id }}) ? 'fas fa-check-circle' : 'fas fa-times-circle'" class="text-xl"></i>
                            </span>
                        </div>

                        <!-- Review Options -->
                        <div class="space-y-2 mb-4">
                            @foreach($question->options as $optionIndex => $option)
                                <div class="flex items-center p-3 rounded-lg border"
                                     :class="getReviewClass({{ $question->id }}, {{ $option->id }}, {{ $option->is_correct ? 'true' : 'false' }})">
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium mr-3"
                                          :class="getReviewIconClass({{ $question->id }}, {{ $option->id }}, {{ $option->is_correct ? 'true' : 'false' }})">
                                        {{ chr(65 + $optionIndex) }}
                                    </span>
                                    <span class="flex-1">{{ $option->option_text }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span x-show="wasUserAnswer({{ $question->id }}, {{ $option->id }})"
                                              class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Bạn chọn</span>
                                        @if($option->is_correct)
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Đúng
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Explanation -->
                        @if($question->explanation)
                            <div class="bg-blue-50 border-l-4 border-blue-400 rounded-r-lg p-4">
                                <h5 class="font-semibold text-blue-900 mb-2">
                                    <i class="fas fa-lightbulb mr-1"></i> Giải thích:
                                </h5>
                                <p class="text-blue-800">{{ $question->explanation }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
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

                // Initialize multiple choice answers
                @foreach($quiz->questions as $question)
                    @if($question->type === 'multiple_choice')
                    this.answers[{{ $question->id }}] = [];
                @endif
                    @endforeach

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

            selectSingleChoice(questionId, optionId) {
                this.answers[questionId] = optionId;
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

            wasUserAnswer(questionId, optionId) {
                const userAnswer = this.answers[questionId];
                if (Array.isArray(userAnswer)) {
                    return userAnswer.includes(optionId);
                }
                return userAnswer == optionId;
            },

            isQuestionCorrect(questionId) {
                return this.quizResult.question_results && this.quizResult.question_results[questionId];
            },

            getReviewClass(questionId, optionId, isCorrect) {
                if (!this.showResults) return '';

                const wasSelected = this.wasUserAnswer(questionId, optionId);

                if (isCorrect === 'true' && wasSelected) {
                    return 'border-green-300 bg-green-50';
                } else if (isCorrect === 'true') {
                    return 'border-green-300 bg-green-50';
                } else if (wasSelected) {
                    return 'border-red-300 bg-red-50';
                }
                return 'border-gray-200 bg-gray-50';
            },

            getReviewIconClass(questionId, optionId, isCorrect) {
                if (!this.showResults) return '';

                const wasSelected = this.wasUserAnswer(questionId, optionId);

                if (isCorrect === 'true') {
                    return 'bg-green-500 text-white';
                } else if (wasSelected) {
                    return 'bg-red-500 text-white';
                }
                return 'bg-gray-300 text-gray-600';
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
                        console.log('API Response:', data); // Debug log

                        if (data.success) {
                            // Đảm bảo dữ liệu đúng format
                            this.quizResult = {
                                score: parseFloat(data.result.score) || 0,
                                earned_points: parseInt(data.result.earned_points) || 0,
                                total_points: parseInt(data.result.total_points) || 0,
                                correct_answers: parseInt(data.result.correct_answers) || 0,
                                total_questions: parseInt(data.result.total_questions) || 0,
                                passed: Boolean(data.result.passed),
                                passing_score: parseFloat(data.result.passing_score) || 0,
                                question_results: data.result.question_results || {}
                            };

                            console.log('Processed quizResult:', this.quizResult); // Debug log

                            this.showResults = true;

                            setTimeout(() => {
                                document.querySelector('[x-show="showResults"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 100);

                            if (this.quizResult.passed && data.course_completed) {
                                setTimeout(() => {
                                    this.showCompletionNotification();
                                    setTimeout(() => {
                                        window.location.href = `/learn/{{ $quiz->course->slug }}/summary`;
                                    }, 3000);
                                }, 2000);
                            }
                        } else {
                            alert('Có lỗi xảy ra: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi nộp bài');
                    });
            },

            retryQuiz() {
                this.startQuiz();
            },

            showCompletionNotification() {
                const notification = document.createElement('div');
                notification.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                notification.innerHTML = `
                <div class="bg-white rounded-xl p-8 max-w-sm mx-4 text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">🎉 Chúc mừng!</h3>
                    <p class="text-gray-600 mb-4">Bạn đã hoàn thành khóa học!</p>
                    <p class="text-sm text-gray-500">Đang chuyển đến trang tổng kết...</p>
                </div>
            `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 3000);
            }
        }
    }
</script>
