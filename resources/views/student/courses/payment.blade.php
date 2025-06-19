@extends('layouts.app')

@section('title', 'Thanh toán: ' . $course->title)

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
            <h1 class="text-2xl font-bold mb-4">Thanh toán khóa học</h1>
            <div class="mb-4">
                <h2 class="text-lg font-semibold">{{ $course->title }}</h2>
                <p class="text-gray-600">Giá:
                    @if ($course->discount_price && $course->discount_price < $course->price)
                        <span class="line-through text-gray-500">{{ number_format($course->price, 0, ',', '.') }} VND</span>
                        <span class="font-bold">{{ number_format($course->discount_price, 0, ',', '.') }} VND</span>
                    @else
                        <span class="font-bold">{{ number_format($course->price, 0, ',', '.') }} VND</span>
                    @endif
                </p>
            </div>
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('student.courses.payment', $course) }}" method="POST" id="payment-form">
                @csrf
                <button type="submit" id="checkout-button" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Thanh toán với Stripe
                </button>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const checkoutButton = document.getElementById('checkout-button');
        const form = document.getElementById('payment-form');

        checkoutButton.addEventListener('click', function (e) {
            e.preventDefault();
            checkoutButton.disabled = true;
            checkoutButton.textContent = 'Đang xử lý...';

            // Create FormData to include CSRF token
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json', // Ensure server returns JSON
                },
                body: formData, // Use FormData to include CSRF token
            })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`Server returned ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.url) {
                        window.location.href = data.url;
                    } else {
                        checkoutButton.disabled = false;
                        checkoutButton.textContent = 'Thanh toán với Stripe';
                        alert('Lỗi: ' + (data.message || 'Không thể xử lý thanh toán.'));
                    }
                })
                .catch(error => {
                    checkoutButton.disabled = false;
                    checkoutButton.textContent = 'Thanh toán với Stripe';
                    console.error('Payment error:', error);
                    alert('Lỗi thanh toán: ' + error.message);
                });
        });
    </script>
@endsection
