@extends('layouts.app')

@section('title', 'Services | ServEase')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- PAGE TITLE --}}
    <h1 class="text-2xl md:text-3xl font-bold text-center text-blue-600 mb-6 md:mb-8">
        Available Services
    </h1>

    {{-- FILTERS BAR --}}
    <form method="GET" action="{{ route('services.index') }}"
          class="bg-white p-4 md:p-5 rounded-xl shadow mb-8 grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">

        {{-- SEARCH INPUT --}}
        <div class="md:col-span-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search services..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base"
            >
        </div>

        {{-- CATEGORY DROPDOWN --}}
        <div>
            <select
                name="category"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base"
            >
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div>
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm md:text-base transition"
            >
                Apply Filters
            </button>
        </div>

    </form>

    {{-- EMPTY STATE --}}
    @if ($services->isEmpty())
        <div class="text-center py-8">
            <i class="bi bi-search text-4xl text-gray-400"></i>
            <p class="text-gray-500 text-base mt-2">No services found.</p>
            <p class="text-gray-400 text-sm">Try adjusting your filters.</p>
        </div>
    @else
        {{-- SERVICES GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">

            @foreach ($services as $service)
                @if ($service->status === 'approved')
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">

                        {{-- IMAGE --}}
                        @if ($service->image && Storage::disk('public')->exists($service->image))
                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-blue-100 flex flex-col items-center justify-center text-blue-500">
                                <i class="bi bi-image text-3xl mb-1"></i>
                                <span class="text-xs">No Image Available</span>
                            </div>
                        @endif

                        {{-- BODY --}}
                        <div class="p-3 md:p-4 relative">

                            <span class="absolute top-3 right-3 bg-green-500 text-white text-xs px-2 py-0.5 rounded-md shadow">
                                ✔ Approved
                            </span>

                            <h3 class="text-base md:text-lg font-semibold text-gray-800">
                                {{ $service->title }}
                            </h3>

                            <p class="text-gray-600 text-xs md:text-sm mt-1 md:mt-2 line-clamp-3">
                                {{ Str::limit($service->description, 70) }}
                            </p>

                            <div class="flex justify-between items-center mt-3 md:mt-4">
                                <p class="text-sm md:text-base font-bold text-blue-600">
                                    ₱{{ number_format($service->price, 2) }}
                                </p>

                                <span class="text-xs md:text-sm bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                                    {{ $service->category ?: 'Uncategorized' }}
                                </span>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="bg-gray-50 border-t px-3 md:px-4 py-2 flex justify-between items-center text-sm md:text-base">
                            <div class="flex items-center gap-1 md:gap-2 text-gray-700">
                                <i class="bi bi-person-circle text-blue-600 text-lg"></i>
                                <span>{{ $service->provider->name ?? 'Unknown' }}</span>
                            </div>
                            <a href="{{ route('services.show', $service->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-xs md:text-sm transition">
                                View
                            </a>
                        </div>

                    </div>
                @endif
            @endforeach

        </div>
    @endif
</div>
@endsection
