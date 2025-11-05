@extends('layouts.app')

@section('title', 'Customer Dashboard | ServEase')

@section('content')
<div class="w-full min-h-screen 
            bg-gradient-to-br from-violet-50 via-white to-orange-50 
            dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 
            px-4 sm:px-6 lg:px-10 pt-24 md:pt-28 lg:pt-32 pb-20 
            rounded-none shadow-inner transition-colors duration-300 overflow-hidden">

    <!-- 🏠 Breadcrumb -->
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-2">
        <i class="bi bi-house-door"></i>
        <span>/ Dashboard</span>
    </div>

    <!-- 🌈 Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-violet-700 dark:text-violet-400 mb-2 drop-shadow-sm">
                Welcome, {{ Auth::user()->name ?? 'Customer' }} 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">
                Here’s a quick overview of your account activity.
            </p>
        </div>
        <a href="{{ route('customer.services') }}"
           class="mt-4 sm:mt-0 inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 
                  text-white px-4 sm:px-5 py-2.5 rounded-xl font-medium shadow-md transition transform hover:scale-[1.03] w-full sm:w-auto">
            <i class="bi bi-cart-fill"></i> Browse Services
        </a>
    </div>

    <!-- 📊 Dashboard Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12">
        @php
            $cards = [
                ['title' => 'Total Bookings', 'value' => $totalBookings ?? 0, 'color' => 'violet', 'icon' => 'calendar-check'],
                ['title' => 'Messages', 'value' => $totalMessages ?? 0, 'color' => 'orange', 'icon' => 'envelope'],
                ['title' => 'Completed', 'value' => $completedBookings ?? 0, 'color' => 'green', 'icon' => 'check-circle'],
                ['title' => 'Cancelled', 'value' => $cancelledBookings ?? 0, 'color' => 'red', 'icon' => 'x-circle'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white/80 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-md 
                        border-t-4 border-{{ $card['color'] }}-500 p-4 sm:p-6 hover:shadow-xl 
                        transition-all duration-300 transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $card['title'] }}</h3>
                        <p class="text-2xl sm:text-4xl font-extrabold text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 mt-2">
                            {{ $card['value'] }}
                        </p>
                    </div>
                    <div class="bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/40 
                                p-3 rounded-xl text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400">
                        <i class="bi bi-{{ $card['icon'] }} text-lg sm:text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 💡 Recommended Services -->
    <div class="bg-white/80 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-md 
                border border-gray-100 dark:border-gray-700 p-6 sm:p-8 mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-violet-700 dark:text-violet-400 flex items-center gap-2">
                <i class="bi bi-lightbulb text-orange-400"></i> Recommended Services
            </h2>
        </div>

        @if ($recommendedServices->isEmpty())
            <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                <i class="bi bi-emoji-frown text-4xl mb-3 text-orange-400"></i>
                <p>No recommended services yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recommendedServices as $service)
                    <div class="bg-violet-50/90 dark:bg-violet-900/30 backdrop-blur-sm rounded-xl p-5 
                                border border-violet-100 dark:border-violet-800 
                                hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <h3 class="font-semibold text-lg text-violet-800 dark:text-violet-300 mb-2">
                            {{ $service->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                            {{ Str::limit($service->description, 80) }}
                        </p>
                        <a href="{{ route('customer.services') }}" 
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg font-medium transition">
                           View Service
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 🧾 Recent Bookings -->
    <div class="bg-white/80 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-md 
                border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-violet-700 dark:text-violet-400 flex items-center gap-2">
                <i class="bi bi-clock-history text-orange-400"></i> Recent Bookings
            </h2>
        </div>

        @if ($recentBookings->isEmpty())
            <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                <i class="bi bi-calendar-x text-4xl mb-3 text-violet-400"></i>
                <p>You have no recent bookings.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-xs sm:text-sm text-gray-700 dark:text-gray-300">
                    <thead class="bg-violet-600 dark:bg-violet-700 text-white uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">Service</th>
                            <th class="py-3 px-4 text-left">Provider</th>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-violet-50 dark:hover:bg-gray-700 transition">
                                <td class="py-3 px-4 font-medium">{{ $booking->service->title ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $booking->provider->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    @switch($booking->status)
                                        @case('completed')
                                            <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                                            @break
                                        @case('pending')
                                            <span class="bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                            @break
                                        @case('accepted')
                                            <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-full text-xs font-semibold">Accepted</span>
                                            @break
                                        @default
                                            <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 px-3 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 🔗 View All -->
            <div class="mt-6 text-center">
                <a href="{{ route('customer.bookings') }}" 
                   class="inline-block bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl font-medium transition">
                   View All Bookings
                </a>
            </div>
        @endif
    </div>
</div>

<!-- 🌟 Role Selection Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-white dark:bg-gray-800">
      <div class="modal-header border-0">
        <h5 class="modal-title text-violet-700 dark:text-violet-400" id="roleModalLabel">Select Your Role</h5>
      </div>
      <div class="modal-body text-center">
        <p class="text-gray-600 dark:text-gray-300 mb-3">Please choose your role to continue:</p>
        <a href="{{ route('setRole', ['role' => 'customer']) }}" class="btn btn-success m-2">Customer</a>
        <a href="{{ route('setRole', ['role' => 'provider']) }}" class="btn btn-primary m-2">Provider</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(Auth::user() && Auth::user()->role == null)
        new bootstrap.Modal(document.getElementById('roleModal')).show();
    @endif
});
</script>

<style>
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    #app {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    @media (max-width: 768px) {
        .grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .text-4xl {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 480px) {
        .grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        .pt-32 {
            padding-top: 5rem !important;
        }
    }
</style>
@endsection
