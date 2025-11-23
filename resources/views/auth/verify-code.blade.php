@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 450px;">
    <h2 class="mb-3">Verify Code</h2>
    <p class="text-muted">A 6-digit code was sent to your email.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('password.code.verify') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Enter 6-Digit Code</label>
            <input type="text" name="code" maxlength="6" class="form-control" required>
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary w-100">Verify Code</button>
    </form>
</div>
@endsection
