@extends('layouts.app')

@section('title', 'Services | ServEase')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- PAGE TITLE --}}
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">
        Available Services
    </h1>

    {{-- FILTERS BAR --}}
    <form method="GET" action="{{ route('services.index') }}"
          class="bg-white p-5 rounded-xl shadow mb-10 grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- SEARCH INPUT --}}
        <div class="md:col-span-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search services..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        {{-- CATEGORY DROPDOWN --}}
        <div>
            <select
                name="category"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}"
                        {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div>
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition"
            >
                Apply Filters
            </button>
        </div>

    </form>

    {{-- EMPTY STATE --}}
    @if ($services->isEmpty())
        <div class="text-center py-16">
            <i class="bi bi-search text-5xl text-gray-400"></i>
            <p class="text-gray-500 text-lg mt-3">No services found.</p>
            <p class="text-gray-400 text-sm">Try adjusting your filters.</p>
        </div>
    @else

        {{-- SERVICES GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($services as $service)
                @if ($service->status === 'approved')

                    <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden">

                        {{-- IMAGE --}}
                        @if ($service->image && Storage::disk('public')->exists($service->image))
                            <img src="{{ asset('storage/' . $service->image) }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-blue-100 flex flex-col items-center justify-center text-blue-500">
                                <i class="bi bi-image text-4xl mb-2"></i>
                                <span class="text-sm">No Image Available</span>
                            </div>
                        @endif

                        {{-- BODY --}}
                        <div class="p-5 relative">

                            <span class="absolute top-5 right-5 bg-green-500 text-white text-xs px-3 py-1 rounded-md shadow">
                                ✔ Approved
                            </span>

                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $service->title }}
                            </h3>

                            <p class="text-gray-600 text-sm mt-2">
                                {{ Str::limit($service->description, 70) }}
                            </p>

                            <div class="flex justify-between items-center mt-4">
                                <p class="text-xl font-bold text-blue-600">
                                    ₱{{ number_format($service->price, 2) }}
                                </p>

                                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                    {{ $service->category ?: 'Uncategorized' }}
                                </span>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="bg-gray-50 border-t px-5 py-4 flex justify-between items-center">
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="bi bi-person-circle text-blue-600 text-lg"></i>
                                <span>{{ $service->provider->name ?? 'Unknown' }}</span>
                            </div>
                            <a href="{{ route('services.show', $service->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg transition">
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
