@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-cover bg-center py-16 px-6"
     style="background-image: url('/images/background.jpg');">

    <div class="max-w-6xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl shadow-xl border border-gray-600 p-8">
        <h2 class="text-2xl font-bold text-center text-white mb-10">My Bookings</h2>

        @if($bookings->isEmpty())
            <p class="text-center text-gray-300">You have no bookings yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-gray-900/70 rounded-2xl shadow-md overflow-hidden border border-gray-700">
                        {{-- Service Image --}}
                        <div class="h-48 bg-gray-800 flex items-center justify-center">
                            @if ($booking->service->image)
                                <img src="{{ asset('storage/'.$booking->service->image) }}" alt="Service Image" class="h-full w-full object-cover">
                            @else
                                <span class="text-gray-400">No Image Available</span>
                            @endif
                        </div>

                        {{-- Service Info --}}
                        <div class="p-5 text-white">
                            <h3 class="text-xl font-semibold">{{ $booking->service->title }}</h3>
                            <p class="text-gray-400 text-sm">{{ $booking->service->description }}</p>

                            <div class="mt-3">
                                <p><span class="text-gray-400">Provider:</span> {{ $booking->provider->name }}</p>
                                <p><span class="text-gray-400">Price:</span> ₱{{ number_format($booking->service->price, 2) }}</p>
                                <p><span class="text-gray-400">Status:</span>
                                    <span class="uppercase text-sm font-semibold
                                        {{ $booking->status == 'pending' ? 'text-yellow-400' : ($booking->status == 'approved' ? 'text-green-400' : 'text-red-400') }}">
                                        {{ $booking->status }}
                                    </span>
                                </p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-5 flex justify-between">
                                <a href="{{ route('customer.messages.chat', $booking->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                                    <i class="fa-solid fa-message mr-1"></i> Chat
                                </a>

                                <a href="{{ route('services.index') }}"
                                   class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                                    <i class="fa-solid fa-plus mr-1"></i> Book More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
