@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 450px;">
    <h2 class="mb-3">Reset Password</h2>
    <p class="text-muted">Enter your new password below.</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('password.reset') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success w-100">Update Password</button>
    </form>
</div>
@endsection
