@extends('layouts.app')

@section('title', 'My Bookings | ServEase')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-violet-50 via-white to-orange-50 p-6 lg:p-10 rounded-2xl shadow-md">
    <!-- 🌈 Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-violet-700 mb-2">
                My Bookings 📅
            </h1>
            <p class="text-gray-500">Manage and track all your booked services here.</p>
        </div>
        <a href="{{ route('customer.services') }}"
           class="mt-4 sm:mt-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-md transition">
            <i class="bi bi-cart-fill"></i> Browse More Services
        </a>
    </div>

    <!-- 🧾 Bookings Table -->
    <div class="bg-white/80 backdrop-blur rounded-2xl shadow-lg border border-gray-200 p-6 overflow-x-auto">
        @if ($bookings->isEmpty())
            <p class="text-gray-600 text-center py-8 text-lg">You don’t have any bookings yet.</p>
        @else
            <table class="min-w-full border-collapse text-sm text-gray-700">
                <thead class="bg-violet-600 text-white uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4 text-left rounded-tl-lg">Service</th>
                        <th class="py-3 px-4 text-left">Provider</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-center rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($bookings as $booking)
                        <tr class="hover:bg-violet-50 transition-all">
                            <td class="py-4 px-4 font-medium text-gray-800">{{ $booking->service->title ?? 'N/A' }}</td>
                            <td class="py-4 px-4">{{ $booking->provider->name ?? 'N/A' }}</td>
                            <td class="py-4 px-4">{{ $booking->created_at->format('M d, Y') }}</td>
                            <td class="py-4 px-4">
                                @if ($booking->status === 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                                @elseif ($booking->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif ($booking->status === 'accepted')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Accepted</span>
                                @elseif ($booking->status === 'cancelled')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if ($booking->status === 'pending' || $booking->status === 'accepted')
                                    <div class="flex justify-center gap-2">
                                        @if ($booking->status === 'accepted')
                                            <form action="{{ route('customer.bookings.complete', $booking->id) }}" method="POST" onsubmit="return confirm('Mark this booking as completed?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs px-4 py-2 rounded-lg shadow-md transition">
                                                    <i class="bi bi-check2-circle"></i> Complete
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-4 py-2 rounded-lg shadow-md transition">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">No actions available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Sidebar Fix for Logout visibility --}}
<style>
    #sidebar {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-y: auto;
        padding-bottom: 1rem;
    }
</style>
@endsection
