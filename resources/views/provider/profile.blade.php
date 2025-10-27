@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Provider Profile</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('provider.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Profile Image</label><br>
            <img src="{{ asset($provider->profile_photo ?? 'default-avatar.png') }}"
                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
            <input type="file" name="profile_photo" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $provider->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email (Read-only)</label>
            <input type="email" class="form-control" value="{{ $provider->email }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $provider->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control"
                   value="{{ old('address', $provider->address) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
