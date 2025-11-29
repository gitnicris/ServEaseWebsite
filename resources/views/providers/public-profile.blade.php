@extends('layouts.app')

@section('title', $profile->name . ' | Provider Profile')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8 text-gray-900 space-y-8">

    <!-- 🌈 Public Profile Header -->
    <div class="bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-600 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row items-center justify-between text-white">
        <div class="flex items-center space-x-4 md:space-x-6">
            <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($profile->name) }}"
                 alt="Profile Photo"
                 class="w-20 h-20 md:w-28 md:h-28 rounded-full border-4 border-white/20 shadow-lg object-cover">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">{{ $profile->name }}</h1>
                <p class="text-sm md:text-base mt-1">{{ $profile->bio ?: 'No bio provided yet.' }}</p>

                <!-- ⭐ Rating -->
                <div class="flex items-center mt-2 md:mt-3 text-yellow-300">
                    @php $rating = $averageRating ?? 0; @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <i class="bi {{ $i < $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                    <span class="ml-2 text-sm md:text-base">({{ $rating }}/5)</span>
                </div>
            </div>
        </div>

        <!-- 👥 Customer Action -->
        @auth
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('customer.messages.index') }}" 
                   class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition flex items-center gap-2">
                    <i class="bi bi-chat-dots"></i> Message Provider
                </a>
            @endif
        @endauth
    </div>

    <!-- 📋 Profile Information -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2 flex items-center gap-2">
                <i class="bi bi-person-lines-fill text-gray-700"></i> Personal Details
            </h2>
            <div class="space-y-2 text-gray-700 text-sm md:text-base">
                <p><strong>Name:</strong> {{ $profile->name }}</p>
                <p><strong>Address:</strong> {{ $profile->address ?: 'Not provided' }}</p>
                <p><strong>Phone:</strong> {{ $profile->phone ?: 'Not provided' }}</p>
                <p><strong>Email:</strong> {{ $profile->gmail ?: 'Not provided' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2 flex items-center gap-2">
                <i class="bi bi-info-circle text-gray-700"></i> About Me
            </h2>
            <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                {{ $profile->about ?: 'This provider has not added an about section yet.' }}
            </p>
        </div>
    </div>

    <!-- 📋 Reviews -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2 flex items-center gap-2">
            <i class="bi bi-star-half text-yellow-400"></i> Customer Reviews
        </h2>

        <p class="text-gray-700 text-sm md:text-base mb-4">
            ⭐ <span class="text-yellow-400 font-semibold">{{ $averageRating ?? 0 }}/5</span> average rating
            ({{ $reviews->total() ?? 0 }} {{ Str::plural('review', $reviews->total() ?? 0) }})
        </p>

        @if($reviews->count() > 0)
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="bg-gray-50 border border-gray-200 p-3 md:p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $review->customer->name ?? 'Anonymous' }}</p>
                                <p class="text-gray-500 text-xs md:text-sm">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="bi {{ $i < $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700 text-sm md:text-base">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @else
            <p class="text-gray-500 italic">No reviews yet.</p>
        @endif
    </div>
</div>
@endsection
