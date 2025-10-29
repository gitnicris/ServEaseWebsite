@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10 px-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
            Welcome, {{ $user->name }} 👋
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">
            Here’s your customer dashboard. Explore services, track your bookings, or connect with providers.
        </p>

        {{-- Stats Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                <h2 class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Bookings</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">0</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                <h2 class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Messages</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">0</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                <h2 class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Recommended</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">3</p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('customer.services') }}" 
               class="px-6 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
               Browse Services
            </a>
        </div>
    </div>
</div>
@endsection
