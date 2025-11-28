@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:space-x-8">
            <!-- Image -->
            <div class="md:w-1/3 mb-6 md:mb-0 relative group">
                @if ($service->image && Storage::disk('public')->exists($service->image))
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                         class="rounded-xl w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                @else
                    <div class="w-full h-64 bg-gray-100 flex flex-col items-center justify-center rounded-xl text-gray-400 text-sm">
                        <i class="bi bi-image text-5xl mb-2"></i>
                        <span>No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3 tracking-tight">
                    {{ $service->title }}
                </h1>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ $service->description }}</p>

                <div class="flex justify-between items-center mb-6">
                    <p class="text-2xl font-semibold text-gray-800">₱{{ number_format($service->price, 2) }}</p>
                    <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-md font-medium">
                        {{ $service->category ? ucfirst($service->category) : 'Uncategorized' }}
                    </span>
                </div>

                @if(Auth::check() && Auth::user()->role === 'customer')
                    <div class="flex flex-wrap gap-3">
                        <!-- Book Service Button -->
                        <button type="button" onclick="toggleBookingModal()"
                                class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200 flex items-center gap-2">
                            <i class="bi bi-calendar-check"></i> Book This Service
                        </button>

                        <!-- Message Provider -->
                        <a href="{{ route('customer.messages.index') }}"
                           class="bg-blue-500 hover:bg-blue-600 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200 flex items-center gap-2">
                            <i class="bi bi-chat-dots"></i> Message Provider
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-10 border-gray-200">

        <!-- Provider Info -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                <i class="bi bi-person-circle text-blue-600"></i> Provider Information
            </h2>

            @php
                $provider = $service->provider;
                $profile  = $provider?->providerProfile;
            @endphp

            @if ($provider && $profile)
                <a href="{{ route('providers.public-profile', $provider->id) }}"
                   class="group flex flex-col md:flex-row md:items-center md:space-x-5 cursor-pointer">

                    <div class="mb-4 md:mb-0">
                        @if ($profile->photo && Storage::disk('public')->exists($profile->photo))
                            <img src="{{ asset('storage/' . $profile->photo) }}"
                                 class="w-20 h-20 rounded-full object-cover border border-gray-200 shadow-md transition-transform duration-200 group-hover:scale-105">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-2xl border transition-transform duration-200 group-hover:scale-105">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-xl group-hover:text-blue-600 transition-colors">
                                {{ $provider->name }}
                            </p>
                            <span class="text-[11px] uppercase tracking-wide bg-gray-100 px-2 py-0.5 rounded-full text-gray-700">
                                View full profile
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm mt-1">
                            {{ $profile->bio ?? 'No bio available.' }}
                        </p>

                        <div class="grid sm:grid-cols-2 gap-3 mt-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-geo-alt text-blue-600"></i>
                                <span>{{ $profile->address ?: 'Address not provided' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-telephone text-blue-600"></i>
                                <span>{{ $profile->phone ?: 'Phone not provided' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-envelope text-blue-600"></i>
                                <span>{{ $profile->gmail ?: 'Email not provided' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-info-circle text-blue-600"></i>
                                <span>{{ $profile->about ? \Illuminate\Support\Str::limit($profile->about, 70) : 'No additional info yet.' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @else
                <p class="text-gray-400">Provider information not available.</p>
            @endif
        </div>

        <!-- Divider -->
        <hr class="my-10 border-gray-200">

        <!-- Reviews -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                <i class="bi bi-star-fill text-yellow-400"></i> Customer Reviews
            </h2>

            @if ($service->reviews && $service->reviews->count() > 0)
                <div class="space-y-5 mb-8">
                    @foreach ($service->reviews as $review)
                        <div class="bg-gray-100 rounded-lg p-5 border border-gray-200 shadow-sm hover:bg-gray-50 transition-all">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold text-gray-800">{{ $review->customer->name ?? 'Anonymous' }}</p>
                                <div class="flex items-center gap-1 text-yellow-400 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Posted {{ $review->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 mb-6">No reviews yet. Be the first to leave one!</p>
            @endif

            @if (Auth::check() && Auth::user()->role === 'customer')
                <button type="button" onclick="toggleReviewModal()"
                        class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg text-white font-semibold transition-all duration-200 flex items-center gap-2">
                    <i class="bi bi-send"></i> Leave Review
                </button>
            @else
                <p class="text-gray-600 text-sm mt-2">Login as customer to leave a review.</p>
            @endif
        </div>

    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/25 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative">
        <button onclick="toggleBookingModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-lg">
            <i class="bi bi-x-lg"></i>
        </button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">Book Service</h2>

        <form action="{{ route('customer.book.service', $service->id) }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label for="date" class="block text-sm text-gray-700 mb-1">Select Date</label>
                <input type="date" name="date" id="date" required
                       class="w-full rounded-md border border-gray-300 p-2 text-gray-800 text-sm focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="time" class="block text-sm text-gray-700 mb-1">Select Time</label>
                <input type="time" name="time" id="time" required
                       class="w-full rounded-md border border-gray-300 p-2 text-gray-800 text-sm focus:ring-2 focus:ring-blue-600">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                <i class="bi bi-calendar-check"></i> Confirm Booking
            </button>
        </form>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black/25 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative">
        <button onclick="toggleReviewModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-lg">
            <i class="bi bi-x-lg"></i>
        </button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">Leave a Review</h2>

        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="provider_id" value="{{ $service->user_id }}">

            <div>
                <label for="rating" class="block text-sm text-gray-700 mb-1">Rating</label>
                <select name="rating" id="rating" required
                        class="w-full rounded-md border border-gray-300 p-2 text-gray-800 text-sm focus:ring-2 focus:ring-blue-600">
                    <option value="">Select rating</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>

            <div>
                <label for="comment" class="block text-sm text-gray-700 mb-1">Comment</label>
                <textarea name="comment" id="comment" rows="3" required
                          class="w-full rounded-md border border-gray-300 p-2 text-gray-800 text-sm focus:ring-2 focus:ring-blue-600"
                          placeholder="Share your experience..."></textarea>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                <i class="bi bi-send"></i> Submit Review
            </button>
        </form>
    </div>
</div>

<script>
function toggleBookingModal() {
    document.getElementById('bookingModal').classList.toggle('hidden');
}

function toggleReviewModal() {
    document.getElementById('reviewModal').classList.toggle('hidden');
}
</script>
@endsection
