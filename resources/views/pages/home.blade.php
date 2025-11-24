@extends('layouts.app')

@section('title', 'Home | ServEase')

@section('content')

{{-- HERO SECTION --}}
<div class="mb-8">
    <div class="p-6 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md">
        <h1 class="text-3xl font-bold mb-1">Find Reliable Service Providers Near You</h1>
        <p class="text-sm opacity-90">From repairs to personal care — ServEase connects you with trusted experts.</p>

        <form action="{{ route('services.index') }}" method="GET" class="flex gap-2 mt-4">
            <input type="text" name="search"
                   placeholder="Search for services (e.g., electrician, plumbing, cleaning...)"
                   class="flex-1 px-3 py-2 rounded-lg text-gray-800 border border-gray-300 focus:outline-none">
            <button class="px-4 py-2 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100">
                Search
            </button>
        </form>
    </div>
</div>

{{-- POPULAR CATEGORIES --}}
<div class="mb-10">
    <h2 class="text-xl font-semibold mb-4">Popular Categories</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $categories = [
                ['icon' => 'tools', 'label' => 'Home Repair'],
                ['icon' => 'lightning-charge', 'label' => 'Electrical'],
                ['icon' => 'water', 'label' => 'Plumbing'],
                ['icon' => 'scissors', 'label' => 'Personal Care'],
            ];
        @endphp

        @foreach($categories as $cat)
            <a href="{{ route('services.index') }}?category={{ urlencode($cat['label']) }}"
               class="p-4 bg-white shadow rounded-lg border hover:shadow-md transition flex flex-col items-center">
                <i class="bi bi-{{ $cat['icon'] }} text-3xl mb-2 text-blue-600"></i>
                <span class="font-medium">{{ $cat['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

{{-- TOP RATED PROVIDERS --}}
<div class="mb-12">
    <h2 class="text-xl font-semibold mb-4">Top Rated Service Providers</h2>

    @php
        $providers = \App\Models\User::where('role','provider')
                     ->with('providerProfile.reviews')
                     ->limit(4)
                     ->get();
    @endphp

    @if ($providers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($providers as $provider)
                @php
                    $profile = $provider->providerProfile;
                    $rating = round($profile?->reviews->avg('rating') ?? 0, 1);
                @endphp

                <a href="{{ route('services.show', $provider->id) }}"
                   class="bg-white p-4 rounded-lg border shadow hover:shadow-md transition flex gap-4">

                    <img src="{{ $profile->photo ?? 'https://ui-avatars.com/api/?name='.urlencode($provider->name) }}"
                         class="w-16 h-16 rounded-full object-cover border">

                    <div class="flex flex-col">
                        <h3 class="font-semibold text-lg">{{ $provider->name }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ Str::limit($profile->bio ?? 'No description available', 55) }}
                        </p>

                        <div class="flex items-center mt-1">
                            <i class="bi bi-star-fill text-yellow-500 text-sm"></i>
                            <span class="ml-1 text-sm font-medium">{{ $rating }}/5</span>
                        </div>
                    </div>

                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No providers available yet.</p>
    @endif
</div>

{{-- WHY CHOOSE US --}}
<div class="mb-12">
    <h2 class="text-xl font-semibold mb-4">Why Choose ServEase?</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-white border rounded-lg shadow text-center">
            <i class="bi bi-shield-check text-3xl text-blue-600"></i>
            <h4 class="font-semibold mt-2">Trusted Providers</h4>
            <p class="text-sm text-gray-600">All providers are verified and reviewed.</p>
        </div>

        <div class="p-4 bg-white border rounded-lg shadow text-center">
            <i class="bi bi-lightning text-3xl text-blue-600"></i>
            <h4 class="font-semibold mt-2">Fast Booking</h4>
            <p class="text-sm text-gray-600">Book services quickly and easily.</p>
        </div>

        <div class="p-4 bg-white border rounded-lg shadow text-center">
            <i class="bi bi-chat-dots text-3xl text-blue-600"></i>
            <h4 class="font-semibold mt-2">Direct Messaging</h4>
            <p class="text-sm text-gray-600">Communicate directly with the provider.</p>
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="mt-8 p-6 bg-blue-600 text-white text-center rounded-xl shadow">
    <h3 class="text-xl font-semibold">Need help? Find a provider now!</h3>
    <a href="{{ route('services.index') }}"
       class="mt-3 inline-block bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-100">
        Explore Services
    </a>
</div>

@endsection
