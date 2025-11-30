@extends('layouts.app')

@section('title', 'My Bookings | ServEase')

@section('content')
<div class="w-full space-y-6">
    <!-- 🌈 Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">
                My Bookings 📅
            </h1>
            <p class="text-gray-500 text-sm md:text-base">
                Manage and track all your booked services here.
            </p>
        </div>
        <a href="{{ route('customer.services') }}"
           class="mt-3 md:mt-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition">
            <i class="bi bi-cart-fill"></i> Browse Services
        </a>
    </div>

    <!-- 🧾 Bookings List -->
    @if ($bookings->isEmpty())
        <p class="text-gray-600 text-center py-6 text-sm md:text-base">
            You don’t have any bookings yet.
        </p>
    @else
        <div class="space-y-4">
            @foreach ($bookings as $booking)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    
                    <!-- Booking Info -->
                    <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-6 flex-1">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $booking->service->title ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-xs md:text-sm">{{ $booking->provider->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-xs md:text-sm">Date: {{ $booking->created_at->format('M d, Y') }}</p>
                        </div>

                        <div>
                            @php
                                $statusClasses = [
                                    'completed' => 'bg-green-100 text-green-700',
                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                    'accepted'  => 'bg-blue-100 text-blue-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-2 mt-2 md:mt-0 md:justify-end">
                        @if (in_array($booking->status, ['pending', 'accepted']))
                            @if ($booking->status === 'accepted')
                                <form action="{{ route('customer.bookings.complete', $booking->id) }}" method="POST" onsubmit="return confirm('Mark this booking as completed?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs md:text-sm px-3 py-1 rounded-md transition flex items-center gap-1">
                                        <i class="bi bi-check2-circle"></i> Complete
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs md:text-sm px-3 py-1 rounded-md transition flex items-center gap-1">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs italic md:text-sm">No actions available</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
