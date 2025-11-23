@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-center text-orange-400 mb-10">
        Available Services
    </h1>

    @if ($services->isEmpty())
        <p class="text-center text-gray-500 text-lg">
            No services are available right now. Please check back later!
        </p>
    @else

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach ($services as $service)
                @if ($service->status === 'approved')

                    <div class="bg-gray-300 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">

                        {{-- Dark Header / Image Area --}}
                        @if ($service->image && Storage::disk('public')->exists($service->image))
                            <img src="{{ asset('storage/' . $service->image) }}"
                                 class="w-full h-52 object-cover rounded-t-2xl">
                        @else
                            <div class="w-full h-52 bg-gradient-to-b from-gray-800 to-gray-700 flex flex-col items-center justify-center text-gray-300">
                                <i class="bi bi-image text-4xl mb-2"></i>
                                <span>No Image Available</span>
                            </div>
                        @endif

                        {{-- Details --}}
                        <div class="p-6 relative">

                            {{-- Approved Badge --}}
                            <span class="absolute top-6 right-6 bg-green-600 text-white text-xs px-3 py-1 rounded-md">
                                ✔ Approved
                            </span>

                            <h3 class="text-2xl font-semibold text-orange-400">
                                {{ $service->title }}
                            </h3>

                            <p class="text-gray-700 text-sm mt-2 mb-4">
                                {{ Str::limit($service->description, 60) }}
                            </p>

                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold">₱{{ number_format($service->price, 2) }}</p>
                                <span class="text-sm text-gray-600">
                                    {{ $service->category ?: 'Uncategorized' }}
                                </span>
                            </div>

                        </div>

                        {{-- Footer Bar --}}
                        <div class="bg-gray-800 text-gray-200 p-4 flex justify-between items-center">

                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-circle text-orange-400"></i>
                                <span>{{ $service->provider->name ?? 'Unknown' }}</span>
                            </div>

                            <a href="{{ route('services.show', $service->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg">
                                View Details
                            </a>

                        </div>

                    </div>

                @endif
            @endforeach

        </div>

    @endif
</div>
@endsection
