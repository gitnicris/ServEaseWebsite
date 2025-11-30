@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-300 border border-green-300/40 flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- 👤 Profile Header --}}
    <div class="flex flex-col items-center mb-10 text-center bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-6 sm:p-8 backdrop-blur-md">
        
        <form id="photoForm" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Photo (clickable) --}}
            <label for="photoInput" class="cursor-pointer relative">
                @if (!empty($profile->photo) && Storage::disk('public')->exists($profile->photo))
                    <img src="{{ asset('storage/' . $profile->photo) }}" 
                         alt="Profile Photo" 
                         class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-4 border-green-500 shadow-lg mb-3 hover:ring-2 hover:ring-green-400 transition">
                @else
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-green-500 flex items-center justify-center text-white text-4xl sm:text-5xl font-bold shadow-lg mb-3 hover:ring-2 hover:ring-green-400 transition">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="document.getElementById('photoForm').submit();">
                <div class="absolute bottom-0 right-0 bg-green-500 text-white rounded-full p-1 sm:p-2 shadow-lg">
                    <i class="bi bi-pencil-fill text-sm sm:text-base"></i>
                </div>
            </label>
        </form>

        <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400">Customer</p>
    </div>

    {{-- 📝 Edit Profile Form --}}
    <div class="bg-white/90 dark:bg-gray-800/80 rounded-2xl shadow-xl p-8 backdrop-blur-md">
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Full Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-200 hover:shadow-sm">
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                <textarea name="bio" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-200 hover:shadow-sm">{{ old('bio', $profile->bio) }}</textarea>
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-200 hover:shadow-sm">
            </div>

            {{-- Address --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address', $profile->address) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-400 focus:border-green-400 transition duration-200 hover:shadow-sm">
            </div>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row justify-between items-center pt-4 gap-3 sm:gap-0">
                <a href="{{ route('customer.profile') }}" class="w-full sm:w-auto px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 text-center">
                    <i class="bi bi-arrow-left me-2"></i> Cancel
                </a>

                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
                    <i class="bi bi-save2 me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
