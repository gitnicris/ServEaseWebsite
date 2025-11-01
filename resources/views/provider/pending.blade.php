@extends('layouts.app')

@section('title', 'Pending Bookings')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-semibold mb-6 text-yellow-500">Pending Bookings</h1>

    @if($bookings->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600">No pending bookings at the moment.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bookings as $booking)
                <div class="card shadow-lg rounded-xl overflow-hidden border border-gray-200">
                    <div class="p-5">
                        <h5 class="text-xl font-bold text-violet-600 mb-1">
                            {{ $booking->service->title }}
                        </h5>

                        <p class="text-sm text-gray-500 mb-3">
                            Customer: <span class="font-semibold">{{ $booking->customer->name }}</span>
                        </p>

                        <p class="text-gray-700">
                            <strong>Price:</strong> ₱{{ number_format($booking->price, 2) }}
                        </p>

                        <p class="text-gray-700">
                            <strong>Status:</strong>
                            <span class="capitalize text-yellow-500">{{ $booking->status }}</span>
                        </p>

                        @if($booking->notes)
                            <p class="text-gray-600 text-sm mt-2">
                                <strong>Notes:</strong> {{ $booking->notes }}
                            </p>
                        @endif

                        {{-- ✅ Approve / ❌ Reject Buttons --}}
                        <div class="flex justify-between items-center mt-4">
                            <form action="{{ route('provider.bookings.approve', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('provider.bookings.reject', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
