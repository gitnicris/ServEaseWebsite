@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="mb-3">
        <h1 class="text-2xl font-semibold text-gray-800">Account Settings</h1>
        <p class="text-gray-500 text-sm">Manage your personal account preferences.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-3 py-2 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-3 py-2 rounded text-sm">
            {{ session('error') }}
        </div>
    @endif


    {{-- Account Information --}}
    <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
        <h2 class="text-lg font-medium text-gray-800 mb-3">Account Information</h2>

        <form action="{{ route('provider.settings.updateAccount') }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full p-2 bg-gray-100 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full p-2 bg-gray-100 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <button class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700">
                Save Changes
            </button>
        </form>
    </div>



    {{-- Change Password --}}
    <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
        <h2 class="text-lg font-medium text-gray-800 mb-3">Change Password</h2>

        <form action="{{ route('provider.settings.updatePassword') }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            {{-- Current --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Current Password</label>
                <input type="password" name="current_password"
                    class="w-full p-2 bg-gray-100 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            {{-- New --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">New Password</label>
                <input type="password" name="password"
                    class="w-full p-2 bg-gray-100 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            {{-- Confirm --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1 text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full p-2 bg-gray-100 border border-gray-300 rounded focus:ring focus:ring-blue-200">
            </div>

            <button class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700">
                Update Password
            </button>
        </form>
    </div>



    {{-- Delete Account --}}
    <div class="bg-white shadow-sm rounded-lg p-4 border border-red-200">
        <h2 class="text-lg font-medium text-red-700 mb-3">Delete Account</h2>

        <p class="text-red-600 text-sm mb-3">
            This action is permanent and cannot be undone.
        </p>

        <form action="{{ route('provider.settings.destroyAccount') }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete your account?');"
              class="space-y-3">
            @csrf
            @method('DELETE')

            <div>
                <label class="block text-red-700 font-medium mb-1 text-sm">Password</label>
                <input type="password" name="password"
                       class="w-full p-2 bg-red-50 border border-red-300 rounded focus:ring focus:ring-red-200">
            </div>

            <button class="bg-red-600 text-white px-3 py-1.5 rounded text-sm hover:bg-red-700">
                Delete Account
            </button>
        </form>
    </div>

</div>
@endsection
