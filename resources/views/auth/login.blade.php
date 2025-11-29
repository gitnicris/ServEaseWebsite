@extends('layouts.app')

@section('title', 'Login | ServEase')

@section('content')
{{-- Fullscreen overlay --}}
<div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">

    {{-- Login Card --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 p-8 relative z-50">

        {{-- Brand / Title --}}
        <div class="text-center mb-8">
            <h1 class="text-sm font-semibold text-gray-500 tracking-[0.2em] uppercase">Servease</h1>
            <h2 class="text-2xl font-semibold text-gray-900 mt-5">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to continue to your dashboard.</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="you@example.com">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700 text-sm mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Options --}}
            <div class="flex items-center justify-between text-xs sm:text-sm text-gray-500">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                        Forgot password?
                    </a>
                @endif
            </div>

            {{-- Login Button --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                Login
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center my-6 text-xs text-gray-400">
            <span class="border-b border-gray-200 flex-1"></span>
            <span class="px-2">or</span>
            <span class="border-b border-gray-200 flex-1"></span>
        </div>

        {{-- Google Login --}}
        <a href="{{ route('auth.google') }}"
            class="flex items-center justify-center w-full bg-white border border-gray-200 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 mr-2" alt="Google">
            Sign in with Google
        </a>

        {{-- Register Link --}}
        <p class="text-center text-gray-500 text-sm mt-6">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                Create one
            </a>
        </p>

    </div>
</div>
@endsection
