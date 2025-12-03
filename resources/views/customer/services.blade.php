@extends('layouts.app')

@section('title', 'Available Services')

@section('content')
@php
    $customerBookings = collect();
    if (Auth::check() && Auth::user()->role === 'customer') {
        $customerBookings = \App\Models\Booking::where('customer_id', Auth::id())
            ->whereIn('service_id', $services->pluck('id'))
            ->pluck('service_id')
            ->toArray();
    }
@endphp

<div class="min-h-screen py-16 px-4 md:px-6 bg-gray-100">
    <div class="max-w-7xl mx-auto">
        <!-- Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                Available Services
            </h1>
            <p class="text-gray-500 mt-3 text-lg md:text-xl">Browse and connect with providers</p>
        </div>

        <!-- Services Grid --> 
        @if($services->isEmpty())
            <div class="text-center text-gray-500 text-lg mt-10">
                No services available at the moment.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    @php
                        $hasBooking = in_array($service->id, $customerBookings);
                    @endphp

                    <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 flex flex-col">
                        <!-- Service Image -->
                        <div class="relative h-56 bg-gray-200">
                            @if($service->image && Storage::disk('public')->exists($service->image))
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->title }}" 
                                     class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i class="fa-solid fa-image text-4xl mr-2"></i>
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <!-- Service Info -->
                        <div class="p-6 flex-1 flex flex-col">
                            <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $service->title }}</h2>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-3 flex-1">
                                {{ $service->description }}
                            </p>

                            <div class="flex justify-between items-center mb-3 text-sm">
                                <p class="font-semibold text-gray-900">₱{{ number_format($service->price, 2) }}</p>
                                <span class="text-gray-400">{{ $service->category ?? 'Uncategorized' }}</span>
                            </div>

                            <!-- Provider Info -->
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($service->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $service->user->name ?? 'Unknown Provider' }}</p>
                                    <p class="text-xs text-gray-400">Service Provider</p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-between mt-auto pt-4 border-t border-gray-200 gap-2">
                                <form action="{{ route('customer.book.service', $service->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm py-2 rounded-lg transition">
                                        Book Now
                                    </button>
                                </form>

                                @if($hasBooking)
                                    <a href="{{ route('customer.messages.chat', $service->id) }}"
                                       class="flex-1 inline-flex justify-center items-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 rounded-lg transition gap-2">
                                        <i class="fa-solid fa-message"></i> Message
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
