@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 text-white">
    <h1 class="text-3xl font-bold text-center text-orange-300 mb-10">Available Services</h1>

    @if ($services->isEmpty())
        <p class="text-center text-gray-300 text-lg">No services are available right now. Please check back later!</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($services as $service)
                @if ($service->status === 'approved')
                    <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:scale-[1.02] duration-300 overflow-hidden flex flex-col">

                        <!-- 🖼️ Service Image -->
                        @if ($service->image && Storage::disk('public')->exists($service->image))
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="h-56 w-full object-cover">
                        @else
                            <div class="h-56 w-full bg-gray-700 flex items-center justify-center text-gray-400 text-sm">
                                <i class="bi bi-image-alt text-3xl"></i>
                                <span class="ml-2">No Image Available</span>
                            </div>
                        @endif

                        <!-- 🧾 Details -->
                        <div class="p-6 flex-1 flex flex-col relative">
                            <span class="absolute top-4 right-4 bg-green-600 text-xs px-2 py-1 rounded-md font-semibold">
                                ✅ Approved
                            </span>

                            <h3 class="text-2xl font-semibold text-orange-300 mb-2">{{ $service->title }}</h3>
                            <p class="text-gray-200 text-sm mb-4 flex-1">{{ Str::limit($service->description, 120) }}</p>

                            <div class="flex justify-between items-center mt-auto">
                                <p class="font-semibold text-lg text-white">₱{{ number_format($service->price, 2) }}</p>
                                <p class="text-sm text-gray-300">{{ $service->category ?: 'Uncategorized' }}</p>
                            </div>
                        </div>

                        <!-- 👤 Provider Info + Actions -->
                        <div class="p-4 bg-black/50 border-t border-white/10 text-sm text-gray-300 flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="bi bi-person-circle text-orange-400"></i>
                                <span>{{ $service->provider->name ?? 'Unknown Provider' }}</span>
                            </div>

                            <div class="flex space-x-2">
                                <!-- 🔍 View Details -->
                                <a href="{{ route('services.show', $service->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-white font-medium text-xs">
                                    View Details
                                </a>

                                <!-- ✅ Book Now -->
                                @if(Auth::check() && Auth::user()->role === 'customer')
                                    <form action="{{ route('customer.book.service', $service->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-white font-medium text-xs">
                                            Book Now
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
