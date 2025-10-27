@extends('layouts.dashboard')

@section('content')
<div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl shadow-lg text-white">
    <h1 class="text-3xl font-bold mb-4">Welcome, {{ $user->name }} 👋</h1>
    <p class="text-gray-200 mb-6">You are logged in as a <span class="font-semibold">{{ ucfirst($user->role) }}</span>.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#" class="bg-orange-500 hover:bg-orange-600 p-4 rounded-xl text-center font-semibold transition">
            My Requests
        </a>
        <a href="#" class="bg-purple-500 hover:bg-purple-600 p-4 rounded-xl text-center font-semibold transition">
            Messages
        </a>
        <a href="#" class="bg-teal-500 hover:bg-teal-600 p-4 rounded-xl text-center font-semibold transition">
            Favorites
        </a>
    </div>
</div>
@endsection
