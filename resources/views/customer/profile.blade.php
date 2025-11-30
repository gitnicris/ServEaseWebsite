@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6">

    {{-- 👤 Profile Header --}}
    <div class="flex flex-col items-center mb-6 bg-white rounded-2xl shadow-sm p-6 sm:p-8">
        {{-- Profile Photo (clickable) --}}
        <button id="profilePhotoBtn" class="focus:outline-none">
            @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
                <img src="{{ asset('storage/' . $profile->photo) }}" 
                     alt="Profile Photo" 
                     class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-2 border-primary shadow-sm hover:ring-2 hover:ring-accent transition">
            @else
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-primary flex items-center justify-center text-white text-4xl sm:text-5xl font-bold shadow-sm hover:ring-2 hover:ring-accent transition">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </button>

        <h2 class="mt-4 text-2xl sm:text-3xl font-semibold text-primary">{{ $user->name }}</h2>
        <p class="text-gray-500 text-sm sm:text-base capitalize">{{ $user->role }}</p>
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
            <div class="{{ isset($field['colspan']) && $field['colspan'] ? 'md:col-span-2' : '' }} bg-white rounded-2xl shadow-sm p-4 sm:p-6 flex items-start gap-3">
                <i class="bi bi-{{ $field['icon'] }} text-lg text-accent mt-1"></i>
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">{{ $field['label'] }}</h3>
                    <p class="text-primary text-lg break-words">{{ $field['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ✏️ Edit Button --}}
    <div class="mt-6 md:mt-8 text-center">
        <a href="{{ route('customer.profile.edit') }}" 
           class="inline-flex items-center justify-center px-6 py-2 bg-accent hover:bg-blue-600 text-white font-semibold rounded-lg shadow-sm transition duration-150 text-sm sm:text-base">
            <i class="bi bi-pencil-square me-2"></i> Edit Profile
        </a>
    </div>
</div>

{{-- 🔳 Modal for Viewing Profile Photo --}}
<div id="photoModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="relative max-w-md w-full p-4">
        <button id="closeModal" class="absolute top-2 right-2 text-white text-2xl font-bold hover:text-gray-300">&times;</button>
        @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
            <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="rounded-lg shadow-lg w-full h-auto">
        @else
            <div class="w-full h-64 rounded-lg bg-primary flex items-center justify-center text-white text-6xl font-bold shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>
</div>

{{-- 🔹 JavaScript --}}
<script>
    const modal = document.getElementById('photoModal');
    const btn = document.getElementById('profilePhotoBtn');
    const closeBtn = document.getElementById('closeModal');

    btn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Close modal on click outside the image
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
</script>
@endsection
