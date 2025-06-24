<?php

namespace App\Http\Controllers;

use App\Services\ChatBotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatBotController extends Controller
{
    private $chatBotService;

    public function __construct(ChatBotService $chatBotService)
    {
        $this->chatBotService = $chatBotService;
    }

    /**
     * Hiển thị giao diện chatbot
     */
    public function index()
    {
        return view('chatbot.index');
    }

    /**
     * Xử lý tin nhắn từ user (cả auth và guest)
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'is_guest' => 'sometimes|boolean',
        ]);

        $userId = auth()->id();
        $message = $request->input('message');
        $isGuest = $request->input('is_guest', false);

        // Giới hạn cho guest users
        if (!$userId && $isGuest) {
            $sessionId = session()->getId();
            $guestMessageCount = session()->get("guest_messages_{$sessionId}", 0);

            if ($guestMessageCount >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã đạt giới hạn tin nhắn. Vui lòng đăng ký tài khoản để tiếp tục.',
                    'limit_reached' => true
                ]);
            }

            session()->put("guest_messages_{$sessionId}", $guestMessageCount + 1);
        }

        $response = $this->chatBotService->processMessage($message, $userId, $isGuest);

        return response()->json($response);
    }

    /**
     * Lấy lịch sử chat (chỉ cho user đã đăng nhập)
     */
    public function getHistory(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Implement logic to get chat history from database
        // This would require a ChatHistory model

        return response()->json([
            'history' => []
        ]);
    }

    /**
     * Xóa lịch sử chat
     */
    public function deleteHistory($id): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Implement delete logic

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch sử chat'
        ]);
    }

    /**
     * Lấy gợi ý khóa học
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        $request->validate([
            'interest' => 'required|string|max:100',
        ]);

        $interest = $request->input('interest');
        $courses = $this->chatBotService->getRecommendedCourses($interest);

        return response()->json([
            'courses' => $courses
        ]);
    }

    /**
     * Lấy thông tin quick actions
     */
    public function getQuickActions(): JsonResponse
    {
        return response()->json([
            'actions' => [
                [
                    'id' => 'popular_courses',
                    'title' => 'Khóa học phổ biến',
                    'message' => 'Cho tôi xem các khóa học phổ biến nhất'
                ],
                [
                    'id' => 'beginner_courses',
                    'title' => 'Khóa học cho người mới',
                    'message' => 'Tôi là người mới bắt đầu, nên học khóa nào?'
                ],
                [
                    'id' => 'free_courses',
                    'title' => 'Khóa học miễn phí',
                    'message' => 'Có khóa học miễn phí nào không?'
                ],
                [
                    'id' => 'programming_courses',
                    'title' => 'Khóa học lập trình',
                    'message' => 'Tôi muốn học lập trình, bắt đầu từ đâu?'
                ]
            ]
        ]);
    }
}
