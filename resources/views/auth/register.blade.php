<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ServEase</title>

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

        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase" class="w-16 mx-auto mb-3 opacity-90" onerror="this.style.display='none'">
            <h2 class="text-white text-2xl font-semibold tracking-tight">Create Your Account</h2>
            <p class="text-gray-400 text-sm mt-1">Join ServEase today</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                @error('name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-orange-400 focus:outline-none">
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <!-- Role -->
            <div>
                <label class="block text-gray-300 text-sm mb-1">Register As</label>
                <select name="role" required
                        class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-orange-400 focus:outline-none">
                    <option value="">Select your role</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>Service Provider</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg font-medium transition">
                Register
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-gray-400 text-sm mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-medium">Log in</a>
        </p>

    </div>

</body>
</html>