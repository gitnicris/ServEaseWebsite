@extends('layouts.app')

@section('title', 'Provider Profile')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-8">
    <!-- 🌈 Profile Header -->
    <div class="bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-500 text-white rounded-3xl shadow-2xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-6">
            <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($profile->name) }}" 
                 class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover" 
                 alt="Profile Photo">
            <div>
                <h1 class="text-3xl font-bold">{{ $profile->name }}</h1>
                <p class="text-sm text-gray-200 mt-1">{{ $profile->bio ?: 'No bio provided yet.' }}</p>
                <div class="flex items-center mt-2 text-yellow-300">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="bi {{ $i < $profile->review ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                    <span class="ml-2 text-sm text-gray-200">({{ $profile->review ?? 0 }}/5)</span>
                </div>
            </div>
        </div>

        <!-- ✏️ Buttons -->
        <div class="flex flex-col md:flex-row md:space-x-4 mt-5 md:mt-0 space-y-3 md:space-y-0">
            <a href="{{ route('provider.edit-profile') }}" 
               class="bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-2.5 rounded-lg backdrop-blur-sm transition">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
            <a href="{{ route('provider.messages.index') }}" 
               class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                <i class="bi bi-chat-dots me-1"></i> Chat
            </a>
        </div>
    </div>

    <!-- 📄 Info Sections -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- 🏠 Personal Info -->
        <div class="bg-white/95 rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center">
                <i class="bi bi-person-lines-fill text-blue-600 me-2"></i> Personal Details
            </h2>
            <div class="space-y-3 text-gray-700">
                <p><strong>Name:</strong> {{ $profile->name }}</p>
                <p><strong>Address:</strong> {{ $profile->address ?: 'Not provided' }}</p>
                <p><strong>Phone:</strong> {{ $profile->phone ?: 'Not provided' }}</p>
                <p><strong>Email:</strong> {{ $profile->gmail ?: 'Not provided' }}</p>
            </div>
        </div>

        <!-- 💬 About Section -->
        <div class="bg-white/95 rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center">
                <i class="bi bi-info-circle text-blue-600 me-2"></i> About Me
            </h2>
            <p class="text-gray-700 leading-relaxed">
                {{ $profile->about ?: 'This provider has not added an about section yet.' }}
            </p>
        </div>
    </div>

    <!-- 📋 Review Summary -->
    <div class="bg-white/95 rounded-2xl shadow-lg p-6 border border-gray-100 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center">
            <i class="bi bi-star-half text-yellow-500 me-2"></i> Customer Reviews
        </h2>
        <p class="text-gray-700">This provider currently has a {{ $profile->review ?? 0 }}/5 rating based on customer feedback.</p>
    </div>
</div>
@endsection
