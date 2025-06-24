<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatBotService
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = config('services.gemini.url');
    }

    /**
     * Xử lý tin nhắn từ user và trả về phản hồi
     */
    public function processMessage(string $message, ?int $userId = null, bool $isGuest = false): array
    {
        try {
            // Lấy context từ database
            $context = $this->getContextData();

            // Tạo system prompt
            $systemPrompt = $this->createSystemPrompt($context, $userId, $isGuest);

            // Gọi Gemini API
            $response = $this->callGeminiAI($systemPrompt, $message);

            // Log conversation
            $this->logConversation($message, $response, $userId, $isGuest);

            return [
                'success' => true,
                'message' => $response,
                'suggestions' => $this->generateSuggestions($message, $isGuest)
            ];

        } catch (\Exception $e) {
            Log::error('ChatBot Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.',
                'suggestions' => []
            ];
        }
    }

    /**
     * Lấy dữ liệu context từ database
     */
    private function getContextData(): array
    {
        return [
            'categories' => Category::select('id', 'name', 'description')->get()->toArray(),
            'popular_courses' => Course::where('status', 'published')
                ->withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(10)
                ->get(['id', 'title', 'description', 'price', 'category_id'])
                ->toArray(),
            'course_stats' => [
                'total_courses' => Course::where('status', 'published')->count(),
                'total_categories' => Category::count(),
                'price_range' => [
                    'min' => Course::where('status', 'published')->min('price') ?? 0,
                    'max' => Course::where('status', 'published')->max('price') ?? 0
                ]
            ]
        ];
    }

    /**
     * Tạo system prompt cho AI
     */
    private function createSystemPrompt(array $context, ?int $userId = null, bool $isGuest = false): string
    {
        $userInfo = $userId ? User::find($userId) : null;

        $guestPrompt = $isGuest ? "
NGƯỜI DÙNG LÀ KHÁCH: Khuyến khích đăng ký tài khoản để có trải nghiệm tốt hơn.
GIỚI HẠN: Chỉ trả lời ngắn gọn, khuyến khích đăng ký sau 2-3 câu hỏi.
" : "";

        return "Bạn là AI chatbot tư vấn khóa học cho website E-Learning.

THÔNG TIN HỆ THỐNG:
- Tổng số khóa học: {$context['course_stats']['total_courses']}
- Số danh mục: {$context['course_stats']['total_categories']}
- Giá khóa học từ: " . number_format($context['course_stats']['price_range']['min']) . " - " . number_format($context['course_stats']['price_range']['max']) . " VND

DANH MỤC KHÓA HỌC:
" . collect($context['categories'])->map(fn($cat) => "- {$cat['name']}: {$cat['description']}")->join("\n") . "

KHÓA HỌC PHỔ BIẾN:
" . collect($context['popular_courses'])->map(fn($course) => "- {$course['title']} - Giá: " . number_format($course['price']) . " VND")->join("\n") . "

" . ($userInfo ? "THÔNG TIN NGƯỜI DÙNG: {$userInfo->name} - Email: {$userInfo->email}" : ($isGuest ? "NGƯỜI DÙNG: Khách chưa đăng ký" : "NGƯỜI DÙNG: Khách hàng chưa đăng nhập")) . "

{$guestPrompt}

NHIỆM VỤ:
1. Tư vấn khóa học phù hợp với nhu cầu
2. Giải đáp thắc mắc về khóa học, giá cả, nội dung
3. Hướng dẫn đăng ký, thanh toán
4. Gợi ý khóa học dựa trên sở thích
5. Trả lời bằng tiếng Việt, thân thiện và chuyên nghiệp

QUY TẮC:
- Chỉ tư vấn về các khóa học có trong hệ thống
- Đưa ra gợi ý cụ thể với tên khóa học và giá
- Khuyến khích đăng ký nếu phù hợp
- Nếu không có thông tin, hướng dẫn liên hệ admin
- Trả lời ngắn gọn, dễ hiểu (tối đa 200 từ)";
    }

    /**
     * Gọi Google Gemini API
     */
    private function callGeminiAI(string $systemPrompt, string $userMessage): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $systemPrompt . "\n\nCâu hỏi của người dùng: " . $userMessage
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.8,
                'maxOutputTokens' => 500,
            ],
            'safetySettings' => [
                [
                    'category' => 'HARM_CATEGORY_HARASSMENT',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
                [
                    'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
                [
                    'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return trim($data['candidates'][0]['content']['parts'][0]['text']);
            }

            // Fallback nếu có vấn đề với response structure
            throw new \Exception('Invalid response structure from Gemini API');
        }

        // Handle API errors
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? 'Unknown error';

        throw new \Exception('Gemini API call failed: ' . $errorMessage);
    }

    /**
     * Tạo gợi ý câu hỏi
     */
    private function generateSuggestions(string $message, bool $isGuest = false): array
    {
        if ($isGuest) {
            return [
                'Có những khóa học gì?',
                'Giá khóa học như thế nào?',
                'Đăng ký như thế nào?'
            ];
        }

        $suggestions = [
            'Khóa học nào phù hợp cho người mới bắt đầu?',
            'Khóa học nào có giá tốt nhất?',
            'Làm sao để đăng ký khóa học?',
            'Có khuyến mãi gì không?'
        ];

        // Gợi ý thông minh dựa trên nội dung tin nhắn
        $messageLower = strtolower($message);

        if (strpos($messageLower, 'giá') !== false || strpos($messageLower, 'tiền') !== false) {
            array_unshift($suggestions, 'Có khóa học miễn phí không?');
        }

        if (strpos($messageLower, 'lập trình') !== false || strpos($messageLower, 'code') !== false) {
            array_unshift($suggestions, 'Khóa học lập trình nào dễ học nhất?');
        }

        if (strpos($messageLower, 'thiết kế') !== false || strpos($messageLower, 'design') !== false) {
            array_unshift($suggestions, 'Khóa học thiết kế có những gì?');
        }

        return array_slice(array_unique($suggestions), 0, 3);
    }

    /**
     * Lưu log cuộc trò chuyện
     */
    private function logConversation(string $question, string $answer, ?int $userId, bool $isGuest = false): void
    {
        Log::info('ChatBot Conversation', [
            'user_id' => $userId,
            'is_guest' => $isGuest,
            'question' => $question,
            'answer' => $answer,
            'timestamp' => now(),
            'session_id' => session()->getId()
        ]);
    }

    /**
     * Lấy khóa học gợi ý dựa trên AI
     */
    public function getRecommendedCourses(string $userInterest): array
    {
        return Course::where('status', 'published')
            ->where(function($query) use ($userInterest) {
                $query->where('title', 'LIKE', "%{$userInterest}%")
                    ->orWhere('description', 'LIKE', "%{$userInterest}%");
            })
            ->with('category')
            ->take(5)
            ->get()
            ->toArray();
    }

    /**
     * Kiểm tra API key và kết nối
     */
    public function testConnection(): array
    {
        try {
            $response = $this->callGeminiAI(
                "Bạn là AI assistant. Trả lời ngắn gọn.",
                "Xin chào, bạn có hoạt động không?"
            );

            return [
                'success' => true,
                'message' => 'Kết nối thành công với Gemini API',
                'response' => $response
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi kết nối: ' . $e->getMessage()
            ];
        }
    }
}
