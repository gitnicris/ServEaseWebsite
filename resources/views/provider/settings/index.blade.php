@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">

    {{-- ✅ Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Account Settings</h1>
        <p class="text-gray-500 mt-1">Manage your personal account preferences.</p>
    </div>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif


    {{-- =============================
         ✅ Update Basic Info
    ============================== --}}
    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-medium text-gray-800 mb-4">Account Information</h2>

        <form action="{{ route('provider.settings.updateAccount') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full p-3 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                @error('name')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full p-3 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                @error('email')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Save Changes
            </button>
        </form>
    </div>


{{-- 🔐 Change Password --}}
<div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-medium text-gray-800">Change Password</h2>

        
    </div>

    <form action="{{ route('provider.settings.updatePassword') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Current --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Current Password</label>
            <input type="password" name="current_password"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
            @error('current_password')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- New --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">New Password</label>
            <input type="password" name="password"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
            @error('password')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Update Password
        </button>
    </form>
</div>




    {{-- =============================
        ❌ Delete Account
    ============================== --}}
    <div class="bg-white shadow-sm rounded-lg p-6 border border-red-200">
        <h2 class="text-xl font-medium text-red-700 mb-4">Delete Account</h2>

        <p class="text-red-600 mb-4">
            This action is permanent. Once deleted, your account cannot be recovered.
        </p>

        <form action="{{ route('provider.settings.destroyAccount') }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete your account?');"
              class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <label class="block text-red-700 font-medium mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full p-3 bg-red-50 border border-red-300 rounded focus:outline-none focus:ring focus:ring-red-200">
                @error('password')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                Delete Account
            </button>
        </form>
    </div>

</div>
@endsection
