@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
    
    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Avatar --}}
    <div class="flex flex-col items-center mb-8">
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" 
                 alt="Profile Photo" 
                 class="w-28 h-28 rounded-full object-cover border-4 border-emerald-500 shadow-lg">
        @else
            <div class="w-28 h-28 rounded-full bg-emerald-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
        <h2 class="mt-4 text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Service Provider</p>
    </div>

    {{-- Profile Form --}}
    <form action="{{ route('provider.updateProfile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
    </div>

    <div class="form-group">
        <label>Bio</label>
        <textarea name="bio" class="form-control">{{ old('bio', $profile->bio) }}</textarea>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="form-control">
    </div>

    <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" value="{{ old('address', $profile->address) }}" class="form-control">
    </div>

    <div class="form-group">
        <label>Photo</label><br>
        <input type="file" name="photo">
        @if ($profile->photo)
            <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" width="120" class="mt-2 rounded">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="Default Avatar" width="120" class="mt-2 rounded">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>

</div>
@endsection
