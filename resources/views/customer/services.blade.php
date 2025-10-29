@extends('layouts.app')

@section('title', 'Available Services')

@section('content')
<div class="min-h-screen py-16 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-white drop-shadow-md">
                Available Services
            </h1>
            <p class="text-orange-200 mt-3 text-lg">Browse and connect with providers</p>
        </div>

        <!-- Services Grid -->
        @if($services->isEmpty())
            <div class="text-center text-gray-200 text-lg mt-10">
                No services available at the moment.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="bg-[#2e1b32] rounded-2xl overflow-hidden shadow-lg hover:shadow-orange-500/30 transition-all duration-300 hover:scale-[1.03]">
                        
                        <!-- Service Image -->
                        <div class="relative h-56">
                            @if($service->image && Storage::disk('public')->exists($service->image))
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->title }}" 
                                     class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center h-full bg-gray-900 text-gray-400">
                                    <i class="fa-solid fa-image text-4xl mr-2"></i>
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <!-- Service Info -->
                        <div class="p-6 text-white">
                            <h2 class="text-lg font-bold text-orange-400 mb-1">{{ $service->title }}</h2>
                            <p class="text-sm text-gray-300 mb-4 line-clamp-2">
                                {{ $service->description }}
                            </p>

                            <div class="flex justify-between items-center mb-3 text-sm">
                                <p class="font-semibold">₱{{ number_format($service->price, 2) }}</p>
                                <span class="text-gray-400">{{ $service->category ?? 'Uncategorized' }}</span>
                            </div>

                            <!-- Provider Info -->
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($service->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold">{{ $service->user->name ?? 'Unknown Provider' }}</p>
                                    <p class="text-xs text-gray-400">Service Provider</p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-between mt-4 border-t border-gray-700 pt-4">
    <form action="{{ route('customer.book.service', $service->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Book Now</button>
</form>

    <a href="{{ route('customer.messages.chat', $service->id) }}"
       class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg transition-all">
        <i class="fa-solid fa-message mr-2"></i> Message
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
