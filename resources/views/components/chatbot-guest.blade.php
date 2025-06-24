{{-- ChatBot Component for Guest Users --}}
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
        <!-- Welcome Message for Guest -->
        <div class="flex items-start space-x-3 animate-fade-in">
            <img src="https://via.placeholder.com/32x32/3B82F6/ffffff?text=AI" alt="AI" class="w-8 h-8 rounded-full">
            <div class="bg-white rounded-lg p-3 max-w-xs shadow-sm border">
                <p class="text-sm text-gray-700">
                    👋 Xin chào! Tôi là AI tư vấn khóa học.
                    <br><br>
                    Tôi có thể giúp bạn tìm hiểu về các khóa học của chúng tôi.
                    <br><br>
                    💡 <strong>Gợi ý:</strong> Hãy <a href="{{ route('register') }}" class="text-blue-600 hover:underline">đăng ký tài khoản</a> để nhận tư vấn cá nhân hóa và theo dõi tiến trình học tập!
                    <br><br>
                    Bạn muốn tìm hiểu về khóa học nào? 😊
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Actions for Guest -->
    <div id="quick-actions" class="px-4 py-2 border-t bg-white">
        <p class="text-xs text-gray-500 mb-2">Khám phá ngay:</p>
        <div class="flex flex-wrap gap-2">
            <button class="quick-action-btn bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs hover:bg-blue-200 transition-all transform hover:scale-105"
                    data-message="Có những khóa học gì?">
                📚 Tất cả khóa học
            </button>
            <button class="quick-action-btn bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs hover:bg-green-200 transition-all transform hover:scale-105"
                    data-message="Khóa học nào phù hợp cho người mới?">
                🌱 Người mới
            </button>
            <button class="quick-action-btn bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs hover:bg-purple-200 transition-all transform hover:scale-105"
                    data-message="Giá khóa học như thế nào?">
                💰 Bảng giá
            </button>
            <button class="quick-action-btn bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs hover:bg-orange-200 transition-all transform hover:scale-105"
                    data-action="register">
                🚀 Đăng ký ngay
            </button>
        </div>
    </div>

    <!-- Input Area -->
    <div class="p-4 border-t bg-white rounded-b-lg">
        <div class="flex space-x-2">
            <input
                type="text"
                id="message-input"
                placeholder="Hỏi về khóa học..."
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

        <!-- Character counter and login prompt -->
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
            <div class="text-right">
                <div id="char-counter" class="text-xs text-gray-400">0/500</div>
                <a href="{{ route('login') }}" class="text-xs text-blue-600 hover:underline">Đăng nhập để trải nghiệm đầy đủ</a>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Guest ChatBot -->
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

<!-- Guest ChatBot JavaScript -->
<script>
    class GuestChatBot {
        constructor() {
            this.isOpen = false;
            this.messagesContainer = document.getElementById('messages-container');
            this.messageInput = document.getElementById('message-input');
            this.sendButton = document.getElementById('send-button');
            this.typingIndicator = document.getElementById('typing-indicator');
            this.charCounter = document.getElementById('char-counter');
            this.messageCount = 0;
            this.maxGuestMessages = 5; // Giới hạn tin nhắn cho guest

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
                    const action = e.target.getAttribute('data-action');

                    if (action === 'register') {
                        window.location.href = '{{ route("register") }}';
                        return;
                    }

                    if (message) {
                        this.messageInput.value = message;
                        this.sendMessage();
                    }
                });
            });
        }

        toggleChatbot() {
            const window = document.getElementById('chatbot-window');
            this.isOpen = !this.isOpen;

            if (this.isOpen) {
                window.classList.remove('translate-y-full', 'opacity-0');
                window.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => this.messageInput.focus(), 300);
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
        }

        async sendMessage() {
            const message = this.messageInput.value.trim();
            if (!message) return;

            // Check message limit for guest users
            if (this.messageCount >= this.maxGuestMessages) {
                this.showLimitMessage();
                return;
            }

            this.messageCount++;
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
                    body: JSON.stringify({ message, is_guest: true })
                });

                const data = await response.json();
                this.hideTypingIndicator();

                if (data.success) {
                    this.addMessage(data.message, 'bot');

                    // Show login prompt after a few messages
                    if (this.messageCount >= 3) {
                        setTimeout(() => {
                            this.addLoginPrompt();
                        }, 2000);
                    }
                } else {
                    this.addMessage('❌ Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.', 'bot', 'error');
                }

            } catch (error) {
                console.error('ChatBot Error:', error);
                this.hideTypingIndicator();
                this.addMessage('🔌 Không thể kết nối với server. Vui lòng thử lại sau.', 'bot', 'error');
            }

            this.setInputState(true);
        }

        showLimitMessage() {
            this.addMessage(`
            🚫 <strong>Bạn đã đạt giới hạn tin nhắn cho tài khoản khách!</strong>
            <br><br>
            Để tiếp tục trò chuyện và nhận tư vấn không giới hạn:
            <br>
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg mt-2 hover:bg-blue-700 transition-colors">
                🚀 Đăng ký miễn phí
            </a>
            <br>
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                Đã có tài khoản? Đăng nhập
            </a>
        `, 'bot', 'limit');
        }

        addLoginPrompt() {
            this.addMessage(`
            💎 <strong>Bạn có muốn trải nghiệm đầy đủ tính năng?</strong>
            <br><br>
            Khi đăng ký tài khoản, bạn sẽ có:
            <br>• 🎯 Tư vấn cá nhân hóa
            <br>• 📊 Theo dõi tiến trình học
            <br>• 💬 Chat không giới hạn
            <br>• 🎁 Ưu đãi độc quyền
            <br><br>
            <a href="{{ route('register') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                ✨ Đăng ký ngay - Miễn phí
            </a>
        `, 'bot', 'promotion');
        }

        setInputState(enabled) {
            this.messageInput.disabled = !enabled;
            this.sendButton.disabled = !enabled;

            if (enabled && this.messageCount < this.maxGuestMessages) {
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
                <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                    G
                </div>
            `;
            } else {
                let bgColor = 'bg-white border-gray-200';
                let textColor = 'text-gray-700';

                if (type === 'error') {
                    bgColor = 'bg-red-50 border-red-200';
                    textColor = 'text-red-700';
                } else if (type === 'limit') {
                    bgColor = 'bg-yellow-50 border-yellow-200';
                    textColor = 'text-yellow-800';
                } else if (type === 'promotion') {
                    bgColor = 'bg-green-50 border-green-200';
                    textColor = 'text-green-700';
                }

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
    }

    // Initialize guest chatbot when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        window.guestChatBot = new GuestChatBot();
    });
</script>
