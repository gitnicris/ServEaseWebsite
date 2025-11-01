@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-8 text-center backdrop-blur-md animate__animated animate__fadeIn">

    {{-- 👤 Profile Header --}}
    <div class="flex flex-col items-center mb-8">
        {{-- Profile Photo --}}
        @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
            <img src="{{ asset('storage/' . $profile->photo) }}" 
                 alt="Profile Photo" 
                 class="w-28 h-28 rounded-full object-cover border-4 border-green-500 shadow-lg">
        @else
            <div class="w-28 h-28 rounded-full bg-green-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <h2 class="mt-4 text-3xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400">Customer</p>
    </div>

    {{-- 🧾 Profile Information --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
        <div>
            <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase">Full Name</h3>
            <p class="text-lg text-gray-900 dark:text-white">{{ $user->name }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase">Email</h3>
            <p class="text-lg text-gray-900 dark:text-white">{{ $user->email }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase">Phone</h3>
            <p class="text-lg text-gray-900 dark:text-white">{{ $profile->phone ?? 'Not provided' }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase">Address</h3>
            <p class="text-lg text-gray-900 dark:text-white">{{ $profile->address ?? 'Not provided' }}</p>
        </div>

        <div class="md:col-span-2">
            <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase">Bio</h3>
            <p class="text-lg text-gray-900 dark:text-white">{{ $profile->bio ?? 'No bio available.' }}</p>
        </div>
    </div>

    {{-- ✏️ Edit Button --}}
    <div class="mt-10">
        <a href="{{ route('customer.profile.edit') }}" 
           class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
            <i class="bi bi-pencil-square me-1"></i> Edit Profile
        </a>
    </div>
</div>
@endsection
