@extends('layouts.app')

@section('title', 'Pending Bookings')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Page Title --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-violet-500 to-yellow-400 bg-clip-text text-transparent">
                Pending Bookings
            </h1>
        </div>

        {{-- Empty State --}}
        @if($bookings->isEmpty())
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg text-center border border-gray-200 dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    No pending bookings at the moment.
                </p>
            </div>
        @else
            {{-- Booking Cards --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($bookings as $booking)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md hover:shadow-xl transition duration-300">
                        <div class="p-6">
                            {{-- Service Title --}}
                            <h5 class="text-xl font-semibold text-violet-600 dark:text-violet-400 mb-2">
                                {{ $booking->service->title }}
                            </h5>

                            {{-- Customer Info --}}
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <span class="font-medium">Customer:</span> {{ $booking->customer->name }}
                            </p>

                            {{-- Price --}}
                            <p class="text-gray-700 dark:text-gray-200 mb-1">
                                <span class="font-semibold">Price:</span> ₱{{ number_format($booking->price, 2) }}
                            </p>

                            {{-- Status --}}
                            <p class="text-gray-700 dark:text-gray-200">
                                <span class="font-semibold">Status:</span>
                                <span class="capitalize text-yellow-500 font-medium">{{ $booking->status }}</span>
                            </p>

                            {{-- Notes --}}
                            @if($booking->notes)
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 border-t border-gray-200 dark:border-gray-700 pt-2">
                                    <span class="font-semibold">Notes:</span> {{ $booking->notes }}
                                </p>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="flex justify-between items-center mt-5 gap-3">
                                <form action="{{ route('provider.bookings.approve', $booking->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-medium transition">
                                        ✅ Approve
                                    </button>
                                </form>

                                <form action="{{ route('provider.bookings.reject', $booking->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-medium transition">
                                        ❌ Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
