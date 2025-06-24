{{-- ChatBot Component --}}
<!-- ChatBot Toggle Button -->
<div id="chatbot-toggle" class="fixed bottom-6 right-6 z-50">
    <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-16 h-16 shadow-lg transition-all duration-300 flex items-center justify-center group">
        <i class="fas fa-comments text-xl group-hover:scale-110 transition-transform"></i>
        <span class="absolute -top-12 right-0 bg-gray-800 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
            Tư vấn khóa học
        </span>
    </button>
</div>

<!-- ChatBot Window -->
<div id="chatbot-window" class="fixed bottom-24 right-6 w-96 h-[600px] bg-white rounded-lg shadow-2xl z-40 transform translate-y-full opacity-0 transition-all duration-300">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-t-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="https://via.placeholder.com/40x40/3B82F6/ffffff?text=AI" alt="AI" class="w-10 h-10 rounded-full">
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                </div>
                <div>
                    <h3 class="font-semibold">AI Tư vấn khóa học</h3>
                    <p class="text-sm opacity-90 flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        Trực tuyến
                    </p>
                </div>
            </div>
            <button id="chatbot-close" class="text-white hover:text-gray-200 p-1 rounded hover:bg-white hover:bg-opacity-20 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Messages Container -->
    <div id="messages-container" class="h-96 overflow-y-auto p-4 space-y-4 bg-gray-50">
        <!-- Welcome Message -->
        <div class="flex items-start space-x-3 animate-fade-in">
            <img src="https://via.placeholder.com/32x32/3B82F6/ffffff?text=AI" alt="AI" class="w-8 h-8 rounded-full">
            <div class="bg-white rounded-lg p-3 max-w-xs shadow-sm border">
                <p class="text-sm text-gray-700">
                    👋 Xin chào! Tôi là AI tư vấn khóa học.
                    <br><br>
                    Tôi có thể giúp bạn:
                    <br>• 🔍 Tìm kiếm khóa học phù hợp
                    <br>• 💰 So sánh giá cả
                    <br>• 📝 Hướng dẫn đăng ký
                    <br>• 🎯 Gợi ý học tập
                    <br><br>
                    Bạn cần tư vấn gì? 😊
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div id="quick-actions" class="px-4 py-2 border-t bg-white">
        <p class="text-xs text-gray-500 mb-2">Gợi ý câu hỏi:</p>
        <div class="flex flex-wrap gap-2">
            <button class="quick-action-btn bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs hover:bg-blue-200 transition-all transform hover:scale-105"
                    data-message="Cho tôi xem các khóa học phổ biến nhất">
                🔥 Khóa học hot
            </button>
            <button class="quick-action-btn bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs hover:bg-green-200 transition-all transform hover:scale-105"
                    data-message="Tôi là người mới bắt đầu, nên học khóa nào?">
                🌱 Người mới
            </button>
            <button class="quick-action-btn bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs hover:bg-purple-200 transition-all transform hover:scale-105"
                    data-message="Có khóa học miễn phí nào không?">
                🆓 Miễn phí
            </button>
            <button class="quick-action-btn bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs hover:bg-orange-200 transition-all transform hover:scale-105"
                    data-message="Tôi muốn học lập trình, bắt đầu từ đâu?">
                💻 Lập trình
            </button>
        </div>
    </div>

    <!-- Input Area -->
    <div class="p-4 border-t bg-white rounded-b-lg">
        <div class="flex space-x-2">
            <input
                type="text"
                id="message-input"
                placeholder="Nhập câu hỏi của bạn..."
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                maxlength="500"
            >
            <button
                id="send-button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95"
                title="Gửi tin nhắn"
            >
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Character counter -->
        <div class="flex justify-between items-center mt-2">
            <div id="typing-indicator" class="hidden">
                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                    <span>AI đang suy nghĩ...</span>
                </div>
            </div>
            <div id="char-counter" class="text-xs text-gray-400">0/500</div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    #messages-container::-webkit-scrollbar {
        width: 4px;
    }

    #messages-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #messages-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    #messages-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Mobile responsive */
    @media (max-width: 640px) {
        #chatbot-window {
            width: calc(100vw - 2rem);
            right: 1rem;
            left: 1rem;
            bottom: 6rem;
        }

        #chatbot-toggle {
            bottom: 1rem;
            right: 1rem;
        }
    }
</style>

<!-- ChatBot JavaScript -->
<script>
    class ChatBot {
        constructor() {
            this.isOpen = false;
            this.messagesContainer = document.getElementById('messages-container');
            this.messageInput = document.getElementById('message-input');
            this.sendButton = document.getElementById('send-button');
            this.typingIndicator = document.getElementById('typing-indicator');
            this.charCounter = document.getElementById('char-counter');

            this.initEventListeners();
            this.setupCSRF();
        }

        setupCSRF() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        }

        initEventListeners() {
            // Toggle chatbot
            document.getElementById('chatbot-toggle').addEventListener('click', () => {
                this.toggleChatbot();
            });

            // Close chatbot
            document.getElementById('chatbot-close').addEventListener('click', () => {
                this.closeChatbot();
            });

            // Send message
            this.sendButton.addEventListener('click', () => {
                this.sendMessage();
            });

            // Enter key to send
            this.messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });

            // Character counter
            this.messageInput.addEventListener('input', (e) => {
                const length = e.target.value.length;
                this.charCounter.textContent = `${length}/500`;

                if (length > 450) {
                    this.charCounter.classList.add('text-red-500');
                } else {
                    this.charCounter.classList.remove('text-red-500');
                }
            });

            // Quick actions
            document.querySelectorAll('.quick-action-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const message = e.target.getAttribute('data-message');
                    this.messageInput.value = message;
                    this.sendMessage();
                });
            });

            // Click outside to close
            document.addEventListener('click', (e) => {
                const chatbotWindow = document.getElementById('chatbot-window');
                const chatbotToggle = document.getElementById('chatbot-toggle');

                if (this.isOpen && !chatbotWindow.contains(e.target) && !chatbotToggle.contains(e.target)) {
                    // Don't close immediately, add small delay
                    // this.closeChatbot();
                }
            });
        }

        toggleChatbot() {
            const window = document.getElementById('chatbot-window');
            this.isOpen = !this.isOpen;

            if (this.isOpen) {
                window.classList.remove('translate-y-full', 'opacity-0');
                window.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => this.messageInput.focus(), 300);

                // Track chatbot open event
                this.trackEvent('chatbot_opened');
            } else {
                window.classList.add('translate-y-full', 'opacity-0');
                window.classList.remove('translate-y-0', 'opacity-100');
            }
        }

        closeChatbot() {
            this.isOpen = false;
            const window = document.getElementById('chatbot-window');
            window.classList.add('translate-y-full', 'opacity-0');
            window.classList.remove('translate-y-0', 'opacity-100');

            this.trackEvent('chatbot_closed');
        }

        async sendMessage() {
            const message = this.messageInput.value.trim();
            if (!message) return;

            // Disable input và button
            this.setInputState(false);

            // Add user message
            this.addMessage(message, 'user');
            this.messageInput.value = '';
            this.charCounter.textContent = '0/500';

            // Show typing indicator
            this.showTypingIndicator();

            try {
                const response = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                this.hideTypingIndicator();

                if (data.success) {
                    this.addMessage(data.message, 'bot');
                    if (data.suggestions && data.suggestions.length > 0) {
                        this.updateQuickActions(data.suggestions);
                    }

                    this.trackEvent('message_sent', { message_length: message.length });
                } else {
                    this.addMessage('❌ Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.', 'bot', 'error');
                }

            } catch (error) {
                console.error('ChatBot Error:', error);
                this.hideTypingIndicator();
                this.addMessage('🔌 Không thể kết nối với server. Vui lòng kiểm tra kết nối mạng và thử lại.', 'bot', 'error');
            }

            this.setInputState(true);
        }

        setInputState(enabled) {
            this.messageInput.disabled = !enabled;
            this.sendButton.disabled = !enabled;

            if (enabled) {
                this.messageInput.focus();
            }
        }

        addMessage(message, sender, type = 'normal') {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex items-start space-x-3 animate-fade-in';

            const timestamp = new Date().toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            if (sender === 'user') {
                messageDiv.innerHTML = `
                <div class="flex-1"></div>
                <div class="bg-blue-600 text-white rounded-lg p-3 max-w-xs shadow-sm">
                    <p class="text-sm">${this.escapeHtml(message)}</p>
                    <p class="text-xs opacity-75 mt-1">${timestamp}</p>
                </div>
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}
                </div>
            `;
            } else {
                const bgColor = type === 'error' ? 'bg-red-50 border-red-200' : 'bg-white border-gray-200';
                const textColor = type === 'error' ? 'text-red-700' : 'text-gray-700';

                messageDiv.innerHTML = `
                <img src="https://via.placeholder.com/32x32/3B82F6/ffffff?text=AI" alt="AI" class="w-8 h-8 rounded-full">
                <div class="${bgColor} border rounded-lg p-3 max-w-xs shadow-sm">
                    <p class="text-sm ${textColor}">${this.formatMessage(message)}</p>
                    <p class="text-xs text-gray-400 mt-1">${timestamp}</p>
                </div>
            `;
            }

            this.messagesContainer.appendChild(messageDiv);
            this.scrollToBottom();
        }

        formatMessage(message) {
            // Convert line breaks to <br>
            message = message.replace(/\n/g, '<br>');

            // Convert **text** to bold
            message = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

            // Convert *text* to italic
            message = message.replace(/\*(.*?)\*/g, '<em>$1</em>');

            // Convert URLs to links
            message = message.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="text-blue-600 hover:underline">$1</a>');

            return message;
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        scrollToBottom() {
            setTimeout(() => {
                this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
            }, 100);
        }

        showTypingIndicator() {
            this.typingIndicator.classList.remove('hidden');
            this.scrollToBottom();
        }

        hideTypingIndicator() {
            this.typingIndicator.classList.add('hidden');
        }

        updateQuickActions(suggestions) {
            if (suggestions && suggestions.length > 0) {
                const quickActions = document.getElementById('quick-actions');
                const buttonsContainer = quickActions.querySelector('div:last-child');

                buttonsContainer.innerHTML = '';

                suggestions.forEach(suggestion => {
                    const btn = document.createElement('button');
                    btn.className = 'quick-action-btn bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs hover:bg-blue-200 transition-all transform hover:scale-105';
                    btn.setAttribute('data-message', suggestion);
                    btn.textContent = suggestion;

                    btn.addEventListener('click', (e) => {
                        const message = e.target.getAttribute('data-message');
                        this.messageInput.value = message;
                        this.sendMessage();
                    });

                    buttonsContainer.appendChild(btn);
                });
            }
        }

        trackEvent(eventName, data = {}) {
            // Track events for analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', eventName, {
                    'custom_parameter': data
                });
            }

            console.log('ChatBot Event:', eventName, data);
        }
    }

    // Initialize chatbot when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        window.chatBot = new ChatBot();
    });
</script>
