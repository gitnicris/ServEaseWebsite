@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="w-full max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 sm:p-10">

        {{-- 🏠 Welcome Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white">
                Welcome back, {{ $user->name }} 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm sm:text-base">
                Manage your bookings, explore services, and chat with providers easily.
            </p>
        </div>

        {{-- 📊 Dashboard Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-2xl shadow-md p-6 text-center">
                <h2 class="text-sm uppercase font-semibold opacity-80">Total Bookings</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalBookings ?? 0 }}</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 text-white rounded-2xl shadow-md p-6 text-center">
                <h2 class="text-sm uppercase font-semibold opacity-80">Messages</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalMessages ?? 0 }}</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-amber-600 text-white rounded-2xl shadow-md p-6 text-center">
                <h2 class="text-sm uppercase font-semibold opacity-80">Recommended</h2>
                <p class="text-4xl font-bold mt-2">{{ $recommendedServices->count() ?? 0 }}</p>
            </div>
        </div>

        {{-- 💡 Recommended Services --}}
        <div class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                Recommended For You
            </h2>

            @if ($recommendedServices->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-6">
                    No recommendations at the moment.
                </p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recommendedServices as $service)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                            <div class="p-5">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-white truncate">
                                    {{ $service->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 line-clamp-2">
                                    {{ Str::limit($service->description, 80) }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('customer.services') }}" 
                                       class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                        View Service
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 📅 Recent Bookings --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                Recent Bookings
            </h2>

            @if ($recentBookings->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-6">
                    You have no recent bookings.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Service</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Provider</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Date</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($recentBookings as $booking)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                        {{ $booking->service->title ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                        {{ $booking->provider->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                        {{ $booking->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if($booking->status === 'Completed') bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 
                                            @elseif($booking->status === 'Pending') bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 
                                            @else bg-red-500/20 text-red-600 dark:text-red-400 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
