@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">

    {{-- 👤 Profile Header --}}
    <div class="flex flex-col items-center mb-8 bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-6 sm:p-8 backdrop-blur-md animate__animated animate__fadeIn">
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

        <h2 class="mt-4 text-2xl sm:text-3xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Customer</p>
    </div>

    {{-- 🧾 Profile Information --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        @php
            $infoFields = [
                ['label' => 'Full Name', 'value' => $user->name, 'icon' => 'person'],
                ['label' => 'Email', 'value' => $user->email, 'icon' => 'envelope'],
                ['label' => 'Phone', 'value' => $profile->phone ?? 'Not provided', 'icon' => 'telephone'],
                ['label' => 'Address', 'value' => $profile->address ?? 'Not provided', 'icon' => 'geo-alt'],
                ['label' => 'Bio', 'value' => $profile->bio ?? 'No bio available.', 'icon' => 'card-text', 'colspan' => true],
            ];
        @endphp

        @foreach ($infoFields as $field)
            <div class="{{ isset($field['colspan']) && $field['colspan'] ? 'md:col-span-2' : '' }} bg-white/80 dark:bg-gray-800/70 rounded-xl shadow-sm p-4 sm:p-6 flex items-start gap-3">
                <i class="bi bi-{{ $field['icon'] }} text-lg sm:text-xl text-green-500 mt-1"></i>
                <div>
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold uppercase mb-1">{{ $field['label'] }}</h3>
                    <p class="text-gray-900 dark:text-white text-lg break-words">{{ $field['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ✏️ Edit Button --}}
    <div class="mt-6 md:mt-8 text-center">
        <a href="{{ route('customer.profile.edit') }}" 
           class="inline-flex items-center justify-center px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-150 text-sm sm:text-base">
            <i class="bi bi-pencil-square me-2"></i> Edit Profile
        </a>
    </div>
</div>
@endsection
