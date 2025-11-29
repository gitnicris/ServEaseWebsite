@extends('layouts.app')

@section('title', 'Home | ServEase')

@section('content')

{{-- HERO SECTION --}}
<div class="mb-4">
    <div class="p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #2563eb, #111827);">
        <h1 class="h3 fw-bold mb-1">Find Reliable Service Providers Near You</h1>
        <p class="small mb-3 opacity-75">
            From repairs to personal care — ServEase connects you with trusted experts.
        </p>

        {{-- SEARCH FORM → goes to ServiceController@browse (services.index) --}}
        <form action="{{ route('services.index') }}" method="GET" class="row g-2">
            <div class="col-12 col-md-9">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search for services (e.g., electrician, plumbing, cleaning...)"
                       class="form-control form-control-sm rounded-pill">
            </div>
            <div class="col-12 col-md-3 d-grid">
                <button class="btn btn-light btn-sm fw-semibold rounded-pill">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

{{-- POPULAR CATEGORIES --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h6 mb-0 fw-semibold">Popular Categories</h2>
    </div>

    <div class="row g-3">
        @php
            $categories = [
                ['icon' => 'tools', 'label' => 'Home Repair'],
                ['icon' => 'lightning-charge', 'label' => 'Electrical'],
                ['icon' => 'water', 'label' => 'Plumbing'],
                ['icon' => 'scissors', 'label' => 'Personal Care'],
            ];
        @endphp

        @foreach($categories as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('services.index', ['category' => $cat['label']]) }}"
                   class="text-decoration-none">
                    <div class="border rounded-3 p-3 h-100 d-flex flex-column align-items-center justify-content-center shadow-sm bg-white hover-shadow-sm">
                        <i class="bi bi-{{ $cat['icon'] }} fs-3 mb-2 text-primary"></i>
                        <span class="fw-medium text-dark small text-center">{{ $cat['label'] }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

{{-- TOP RATED PROVIDERS --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h6 mb-0 fw-semibold">Top Rated Service Providers</h2>
    </div>

    @php
        $providers = \App\Models\User::where('role','provider')
                     ->with(['providerProfile.reviews'])
                     ->limit(4)
                     ->get();
    @endphp

    @if ($providers->count() > 0)
        <div class="row g-3">
            @foreach ($providers as $provider)
                @php
                    $profile = $provider->providerProfile; 
                    $rating = $profile?->reviews->avg('rating') ? round($profile->reviews->avg('rating'), 1) : 0;
                    $bio = $profile?->bio ?? 'No description available';
                    $photo = $profile?->photo ? asset('storage/'.$profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($provider->name);
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <a href="{{ route('providers.public-profile', $provider->id) }}"
                       class="text-decoration-none text-dark">
                        <div class="border rounded-3 p-3 bg-white d-flex gap-3 align-items-center shadow-sm hover-shadow-sm">
                            <img src="{{ $photo }}"
                                 alt="Provider"
                                 class="rounded-circle border"
                                 style="width: 56px; height: 56px; object-fit: cover;">

                            <div class="flex-grow-1">
                                <h3 class="h6 fw-semibold mb-1">{{ $provider->name }}</h3>
                                <p class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($bio, 55) }}</p>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning small"></i>
                                    <span class="ms-1 small fw-semibold">{{ $rating }}/5</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small mb-0">No providers available yet.</p>
    @endif
</div>


{{-- WHY CHOOSE US --}}
<div class="mb-4">
    <h2 class="h6 fw-semibold mb-2">Why Choose ServEase?</h2>

    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="border rounded-3 p-3 bg-white text-center h-100 shadow-sm">
                <i class="bi bi-shield-check fs-3 text-primary mb-2"></i>
                <h4 class="fw-semibold small mb-1">Trusted Providers</h4>
                <p class="small text-muted mb-0">All providers are verified and reviewed.</p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="border rounded-3 p-3 bg-white text-center h-100 shadow-sm">
                <i class="bi bi-lightning fs-3 text-primary mb-2"></i>
                <h4 class="fw-semibold small mb-1">Fast Booking</h4>
                <p class="small text-muted mb-0">Book services quickly and easily.</p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="border rounded-3 p-3 bg-white text-center h-100 shadow-sm">
                <i class="bi bi-chat-dots fs-3 text-primary mb-2"></i>
                <h4 class="fw-semibold small mb-1">Direct Messaging</h4>
                <p class="small text-muted mb-0">Communicate directly with the provider.</p>
            </div>
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="mt-3 p-4 rounded-3 text-center text-white" style="background: #2563eb;">
    <h3 class="h6 fw-semibold mb-2">Need help? Find a provider now!</h3>
    <a href="{{ route('services.index') }}"
       class="btn btn-light btn-sm fw-semibold rounded-pill">
        Explore Services
    </a>
</div>

@endsection
