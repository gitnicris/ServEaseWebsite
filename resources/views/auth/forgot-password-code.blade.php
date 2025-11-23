<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ServEase</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f0f16;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen px-4 bg-gradient-to-br from-[#141426] to-[#0b0b12]">

    <!-- Card -->
    <div class="w-full max-w-lg bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-8 shadow-xl">

        <div class="text-center mb-6">
            <h2 class="text-white text-2xl font-semibold tracking-tight">Forgot Password</h2>
            <p class="text-gray-400 text-sm mt-1">Enter your email to receive a verification code</p>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-500/20 text-green-300 rounded-md text-center">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-500/20 text-red-300 rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.code.send') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-300 text-sm mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-400 focus:outline-none">

                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg font-medium transition">
                Send Verification Code
            </button>
        </form>

        <p class="text-center text-gray-400 text-sm mt-6">
            <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-medium">
                ← Back to Login
            </a>
        </p>

    </div>

</body>
</html>
