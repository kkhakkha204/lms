{{-- Redesigned ChatBot Component for Logged-in Users --}}
<!-- ChatBot Toggle Button -->
<div id="chatbot-toggle" class="fixed bottom-6 right-6 z-50">
    <button class="bg-gradient-to-tr from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] text-white rounded-full w-14 h-14 shadow-xl transition-all duration-300 flex items-center justify-center group hover:scale-105 active:scale-95">
        <i class="fas fa-comments text-lg group-hover:scale-110 transition-transform"></i>
        <span class="absolute -top-12 right-0 bg-[#1c1c1c] text-white text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap shadow-lg">
            Tư vấn khóa học
        </span>
    </button>
</div>

<!-- ChatBot Window -->
<div id="chatbot-window" class="fixed bottom-24 right-6 w-80 h-[500px] bg-white rounded-2xl shadow-2xl z-40 transform translate-y-full opacity-0 transition-all duration-300 border border-gray-100">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#1c1c1c] to-[#2a2a2a] text-white p-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-8 h-8 bg-gradient-to-tr from-[#7e0202] to-[#ed292a] rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-[#ed292a] rounded-full border-2 border-white"></div>
                </div>
                <div>
                    <h3 class="font-medium text-sm">AI Tư vấn</h3>
                    <p class="text-xs opacity-80 flex items-center">
                        <span class="w-1.5 h-1.5 bg-[#ed292a] rounded-full mr-2 animate-pulse"></span>
                        Trực tuyến
                    </p>
                </div>
            </div>
            <button id="chatbot-close" class="text-white hover:text-gray-300 p-1.5 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Messages Container -->
    <div id="messages-container" class="h-80 overflow-y-auto p-4 space-y-3 bg-gray-50">
        <!-- Welcome Message -->
        <div class="flex items-start space-x-2 animate-fade-in">
            <div class="w-6 h-6 bg-gradient-to-tr from-[#7e0202] to-[#ed292a] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                <i class="fas fa-robot text-white text-xs"></i>
            </div>
            <div class="bg-white rounded-xl p-3 max-w-[220px] shadow-sm border border-gray-100">
                <p class="text-xs text-[#1c1c1c] leading-relaxed">
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
    <div id="quick-actions" class="px-4 py-2 border-t border-gray-100 bg-white">
        <p class="text-xs text-gray-500 mb-2">Gợi ý câu hỏi:</p>
        <div class="flex flex-wrap gap-1.5">
            <button class="quick-action-btn bg-gray-100 hover:bg-[#7e0202] text-[#1c1c1c] hover:text-white px-2.5 py-1 rounded-lg text-xs transition-all duration-200 transform hover:scale-105"
                    data-message="Cho tôi xem các khóa học phổ biến nhất">
                🔥 Khóa học hot
            </button>
            <button class="quick-action-btn bg-gray-100 hover:bg-[#7e0202] text-[#1c1c1c] hover:text-white px-2.5 py-1 rounded-lg text-xs transition-all duration-200 transform hover:scale-105"
                    data-message="Tôi là người mới bắt đầu, nên học khóa nào?">
                🌱 Người mới
            </button>
            <button class="quick-action-btn bg-gray-100 hover:bg-[#7e0202] text-[#1c1c1c] hover:text-white px-2.5 py-1 rounded-lg text-xs transition-all duration-200 transform hover:scale-105"
                    data-message="Có khóa học miễn phí nào không?">
                🆓 Miễn phí
            </button>
            <button class="quick-action-btn bg-gray-100 hover:bg-[#7e0202] text-[#1c1c1c] hover:text-white px-2.5 py-1 rounded-lg text-xs transition-all duration-200 transform hover:scale-105"
                    data-message="Tôi muốn học lập trình, bắt đầu từ đâu?">
                💻 Lập trình
            </button>
        </div>
    </div>

    <!-- Input Area -->
    <div class="p-4 border-t border-gray-100 bg-white rounded-b-2xl">
        <div class="flex space-x-2">
            <input
                type="text"
                id="message-input"
                placeholder="Nhập câu hỏi của bạn..."
                class="flex-1 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#ed292a] focus:border-transparent text-xs placeholder-gray-400"
                maxlength="500"
            >
            <button
                id="send-button"
                class="bg-gradient-to-tr from-[#7e0202] to-[#ed292a] hover:from-[#ed292a] hover:to-[#7e0202] text-white px-3 py-2 rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95"
                title="Gửi tin nhắn"
            >
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </div>

        <!-- Character counter and typing indicator -->
        <div class="flex justify-between items-center mt-2">
            <div id="typing-indicator" class="hidden">
                <div class="flex items-center space-x-2 text-gray-400 text-xs">
                    <div class="flex space-x-1">
                        <div class="w-1.5 h-1.5 bg-[#ed292a] rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-[#ed292a] rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-1.5 h-1.5 bg-[#ed292a] rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                    <span>AI đang suy nghĩ...</span>
                </div>
            </div>
            <div id="char-counter" class="text-xs text-gray-400">0/500</div>
        </div>
    </div>
</div>

<!-- Custom CSS for Redesigned User ChatBot -->
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    #messages-container::-webkit-scrollbar {
        width: 3px;
    }

    #messages-container::-webkit-scrollbar-track {
        background: transparent;
    }

    #messages-container::-webkit-scrollbar-thumb {
        background: #ed292a;
        border-radius: 3px;
    }

    #messages-container::-webkit-scrollbar-thumb:hover {
        background: #7e0202;
    }

    /* Elegant hover effects */
    .quick-action-btn:hover {
        box-shadow: 0 4px 12px rgba(126, 2, 2, 0.25);
    }

    #chatbot-toggle button:hover {
        box-shadow: 0 8px 25px rgba(237, 41, 42, 0.4);
    }

    /* Mobile responsive */
    @media (max-width: 640px) {
        #chatbot-window {
            width: calc(100vw - 2rem);
            right: 1rem;
            left: 1rem;
            bottom: 6rem;
            height: 450px;
        }

        #chatbot-toggle {
            bottom: 1rem;
            right: 1rem;
        }

        #messages-container {
            height: 280px;
        }
    }

    /* Message styles */
    .user-message {
        background: linear-gradient(135deg, #7e0202, #ed292a);
        color: white;
        margin-left: auto;
    }

    .bot-message {
        background: white;
        border: 1px solid #f0f0f0;
    }

    .error-message {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #7e0202;
    }
</style>

<!-- Redesigned User ChatBot JavaScript -->
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
                    this.charCounter.classList.add('text-[#ed292a]');
                    this.charCounter.classList.remove('text-gray-400');
                } else {
                    this.charCounter.classList.remove('text-[#ed292a]');
                    this.charCounter.classList.add('text-gray-400');
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

            // Click outside to close (optional)
            document.addEventListener('click', (e) => {
                const chatbotWindow = document.getElementById('chatbot-window');
                const chatbotToggle = document.getElementById('chatbot-toggle');

                if (this.isOpen && !chatbotWindow.contains(e.target) && !chatbotToggle.contains(e.target)) {
                    // Uncomment if you want click outside to close
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
            messageDiv.className = 'flex items-start space-x-2 animate-fade-in';

            const timestamp = new Date().toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            if (sender === 'user') {
                messageDiv.innerHTML = `
                <div class="flex-1"></div>
                <div class="user-message rounded-xl p-3 max-w-[200px] shadow-sm">
                    <p class="text-xs">${this.escapeHtml(message)}</p>
                    <p class="text-xs opacity-75 mt-1">${timestamp}</p>
                </div>
                <div class="w-6 h-6 bg-[#1c1c1c] rounded-full flex items-center justify-center text-white text-xs font-medium flex-shrink-0 mt-1">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}
                </div>
            `;
            } else {
                let messageClass = 'bot-message';

                if (type === 'error') {
                    messageClass = 'error-message';
                }

                messageDiv.innerHTML = `
                <div class="w-6 h-6 bg-gradient-to-tr from-[#7e0202] to-[#ed292a] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="${messageClass} rounded-xl p-3 max-w-[220px] shadow-sm">
                    <p class="text-xs leading-relaxed">${this.formatMessage(message)}</p>
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
            message = message.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="text-[#ed292a] hover:underline">$1</a>');

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
                    btn.className = 'quick-action-btn bg-gray-100 hover:bg-[#7e0202] text-[#1c1c1c] hover:text-white px-2.5 py-1 rounded-lg text-xs transition-all duration-200 transform hover:scale-105';
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
