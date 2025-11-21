<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | ServEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen bg-gradient-to-r from-[#6C63FF] to-[#ff7b00]">
    <div class="w-1/2 flex flex-col justify-center items-center text-white bg-opacity-10 backdrop-blur-lg p-8">
        <img src="{{ asset('images/servease-logo.png') }}" class="w-28 mb-5">
        <h1 class="text-4xl font-bold mb-4">Reset Password</h1>
        <p>Set a new password for your ServEase account to regain access securely.</p>
    </div>

    <div class="w-1/2 flex justify-center items-center bg-[#1a1a2e]">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 w-96">

            <h2 class="text-center text-2xl font-bold text-orange-400 mb-6">Create New Password</h2>

            {{-- SHOW ERRORS --}}
            @if(session('error'))
                <p class="text-red-500 text-center mb-3">{{ session('error') }}</p>
            @endif
            @if(session('status'))
                <p class="text-green-400 text-center mb-3">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('password.reset.code') }}">
                @csrf

                <!-- FIX: use verified_email session key -->
                <input type="hidden" name="email" value="{{ session('verified_email') }}">

                <div class="mb-4">
                    <label class="text-white font-semibold mb-1 block">New Password</label>
                    <input type="password" name="password" required
                        class="w-full p-3 rounded-md text-gray-800 focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="mb-4">
                    <label class="text-white font-semibold mb-1 block">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full p-3 rounded-md text-gray-800 focus:ring-2 focus:ring-orange-400">
                </div>

                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white w-full py-2.5 rounded-md font-semibold transition">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-gray-300 text-sm">
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">← Back to Login</a>
            </div>

        </div>
    </div>
</body>
</html>
