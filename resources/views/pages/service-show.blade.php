@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 text-white">
    <div class="bg-black/40 backdrop-blur-lg border border-white/10 rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:space-x-8">
            <!-- Image -->
            <div class="md:w-1/3 mb-6 md:mb-0 relative group">
                @if ($service->image && Storage::disk('public')->exists($service->image))
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                         class="rounded-xl w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-gray-800 to-gray-700 flex flex-col items-center justify-center rounded-xl text-gray-400 text-sm">
                        <i class="bi bi-image text-5xl mb-2"></i>
                        <span>No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <h1 class="text-3xl md:text-4xl font-bold text-orange-400 mb-3 tracking-tight">
                    {{ $service->title }}
                </h1>
                <p class="text-gray-300 mb-6 leading-relaxed">{{ $service->description }}</p>

                <div class="flex justify-between items-center mb-6">
                    <p class="text-2xl font-semibold text-white">₱{{ number_format($service->price, 2) }}</p>
                    <span class="text-sm bg-gradient-to-r from-green-600 to-emerald-500 px-3 py-1 rounded-md font-medium">
                        {{ ucfirst($service->category) ?? 'Uncategorized' }}
                    </span>
                </div>

                @if(Auth::check() && Auth::user()->role === 'customer')
                    <div class="flex flex-wrap gap-3">
                        <form action="{{ route('customer.book.service', $service->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200">
                                <i class="bi bi-calendar-check mr-2"></i> Book This Service
                            </button>
                        </form>

                        <a href="{{ route('customer.messages.index') }}"
                           class="bg-blue-500 hover:bg-blue-600 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200">
                            <i class="bi bi-chat-dots mr-2"></i> Message Provider
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-10 border-gray-700">

        <!-- Provider Info -->
        <div>
            <h2 class="text-2xl font-semibold text-orange-300 mb-6 flex items-center gap-2">
                <i class="bi bi-person-circle text-orange-400"></i> Provider Information
            </h2>

            @if ($service->provider && $service->provider->profile)
                <div class="flex items-center space-x-5">
                    @if ($service->provider->profile->photo && Storage::disk('public')->exists($service->provider->profile->photo))
                        <img src="{{ asset('storage/' . $service->provider->profile->photo) }}"
                             class="w-20 h-20 rounded-full object-cover border border-white/20 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 text-2xl">
                            <i class="bi bi-person"></i>
                        </div>
                    @endif

                    <div>
                        <p class="font-bold text-xl">{{ $service->provider->name }}</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $service->provider->profile->bio ?? 'No bio available.' }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-400">Provider information not available.</p>
            @endif
        </div>

        <!-- Divider -->
        <hr class="my-10 border-gray-700">

        <!-- Reviews -->
        <div>
            <h2 class="text-2xl font-semibold text-orange-300 mb-6 flex items-center gap-2">
                <i class="bi bi-star-fill text-yellow-400"></i> Customer Reviews
            </h2>

            @if ($service->reviews && $service->reviews->count() > 0)
                <div class="space-y-5 mb-8">
                    @foreach ($service->reviews as $review)
                        <div class="bg-white/10 rounded-lg p-5 border border-white/10 shadow-sm hover:bg-white/15 transition-all">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold">{{ $review->customer->name ?? 'Anonymous' }}</p>
                                <div class="flex items-center gap-1 text-yellow-400 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Posted {{ $review->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 mb-6">No reviews yet. Be the first to leave one!</p>
            @endif

            <!-- Review Form -->
            @if (Auth::check() && Auth::user()->role === 'customer')
                <div class="bg-white/10 rounded-xl p-6 border border-white/10">
                    <h3 class="text-xl font-semibold text-orange-300 mb-4">Leave a Review</h3>

                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="provider_id" value="{{ $service->user_id }}">

                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                            <select name="rating" id="rating"
                                    class="w-full rounded-md bg-black/30 border border-white/20 text-white p-2 focus:ring-2 focus:ring-orange-400"
                                    required>
                                <option value="">Select rating</option>
                                <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
                                <option value="4">⭐⭐⭐⭐ - Good</option>
                                <option value="3">⭐⭐⭐ - Average</option>
                                <option value="2">⭐⭐ - Poor</option>
                                <option value="1">⭐ - Very Bad</option>
                            </select>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">Your Review</label>
                            <textarea name="comment" id="comment" rows="4"
                                      class="w-full rounded-md bg-black/30 border border-white/20 text-white p-2 focus:ring-2 focus:ring-orange-400"
                                      placeholder="Share your experience..." required></textarea>
                        </div>

                        <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200">
                            <i class="bi bi-send"></i> Submit Review
                        </button>
                    </form>
                </div>
            @else
                <p class="text-gray-400 text-sm">You must be logged in as a customer to leave a review.</p>
            @endif
        </div>
    </div>
</div>
@endsection
