@extends('layouts.app')

@section('title', 'Customer Dashboard | ServEase')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-violet-50 via-white to-orange-50 p-6 lg:p-10 rounded-2xl shadow-inner">

    <!-- 🌈 Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-violet-700 mb-2">
                Welcome, {{ Auth::user()->name ?? 'Customer' }} 👋
            </h1>
            <p class="text-gray-600">Here’s a quick overview of your account activity.</p>
        </div>
        <a href="{{ route('customer.services') }}"
           class="mt-4 sm:mt-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-md transition">
            <i class="bi bi-cart-fill"></i> Browse Services
        </a>
    </div>

    <!-- 📊 Dashboard Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @php
            $cards = [
                ['title' => 'Total Bookings', 'value' => $totalBookings ?? 0, 'color' => 'violet', 'icon' => 'calendar-check'],
                ['title' => 'Messages', 'value' => $totalMessages ?? 0, 'color' => 'orange', 'icon' => 'envelope'],
                ['title' => 'Completed', 'value' => $completedBookings ?? 0, 'color' => 'green', 'icon' => 'check-circle'],
                ['title' => 'Cancelled', 'value' => $cancelledBookings ?? 0, 'color' => 'red', 'icon' => 'x-circle'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-md p-6 border-t-4 border-{{ $card['color'] }}-500 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500 font-medium">{{ $card['title'] }}</h3>
                        <p class="text-4xl font-extrabold text-{{ $card['color'] }}-600 mt-2">{{ $card['value'] }}</p>
                    </div>
                    <div class="bg-{{ $card['color'] }}-100 p-3 rounded-xl text-{{ $card['color'] }}-600">
                        <i class="bi bi-{{ $card['icon'] }} text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 💡 Recommended Services -->
    <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-md border border-gray-100 p-8 mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-violet-700 flex items-center gap-2">
                <i class="bi bi-lightbulb text-orange-400"></i> Recommended Services
            </h2>
        </div>

        @if ($recommendedServices->isEmpty())
            <p class="text-gray-600 text-center py-6">No recommended services yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recommendedServices as $service)
                    <div class="bg-violet-50/80 backdrop-blur-sm rounded-xl p-5 border border-violet-100 hover:shadow-md transition-all">
                        <h3 class="font-semibold text-lg text-violet-800 mb-2">{{ $service->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 80) }}</p>
                        <a href="{{ route('customer.services') }}" 
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg font-medium">
                           View Service
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 🧾 Recent Bookings -->
    <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-md border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-violet-700 flex items-center gap-2">
                <i class="bi bi-clock-history text-orange-400"></i> Recent Bookings
            </h2>
        </div>

        @if ($recentBookings->isEmpty())
            <p class="text-gray-600 text-center py-6">You have no recent bookings.</p>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-violet-600 text-white uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4 text-left">Service</th>
                            <th class="py-3 px-4 text-left">Provider</th>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-violet-50 transition">
                                <td class="py-3 px-4 font-medium">{{ $booking->service->title ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $booking->provider->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    @if($booking->status === 'completed')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($booking->status === 'accepted')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Accepted</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Sidebar Fix for Logout visibility --}}
<style>
    #sidebar {
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        padding-bottom: 1rem;
    }

    /* Makes dashboard blend with layout */
    body {
        background: linear-gradient(135deg, #f8f5ff 0%, #fff9f5 100%) !important;
        background-attachment: fixed;
    }
</style>
@endsection
