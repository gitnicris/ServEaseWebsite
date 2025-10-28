@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-8 backdrop-blur-md animate__animated animate__fadeIn">

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-300 border border-green-300/40">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- 👤 Profile Header --}}
    <div class="flex flex-col items-center mb-10 text-center relative">
        {{-- Profile Photo (clickable) --}}
        @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
            <a href="{{ asset('storage/' . $profile->photo) }}" target="_blank" class="group relative">
                <img src="{{ asset('storage/' . $profile->photo) }}" 
                     alt="Profile Photo" 
                     class="w-28 h-28 rounded-full object-cover border-4 border-orange-500 shadow-lg transition-transform group-hover:scale-105">
                <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                    <i class="bi bi-eye-fill text-white text-xl"></i>
                </div>
            </a>
        @else
            <div class="w-28 h-28 rounded-full bg-orange-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <h2 class="mt-4 text-3xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400">Service Provider</p>
    </div>

    {{-- 📝 Profile Update Form --}}
    <form action="{{ route('provider.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Full Name --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-150">
        </div>

        {{-- Bio --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bio</label>
            <textarea name="bio" 
                      rows="3"
                      class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-150">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
            <input type="text" 
                   name="phone" 
                   value="{{ old('phone', $profile->phone) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-150">
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
            <input type="text" 
                   name="address" 
                   value="{{ old('address', $profile->address) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-150">
        </div>

        {{-- Profile Photo --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Change Profile Photo</label>
            <input type="file" 
                   name="photo" 
                   class="block w-full text-sm text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg p-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 transition duration-150">
        </div>

        {{-- Submit Button --}}
        <div class="text-center pt-4">
            <button type="submit" 
                    class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
                <i class="bi bi-save2 me-1"></i> Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
