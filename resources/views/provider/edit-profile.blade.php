@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">

    <!-- Tabs -->
    <div class="mb-6">
        <ul class="flex border-b border-gray-200 text-sm" id="tabs">
            <li class="mr-6">
                <button data-tab="personal" class="tab-button font-medium text-gray-600 border-b-2 border-transparent pb-2 hover:text-blue-600 hover:border-blue-600 transition active">
                    Personal Info
                </button>
            </li>
            <li>
                <button data-tab="about" class="tab-button font-medium text-gray-600 border-b-2 border-transparent pb-2 hover:text-blue-600 hover:border-blue-600 transition">
                    About & Avatar
                </button>
            </li>
        </ul>
    </div>

    <form action="{{ route('provider.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf
        @method('PUT')

        <!-- PERSONAL INFO TAB -->
        <div class="tab-content animate-slide-in" id="personal">
            <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="gmail" value="{{ old('gmail', $profile->gmail ?? $user->email) }}"
                           class="w-full border {{ $errors->has('gmail') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('gmail')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $profile->address) }}"
                           class="w-full border {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                           class="w-full border {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Bio</label>
                    <textarea name="bio" rows="2"
                              class="w-full border {{ $errors->has('bio') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ABOUT & AVATAR TAB -->
        <div class="tab-content hidden animate-slide-in" id="about">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 mb-4">
                <div class="relative">
                    <img src="{{ $profile->photo ? asset('storage/' . $profile->photo) : asset('images/default-avatar.png') }}"
                         alt="Profile Photo"
                         class="w-28 h-28 md:w-32 md:h-32 rounded-full border shadow-sm object-cover">
                    <label for="photo" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-1 cursor-pointer hover:bg-blue-700 transition">
                        <i class="bi bi-pencil"></i>
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                    @error('photo')
                        <p class="text-red-500 text-xs mt-1 text-center"> {{ $message }} </p>
                    @enderror
                </div>
                <div class="flex-1 text-center md:text-left">
                    <label class="block text-gray-700 font-medium mb-1">About</label>
                    <textarea name="about" rows="5"
                              class="w-full border {{ $errors->has('about') ? 'border-red-500' : 'border-gray-300' }} rounded-xl p-2 md:p-3 focus:ring-blue-500 focus:border-blue-500">{{ old('about', $profile->about) }}</textarea>
                    @error('about')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row justify-end gap-3 mt-2 md:mt-4">
            <a href="{{ route('provider.profile') }}"
               class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm text-center transition">
               Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 text-sm transition">
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- Tab Script -->
<script>
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.add('hidden'));

            button.classList.add('active');
            const tab = document.getElementById(button.dataset.tab);
            tab.classList.remove('hidden');
            tab.classList.add('animate-slide-in');
        });
    });
</script>

<!-- Tailwind Animation -->
<style>
    @keyframes slide-in {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
</style>
@endsection
