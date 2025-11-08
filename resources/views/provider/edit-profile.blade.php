@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white/95 rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="bi bi-pencil-square text-blue-600 me-3"></i> Edit Profile
    </h1>

    <form action="{{ route('provider.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                   class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Bio -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Bio</label>
            <textarea name="bio" rows="3" 
                      class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        <!-- Address / Phone -->
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address', $profile->address) }}" 
                       class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" 
                       class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Gmail -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Gmail</label>
            <input type="email" name="gmail" value="{{ old('gmail', $profile->gmail ?? $user->email) }}" 
                   class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- About -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">About</label>
            <textarea name="about" rows="4" 
                      class="w-full border-gray-300 rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">{{ old('about', $profile->about) }}</textarea>
        </div>

        <!-- Photo Upload -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Profile Photo</label>
            <div class="flex items-center space-x-4">
                <img src="{{ $profile->photo ? asset('storage/' . $profile->photo) : asset('images/default-avatar.png') }}" 
                     alt="Profile Photo" class="w-20 h-20 rounded-full border shadow-sm object-cover">
                <input type="file" name="photo" accept="image/*" 
                       class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition">
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('provider.profile') }}" 
               class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 transition">
               Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
