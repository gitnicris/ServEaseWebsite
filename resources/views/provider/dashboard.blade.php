@extends('layouts.app')

@section('title', 'Provider Dashboard')

@section('content')
<div class="container mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white dark:text-gray-900">Welcome, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-400 dark:text-gray-600">Here’s your provider overview and quick access panel.</p>
        </div>
        <a href="{{ route('provider.services') }}" 
           class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition">
           Manage Services
        </a>
    </div>

    {{-- Stats Section --}}
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mb-10">
        <div class="bg-gray-800 dark:bg-white rounded-2xl p-6 shadow-md border border-gray-700 dark:border-gray-200">
            <h3 class="text-gray-400 dark:text-gray-500 text-sm uppercase mb-2">Total Services</h3>
            <p class="text-3xl font-bold text-white dark:text-gray-900">{{ $totalServices ?? 0 }}</p>
        </div>

        <div class="bg-gray-800 dark:bg-white rounded-2xl p-6 shadow-md border border-gray-700 dark:border-gray-200">
            <h3 class="text-gray-400 dark:text-gray-500 text-sm uppercase mb-2">Total Bookings</h3>
            <p class="text-3xl font-bold text-white dark:text-gray-900">{{ $totalBookings ?? 0 }}</p>
        </div>

        <div class="bg-gray-800 dark:bg-white rounded-2xl p-6 shadow-md border border-gray-700 dark:border-gray-200">
            <h3 class="text-gray-400 dark:text-gray-500 text-sm uppercase mb-2">Total Earnings</h3>
            <p class="text-3xl font-bold text-green-400 dark:text-green-600">₱{{ number_format($totalEarnings ?? 0, 2) }}</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-gray-900 dark:bg-white rounded-2xl p-6 shadow-lg mb-10 border border-gray-700 dark:border-gray-200">
        <h2 class="text-xl font-semibold text-white dark:text-gray-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('provider.profile') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
               View Profile
            </a>

            <a href="{{ route('provider.services') }}" 
               class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
               Add or Manage Services
            </a>

            <a href="{{ route('provider.bookings') }}" 
               class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
               View Bookings
            </a>
        </div>
    </div>

    {{-- Recent Services --}}
    <div class="bg-gray-900 dark:bg-white rounded-2xl p-6 shadow-lg border border-gray-700 dark:border-gray-200">
        <h2 class="text-xl font-semibold text-white dark:text-gray-900 mb-4">Recent Services</h2>

        @if(isset($recentServices) && $recentServices->count() > 0)
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                @foreach ($recentServices as $service)
                    <div class="bg-gray-800 dark:bg-gray-100 rounded-2xl shadow-md overflow-hidden">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->title }}" 
                                 class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif
                        <div class="p-4 text-white dark:text-gray-900">
                            <h3 class="font-semibold">{{ $service->title }}</h3>
                            <p class="text-sm text-gray-400 dark:text-gray-600 line-clamp-2 mt-1">
                                {{ $service->description }}
                            </p>
                            <p class="mt-2 text-orange-400 font-bold">₱{{ number_format($service->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 dark:text-gray-600 text-center">No recent services found.</p>
        @endif
    </div>

</div>
@endsection
