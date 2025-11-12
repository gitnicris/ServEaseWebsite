@extends('layouts.app')

@section('title', 'Provider Profile')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 text-white space-y-10">

    <!-- 🌈 Profile Header -->
    <div class="bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-600 rounded-3xl shadow-2xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-6">
            <div class="relative group">
                <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($profile->name) }}"
                     alt="Profile Photo"
                     class="w-28 h-28 rounded-full border-4 border-white/20 shadow-lg object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 rounded-full bg-white/10 opacity-0 group-hover:opacity-100 transition"></div>
            </div>

            <div>
                <h1 class="text-3xl font-bold">{{ $profile->name }}</h1>
                <p class="text-sm text-gray-200 mt-1">{{ $profile->bio ?: 'No bio provided yet.' }}</p>

                <!-- ⭐ Rating -->
                <div class="flex items-center mt-3 text-yellow-300">
                    @php $rating = $profile->review ?? 0; @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <i class="bi {{ $i < $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                    <span class="ml-2 text-sm text-gray-100">({{ $rating }}/5)</span>
                </div>
            </div>
        </div>

        <!-- ✏️ Action Buttons -->
        <div class="flex flex-col md:flex-row md:space-x-4 mt-6 md:mt-0 space-y-3 md:space-y-0">
            <a href="{{ route('provider.edit-profile') }}" 
               class="bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-2.5 rounded-lg backdrop-blur-md transition">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>

            <a href="{{ route('provider.messages.index') }}" 
               class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="bi bi-chat-dots me-1"></i> Chat
            </a>
        </div>
    </div>

    <!-- 📋 Profile Information -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- 🏠 Personal Info -->
        <div class="bg-white/10 border border-white/10 rounded-2xl shadow-lg p-6 hover:shadow-2xl transition">
            <h2 class="text-xl font-semibold text-orange-300 mb-4 border-b border-white/20 pb-2 flex items-center gap-2">
                <i class="bi bi-person-lines-fill text-orange-400"></i> Personal Details
            </h2>
            <div class="space-y-3 text-gray-200">
                <p><strong>Name:</strong> {{ $profile->name }}</p>
                <p><strong>Address:</strong> {{ $profile->address ?: 'Not provided' }}</p>
                <p><strong>Phone:</strong> {{ $profile->phone ?: 'Not provided' }}</p>
                <p><strong>Email:</strong> {{ $profile->gmail ?: 'Not provided' }}</p>
            </div>
        </div>

        <!-- 💬 About Section -->
        <div class="bg-white/10 border border-white/10 rounded-2xl shadow-lg p-6 hover:shadow-2xl transition">
            <h2 class="text-xl font-semibold text-orange-300 mb-4 border-b border-white/20 pb-2 flex items-center gap-2">
                <i class="bi bi-info-circle text-orange-400"></i> About Me
            </h2>
            <p class="text-gray-200 leading-relaxed">
                {{ $profile->about ?: 'This provider has not added an about section yet.' }}
            </p>
        </div>
    </div>

    <!-- 📋 Review Summary -->
<div class="bg-white/10 border border-white/10 rounded-2xl shadow-lg p-6 hover:shadow-2xl transition">
    <h2 class="text-xl font-semibold text-orange-300 mb-4 border-b border-white/20 pb-2 flex items-center gap-2">
        <i class="bi bi-star-half text-yellow-400"></i> Customer Reviews
    </h2>

    <div class="mb-6">
        <p class="text-gray-200 text-lg">
            ⭐ <span class="text-yellow-400 font-semibold">{{ $averageRating ?? 0 }}/5</span> average rating 
            ({{ $profile->reviews->count() }} {{ Str::plural('review', $profile->reviews->count()) }})
        </p>
    </div>

    @if($profile->reviews->count() > 0)
        <div class="space-y-5">
            @foreach($profile->reviews as $review)
                <div class="bg-white/5 border border-white/10 p-4 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-white">{{ $review->customer->name ?? 'Anonymous' }}</p>
                            <p class="text-sm text-gray-300">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="bi {{ $i < $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="mt-3 text-gray-200">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-400 italic">No reviews yet.</p>
    @endif
</div>


</div>
@endsection
