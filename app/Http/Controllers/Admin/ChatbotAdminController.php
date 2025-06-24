<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotAnalytics;
use App\Models\ChatbotConversation;
use App\Models\ChatbotMessage;
use App\Models\ChatbotCourseRecommendation;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // Ensure only admins can access
    }

    /**
     * Display chatbot analytics dashboard
     */
    public function dashboard(Request $request)
    {
        $period = $request->get('period', '7'); // Default 7 days
        $startDate = now()->subDays($period);

        // Overall Statistics
        $stats = [
            'total_conversations' => ChatbotConversation::where('created_at', '>=', $startDate)->count(),
            'total_messages' => ChatbotMessage::where('created_at', '>=', $startDate)->count(),
            'unique_users' => ChatbotConversation::where('created_at', '>=', $startDate)
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count(),
            'avg_messages_per_conversation' => $this->getAverageMessagesPerConversation($startDate),
            'course_recommendations' => ChatbotCourseRecommendation::where('created_at', '>=', $startDate)->count(),
            'recommendation_clicks' => ChatbotCourseRecommendation::where('created_at', '>=', $startDate)
                ->where('clicked', true)
                ->count(),
            'avg_response_time' => ChatbotMessage::where('created_at', '>=', $startDate)
                    ->where('sender', 'bot')
                    ->whereNotNull('response_time')
                    ->avg('response_time') ?? 0,
            'user_satisfaction' => $this->getUserSatisfaction($startDate)
        ];

        // Daily Analytics Chart Data
        $dailyAnalytics = ChatbotAnalytics::where('date', '>=', $startDate->toDateString())
            ->orderBy('date')
            ->get();

        // Most Popular Questions
        $popularQuestions = $this->getPopularQuestions($startDate);

        // Most Recommended Courses
        $popularCourses = $this->getMostRecommendedCourses($startDate);

        // Recent Conversations
        $recentConversations = ChatbotConversation::with(['user', 'latestMessage'])
            ->where('created_at', '>=', $startDate)
            ->orderBy('last_activity', 'desc')
            ->limit(10)
            ->get();

        // Conversion Rate (Recommendations to Clicks)
        $conversionRate = $stats['course_recommendations'] > 0
            ? ($stats['recommendation_clicks'] / $stats['course_recommendations']) * 100
            : 0;

        return view('admin.chatbot.dashboard', compact(
            'stats',
            'dailyAnalytics',
            'popularQuestions',
            'popularCourses',
            'recentConversations',
            'conversionRate',
            'period'
        ));
    }

    /**
     * Show detailed conversation
     */
    public function conversation($conversationId)
    {
        $conversation = ChatbotConversation::with(['user', 'messages.recommendations.course'])
            ->where('conversation_id', $conversationId)
            ->firstOrFail();

        return view('admin.chatbot.conversation', compact('conversation'));
    }

    /**
     * Export chatbot data
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'conversations');
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);

        switch ($type) {
            case 'conversations':
                return $this->exportConversations($startDate);
            case 'messages':
                return $this->exportMessages($startDate);
            case 'analytics':
                return $this->exportAnalytics($startDate);
            default:
                return back()->with('error', 'Invalid export type');
        }
    }

    /**
     * Update chatbot settings
     */
    public function settings(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'enabled' => 'boolean',
                'max_conversations_per_user' => 'integer|min:1|max:100',
                'rate_limit' => 'integer|min:1|max:60',
                'response_cache_ttl' => 'integer|min:60|max:3600'
            ]);

            // Update .env file or database settings
            $this->updateChatbotSettings($request->only([
                'enabled',
                'max_conversations_per_user',
                'rate_limit',
                'response_cache_ttl'
            ]));

            return back()->with('success', 'Chatbot settings updated successfully');
        }

        $settings = $this->getCurrentSettings();
        return view('admin.chatbot.settings', compact('settings'));
    }

    /**
     * Train chatbot with new responses
     */
    public function training(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'question' => 'required|string|max:500',
                'answer' => 'required|string|max:2000',
                'category' => 'required|string|max:100'
            ]);

            // Store training data (you might want to create a separate table for this)
            // This is a simplified example
            DB::table('chatbot_training_data')->insert([
                'question' => $request->question,
                'answer' => $request->answer,
                'category' => $request->category,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with('success', 'Training data added successfully');
        }

        // Get common unanswered questions for training suggestions
        $unansweredQuestions = $this->getUnansweredQuestions();

        return view('admin.chatbot.training', compact('unansweredQuestions'));
    }

    /**
     * Private helper methods
     */
    private function getAverageMessagesPerConversation($startDate)
    {
        $conversationCount = ChatbotConversation::where('created_at', '>=', $startDate)->count();
        $messageCount = ChatbotMessage::where('created_at', '>=', $startDate)->count();

        return $conversationCount > 0 ? round($messageCount / $conversationCount, 2) : 0;
    }

    private function getUserSatisfaction($startDate)
    {
        $satisfaction = ChatbotMessage::where('created_at', '>=', $startDate)
            ->whereNotNull('is_helpful')
            ->avg('is_helpful');

        return $satisfaction ? round($satisfaction * 100, 1) : 0;
    }

    private function getPopularQuestions($startDate, $limit = 10)
    {
        return ChatbotMessage::where('created_at', '>=', $startDate)
            ->where('sender', 'user')
            ->select('message', DB::raw('COUNT(*) as count'))
            ->groupBy('message')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'question' => $item->message,
                    'count' => $item->count,
                    'percentage' => 0 // You can calculate this based on total questions
                ];
            });
    }

    private function getMostRecommendedCourses($startDate, $limit = 10)
    {
        return ChatbotCourseRecommendation::with('course')
            ->where('created_at', '>=', $startDate)
            ->select('course_id', DB::raw('COUNT(*) as recommendation_count'), DB::raw('SUM(clicked) as click_count'))
            ->groupBy('course_id')
            ->orderBy('recommendation_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $clickRate = $item->recommendation_count > 0
                    ? ($item->click_count / $item->recommendation_count) * 100
                    : 0;

                return [
                    'course' => $item->course,
                    'recommendation_count' => $item->recommendation_count,
                    'click_count' => $item->click_count,
                    'click_rate' => round($clickRate, 1)
                ];
            });
    }

    private function exportConversations($startDate)
    {
        $conversations = ChatbotConversation::with(['user', 'messages'])
            ->where('created_at', '>=', $startDate)
            ->get();

        $csvData = [];
        $csvData[] = ['Conversation ID', 'User', 'Status', 'Message Count', 'Created At', 'Last Activity'];

        foreach ($conversations as $conversation) {
            $csvData[] = [
                $conversation->conversation_id,
                $conversation->user ? $conversation->user->name : 'Anonymous',
                $conversation->status,
                $conversation->message_count,
                $conversation->created_at->format('Y-m-d H:i:s'),
                $conversation->last_activity ? $conversation->last_activity->format('Y-m-d H:i:s') : ''
            ];
        }

        return $this->downloadCsv($csvData, 'chatbot-conversations-' . now()->format('Y-m-d') . '.csv');
    }

    private function exportMessages($startDate)
    {
        $messages = ChatbotMessage::with(['conversation.user'])
            ->where('created_at', '>=', $startDate)
            ->get();

        $csvData = [];
        $csvData[] = ['Conversation ID', 'User', 'Sender', 'Message', 'Response Time', 'Helpful', 'Created At'];

        foreach ($messages as $message) {
            $csvData[] = [
                $message->conversation->conversation_id,
                $message->conversation->user ? $message->conversation->user->name : 'Anonymous',
                $message->sender,
                $message->message,
                $message->response_time ?? '',
                $message->is_helpful !== null ? ($message->is_helpful ? 'Yes' : 'No') : '',
                $message->created_at->format('Y-m-d H:i:s')
            ];
        }

        return $this->downloadCsv($csvData, 'chatbot-messages-' . now()->format('Y-m-d') . '.csv');
    }

    private function exportAnalytics($startDate)
    {
        $analytics = ChatbotAnalytics::where('date', '>=', $startDate->toDateString())
            ->orderBy('date')
            ->get();

        $csvData = [];
        $csvData[] = [
            'Date', 'Conversations', 'Messages', 'Unique Users',
            'Recommendations', 'Clicks', 'Avg Response Time', 'Satisfaction'
        ];

        foreach ($analytics as $analytic) {
            $csvData[] = [
                $analytic->date->format('Y-m-d'),
                $analytic->total_conversations,
                $analytic->total_messages,
                $analytic->unique_users,
                $analytic->course_recommendations,
                $analytic->course_clicks,
                $analytic->avg_response_time,
                $analytic->user_satisfaction
            ];
        }

        return $this->downloadCsv($csvData, 'chatbot-analytics-' . now()->format('Y-m-d') . '.csv');
    }

    private function downloadCsv($data, $filename)
    {
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    private function updateChatbotSettings($settings)
    {
        // This is a simplified example. In a real application, you might want to
        // store settings in a database table or update the .env file
        foreach ($settings as $key => $value) {
            cache()->put("chatbot_setting_{$key}", $value, now()->addDays(30));
        }
    }

    private function getCurrentSettings()
    {
        return [
            'enabled' => cache('chatbot_setting_enabled', true),
            'max_conversations_per_user' => cache('chatbot_setting_max_conversations_per_user', 50),
            'rate_limit' => cache('chatbot_setting_rate_limit', 10),
            'response_cache_ttl' => cache('chatbot_setting_response_cache_ttl', 300)
        ];
    }

    private function getUnansweredQuestions($limit = 20)
    {
        // Get questions that resulted in generic or unhelpful responses
        return ChatbotMessage::where('sender', 'user')
            ->whereHas('conversation.messages', function($query) {
                $query->where('sender', 'bot')
                    ->where('is_helpful', false);
            })
            ->select('message', DB::raw('COUNT(*) as frequency'))
            ->groupBy('message')
            ->orderBy('frequency', 'desc')
            ->limit($limit)
            ->get();
    }
}
