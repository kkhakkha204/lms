@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p>Chào mừng Admin!</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-4 bg-red-600 text-white p-2 rounded-md hover:bg-red-700 transition">Đăng xuất</button>
        </form>
    </div>
@endsection
