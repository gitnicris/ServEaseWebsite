@extends('layouts.app')

@section('title', 'Provider Profile')

@section('content')
<div class="space-y-6">

    <!-- 🌈 Public Profile Header -->
    <div class="bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-600 rounded-xl shadow-md p-5 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4 md:gap-6">
            <div class="relative">
                <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($profile->name) }}"
                     alt="Profile Photo"
                     class="w-20 h-20 md:w-24 md:h-24 rounded-full border-2 border-white/20 shadow-md object-cover">
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">{{ $profile->name }}</h1>
                <p class="text-sm md:text-base text-gray-200 mt-1">{{ $profile->bio ?: 'No bio provided yet.' }}</p>

                <!-- ⭐ Rating -->
                <div class="flex items-center mt-1 text-yellow-400 text-sm md:text-base">
                    @php $rating = $averageRating ?? 0; @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <i class="bi {{ $i < $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                    <span class="ml-2 text-gray-100">({{ $rating }}/5)</span>
                </div>
            </div>
        </div>

        <!-- 👥 Customer Actions -->
        @auth
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('customer.messages.index') }}" 
                   class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 md:px-5 py-2 rounded-md text-sm md:text-base flex items-center gap-1 mt-3 md:mt-0">
                    <i class="bi bi-chat-dots"></i> Message Provider
                </a>
            @endif
        @endauth
    </div>

    <!-- 📋 Profile Information -->
    <div class="grid md:grid-cols-2 gap-4 md:gap-6">
        <!-- 🏠 Personal Info -->
        <div class="bg-white rounded-md shadow-sm p-4 hover:shadow-md transition">
            <h2 class="text-md md:text-lg font-semibold text-sky-500 mb-2 md:mb-3 border-b border-gray-200 pb-1 flex items-center gap-1">
                <i class="bi bi-person-lines-fill"></i> Personal Details
            </h2>
            <div class="space-y-1 text-gray-700 text-sm md:text-base">
                <p><strong>Name:</strong> {{ $profile->name }}</p>
                <p><strong>Address:</strong> {{ $profile->address ?: 'Not provided' }}</p>
                <p><strong>Phone:</strong> {{ $profile->phone ?: 'Not provided' }}</p>
                <p><strong>Email:</strong> {{ $profile->gmail ?: 'Not provided' }}</p>
            </div>
        </div>

        <!-- 💬 About Section -->
        <div class="bg-white rounded-md shadow-sm p-4 hover:shadow-md transition">
            <h2 class="text-md md:text-lg font-semibold text-sky-500 mb-2 md:mb-3 border-b border-gray-200 pb-1 flex items-center gap-1">
                <i class="bi bi-info-circle"></i> About Me
            </h2>
            <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                {{ $profile->about ?: 'This provider has not added an about section yet.' }}
            </p>
        </div>
    </div>

    <!-- 📋 Review Summary -->
    <div class="bg-white rounded-md shadow-sm p-4 hover:shadow-md transition">
        <h2 class="text-md md:text-lg font-semibold text-sky-500 mb-2 md:mb-3 border-b border-gray-200 pb-1 flex items-center gap-1">
            <i class="bi bi-star-half text-yellow-400"></i> Customer Reviews
        </h2>

        <div class="mb-3 text-sm md:text-base text-gray-700">
            ⭐ <span class="text-yellow-400 font-semibold">{{ $averageRating ?? 0 }}/5</span> average rating 
            ({{ $profile->reviews->count() }} {{ Str::plural('review', $profile->reviews->count()) }})
        </div>

        @if($profile->reviews->count() > 0)
            <div class="space-y-3">
                @foreach($profile->reviews as $review)
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded-md">
                        <div class="flex items-center justify-between text-sm md:text-base">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $review->customer->name ?? 'Anonymous' }}</p>
                                <p class="text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="bi {{ $i < $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-1 text-gray-700 text-sm md:text-base">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic text-sm md:text-base">No reviews yet.</p>
        @endif
    </div>

</div>
@endsection
