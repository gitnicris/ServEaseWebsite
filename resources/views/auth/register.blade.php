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
            background: #f3f4f6; /* same bg as login & dashboard */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- Brand / Title (same style as login) -->
        <div class="text-center mb-8">
            <h1 class="text-sm font-semibold text-gray-500 tracking-[0.2em] uppercase">
                Servease
            </h1>
            <h2 class="text-2xl font-semibold text-gray-900 mt-5">
                Create your account
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Join ServEase and start booking or offering services.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-gray-700 text-sm mb-1">Full Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Juan Dela Cruz"
                >
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 text-sm mb-1">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="you@example.com"
                >
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 text-sm mb-1">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 text-sm mb-1">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••"
                >
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-gray-700 text-sm mb-1">Register As</label>
                <select
                    id="role"
                    name="role"
                    required
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Select your role</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>Service Provider</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium shadow-sm transition"
            >
                Register
            </button>
        </form>

        <!-- Already have account -->
        <p class="text-center text-gray-500 text-sm mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                Log in
            </a>
        </p>

    </div>

</body>
</html>
