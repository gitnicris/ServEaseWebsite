@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <div class="bg-gray-300 rounded-xl shadow-lg p-6">

        {{-- Top Section --}}
        <div class="flex flex-col md:flex-row gap-6">

            {{-- Image --}}
            <div class="md:w-1/3">
                @if ($service->image && Storage::disk('public')->exists($service->image))
                    <img src="{{ asset('storage/' . $service->image) }}"
                         class="w-full h-48 object-cover rounded-lg shadow">
                @else
                    <div class="w-full h-48 bg-gray-700 flex flex-col items-center justify-center rounded-lg text-gray-300">
                        <i class="bi bi-image text-4xl mb-1"></i>
                        <span class="text-sm">No Image Available</span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-bold text-orange-400">
                        {{ $service->title }}
                    </h1>

                    <span class="w-4 h-1 rounded-full bg-green-500"></span>
                </div>

                <p class="text-gray-700 text-sm mb-3 leading-relaxed">
                    {{ $service->description }}
                </p>

                <p class="text-xl font-bold text-gray-800">
                    ₱{{ number_format($service->price, 2) }}
                </p>
            </div>
        </div>

        {{-- Divider --}}
        <hr class="my-6 border-gray-400">

        {{-- Provider Info --}}
        <h2 class="text-lg font-bold text-orange-400 mb-3 flex items-center gap-2">
            <i class="bi bi-person-circle text-orange-500"></i>
            Provider Information
        </h2>

        @if ($service->provider && $service->provider->profile)
            <div class="flex items-center gap-4">
                @if ($service->provider->profile->photo && Storage::disk('public')->exists($service->provider->profile->photo))
                    <img src="{{ asset('storage/' . $service->provider->profile->photo) }}"
                         class="w-14 h-14 rounded-full object-cover shadow">
                @else
                    <div class="w-14 h-14 bg-gray-700 flex items-center justify-center rounded-full text-gray-300 text-2xl">
                        <i class="bi bi-person"></i>
                    </div>
                @endif

                <div>
                    <p class="font-bold text-gray-900">{{ $service->provider->name }}</p>
                    <p class="text-gray-600 text-xs">{{ $service->provider->profile->bio ?? 'No bio available.' }}</p>
                </div>
            </div>
        @else
            <p class="text-gray-600 text-sm">Provider information not available.</p>
        @endif

        {{-- Divider --}}
        <hr class="my-6 border-gray-400">

        {{-- Customer Reviews --}}
        <h2 class="text-lg font-bold text-orange-400 mb-4 flex items-center gap-2">
            <i class="bi bi-star-fill text-yellow-500"></i>
            Customer Reviews
        </h2>

        @if ($service->reviews->count() > 0)
            <div class="space-y-4">
                @foreach ($service->reviews as $review)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between mb-1">
                            <p class="font-medium text-sm">{{ $review->customer->name ?? 'Anonymous' }}</p>

                            <div class="text-yellow-500 text-sm">
                                @for ($i=1; $i<=5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 text-sm">No reviews yet.</p>
        @endif

    </div>
</div>
@endsection
