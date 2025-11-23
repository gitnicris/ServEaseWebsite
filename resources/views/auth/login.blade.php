<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ServEase</title>

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

    
    <div class="w-full max-w-md bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-8 shadow-xl">

        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase" class="w-16 mx-auto mb-3 opacity-90" onerror="this.style.display='none'">
            <h2 class="text-white text-2xl font-semibold tracking-tight">Welcome Back</h2>
            <p class="text-gray-400 text-sm mt-1">Login to continue</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options -->
            <div class="flex items-center justify-between text-sm text-gray-400">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="accent-orange-500">
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-orange-400 hover:text-orange-300">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg font-medium transition">
                Login
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6 text-gray-500 text-sm">
            <span class="border-b border-white/10 flex-1"></span>
            <span class="px-2">or</span>
            <span class="border-b border-white/10 flex-1"></span>
        </div>

        <!-- Google Login -->
        <a href="{{ route('auth.google') }}"
           class="flex items-center justify-center w-full bg-white text-gray-700 font-medium py-2.5 rounded-lg hover:bg-gray-100 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 mr-2">
            Sign in with Google
        </a>

        <!-- Register -->
        <p class="text-center text-gray-400 text-sm mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 font-medium">Create one</a>
        </p>

    </div>

</body>
</html>