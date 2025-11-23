@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="bg-gray-300 rounded-2xl shadow-xl p-10">

        {{-- Top Section --}}
        <div class="flex flex-col md:flex-row gap-10">

            {{-- Image --}}
            <div class="md:w-1/3">
                @if ($service->image && Storage::disk('public')->exists($service->image))
                    <img src="{{ asset('storage/' . $service->image) }}"
                         class="w-full h-64 object-cover rounded-xl shadow-md">
                @else
                    <div class="w-full h-64 bg-gradient-to-b from-gray-800 to-gray-700 flex flex-col items-center justify-center rounded-xl text-gray-300">
                        <i class="bi bi-image text-5xl mb-2"></i>
                        <span>No Image Available</span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1">

                <div class="flex items-center justify-between mb-3">
                    <h1 class="text-4xl font-bold text-orange-400">
                        {{ $service->title }}
                    </h1>

                    {{-- Tiny Approved indicator --}}
                    <span class="w-6 h-2 rounded-full bg-green-500"></span>
                </div>

                <p class="text-gray-700 mb-4">
                    {{ $service->description }}
                </p>

                <p class="text-2xl font-bold text-gray-800 mb-6">
                    ₱{{ number_format($service->price, 2) }}
                </p>

            </div>

        </div>

        {{-- Divider --}}
        <hr class="my-10 border-gray-400">

        {{-- Provider Info --}}
        <h2 class="text-xl font-bold text-orange-400 mb-4 flex items-center gap-2">
            <i class="bi bi-person-circle text-orange-500"></i> Provider Information
        </h2>

        @if ($service->provider && $service->provider->profile)
            <div class="flex items-center gap-5">
                @if ($service->provider->profile->photo && Storage::disk('public')->exists($service->provider->profile->photo))
                    <img src="{{ asset('storage/' . $service->provider->profile->photo) }}"
                         class="w-20 h-20 rounded-full object-cover shadow-md">
                @else
                    <div class="w-20 h-20 bg-gray-700 flex items-center justify-center rounded-full text-gray-300 text-3xl">
                        <i class="bi bi-person"></i>
                    </div>
                @endif

                <div>
                    <p class="font-bold text-xl text-gray-900">{{ $service->provider->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $service->provider->profile->bio ?? 'No bio available.' }}</p>
                </div>
            </div>
        @else
            <p class="text-gray-600">Provider information not available.</p>
        @endif

        {{-- Divider --}}
        <hr class="my-10 border-gray-400">

        {{-- Customer Reviews --}}
        <h2 class="text-xl font-bold text-orange-400 mb-6 flex items-center gap-2">
            <i class="bi bi-star-fill text-yellow-500"></i> Customer Reviews
        </h2>

        @if ($service->reviews->count() > 0)
            <div class="space-y-5 mb-6">
                @foreach ($service->reviews as $review)
                    <div class="bg-white p-5 rounded-xl shadow">
                        <div class="flex justify-between mb-2">
                            <p class="font-semibold">{{ $review->customer->name ?? 'Anonymous' }}</p>
                            <div class="text-yellow-500">
                                @for ($i=1; $i<=5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No reviews yet.</p>
        @endif

    </div>

</div>
@endsection
