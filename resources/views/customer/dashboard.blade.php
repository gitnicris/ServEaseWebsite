@extends('layouts.app')

@section('title', 'Customer Dashboard | ServEase')

@section('content')
<div class="w-full space-y-8">

    <!-- 🏠 Breadcrumb -->
    <div class="text-sm text-gray-500 flex items-center gap-2">
        <i class="bi bi-house-door"></i>
        <span>/ Dashboard</span>
    </div>

    <!-- 🌈 Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">
                Welcome, {{ Auth::user()->name ?? 'Customer' }} 👋
            </h1>
            <p class="text-gray-500 text-sm md:text-base">
                Here’s a quick overview of your account activity.
            </p>
        </div>
        <a href="{{ route('customer.services') }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition transform hover:scale-105 w-full md:w-auto justify-center">
            <i class="bi bi-cart-fill"></i> Browse Services
        </a>
    </div>

    <!-- 📊 Dashboard Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['title' => 'Total Bookings', 'value' => $totalBookings ?? 0, 'color' => 'violet', 'icon' => 'calendar-check'],
                ['title' => 'Messages', 'value' => $totalMessages ?? 0, 'color' => 'orange', 'icon' => 'envelope'],
                ['title' => 'Completed', 'value' => $completedBookings ?? 0, 'color' => 'green', 'icon' => 'check-circle'],
                ['title' => 'Cancelled', 'value' => $cancelledBookings ?? 0, 'color' => 'red', 'icon' => 'x-circle'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 flex items-center justify-between hover:shadow-lg transition transform hover:scale-105">
                <div>
                    <h3 class="text-xs text-gray-500 font-medium">{{ $card['title'] }}</h3>
                    <p class="text-2xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['value'] }}</p>
                </div>
                <div class="bg-{{ $card['color'] }}-100 p-3 rounded-lg text-{{ $card['color'] }}-600">
                    <i class="bi bi-{{ $card['icon'] }} text-lg"></i>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 💡 Recommended Services -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="bi bi-lightbulb text-orange-400"></i> Recommended Services
            </h2>
        </div>

        @if ($recommendedServices->isEmpty())
            <div class="text-center py-6 text-gray-500">
                <i class="bi bi-emoji-frown text-3xl mb-2 text-orange-400"></i>
                <p>No recommended services yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($recommendedServices as $service)
                    <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition">
                        <h3 class="font-semibold text-md text-gray-900 mb-1">{{ $service->title }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ Str::limit($service->description, 80) }}</p>
                        <a href="{{ route('customer.services') }}" 
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white text-sm px-3 py-1 rounded-md font-medium transition">
                           View Service
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 🧾 Recent Bookings -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="bi bi-clock-history text-orange-400"></i> Recent Bookings
            </h2>
        </div>

        @if ($recentBookings->isEmpty())
            <div class="text-center py-6 text-gray-500">
                <i class="bi bi-calendar-x text-3xl mb-2 text-gray-400"></i>
                <p>You have no recent bookings.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-xs sm:text-sm text-gray-700">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="py-2 px-3 text-left">Service</th>
                            <th class="py-2 px-3 text-left">Provider</th>
                            <th class="py-2 px-3 text-left">Date</th>
                            <th class="py-2 px-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-2 px-3 font-medium">{{ $booking->service->title ?? 'N/A' }}</td>
                                <td class="py-2 px-3">{{ $booking->provider->name ?? 'N/A' }}</td>
                                <td class="py-2 px-3">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="py-2 px-3">
                                    @switch($booking->status)
                                        @case('completed')
                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Completed</span>
                                            @break
                                        @case('pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Pending</span>
                                            @break
                                        @case('accepted')
                                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Accepted</span>
                                            @break
                                        @default
                                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Cancelled</span>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 🔗 View All -->
            <div class="mt-4 text-center">
                <a href="{{ route('customer.bookings') }}" 
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition">
                   View All Bookings
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
