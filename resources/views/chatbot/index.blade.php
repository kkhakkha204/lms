@extends('layouts.app')

@section('title', 'AI ChatBot - Tư vấn khóa học')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">AI Tư vấn Khóa học</h1>

            <!-- Chatbot sẽ được include ở đây -->
            <div id="chatbot-container">
                <!-- ChatBot component sẽ được load -->
            </div>
        </div>
    </div>

    <!-- Include ChatBot Component -->
    @include('components.chatbot')
@endsection

@push('scripts')
    <script>
        // Custom JavaScript cho trang chatbot nếu cần
        document.addEventListener('DOMContentLoaded', function() {
            // Auto open chatbot on this page
            setTimeout(() => {
                document.getElementById('chatbot-toggle').click();
            }, 1000);
        });
    </script>
@endpush
