@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-8 backdrop-blur-md animate__animated animate__fadeIn">

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-300 border border-green-300/40">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- 👤 Header --}}
    <div class="flex flex-col items-center mb-10 text-center">
        {{-- Profile Photo --}}
        @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
            <img src="{{ asset('storage/' . $profile->photo) }}" 
                 alt="Profile Photo" 
                 class="w-28 h-28 rounded-full object-cover border-4 border-green-500 shadow-lg mb-3">
        @else
            <div class="w-28 h-28 rounded-full bg-green-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg mb-3">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400">Customer</p>
    </div>

    {{-- 📝 Edit Profile Form --}}
    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Full Name --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-150">
        </div>

        {{-- Bio --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bio</label>
            <textarea name="bio" rows="3"
                      class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-150">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
            <input type="text" 
                   name="phone" 
                   value="{{ old('phone', $profile->phone) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-150">
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
            <input type="text" 
                   name="address" 
                   value="{{ old('address', $profile->address) }}"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-150">
        </div>

        {{-- Profile Photo --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Profile Photo</label>
            <input type="file" 
                   name="photo" 
                   class="block w-full text-sm text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg p-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-500 file:text-white hover:file:bg-green-600 transition duration-150">
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('customer.profile') }}" 
               class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
                <i class="bi bi-save2 me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
