<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | ServEase</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f4f6; /* same as login */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-sm font-semibold text-gray-500 tracking-[0.2em] uppercase">
                Servease
            </h1>

            <h2 class="text-2xl font-semibold text-gray-900 mt-5">Reset Password</h2>
            <p class="text-sm text-gray-500 mt-1">Enter your new password below.</p>
        </div>

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('password.reset') }}" method="POST" class="space-y-6">
            @csrf

            <!-- NEW PASSWORD -->
            <div>
                <label class="block text-gray-700 text-sm mb-2">New Password</label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Enter new password"
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-gray-700 text-sm mb-2">Confirm Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Confirm new password"
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium shadow-sm transition"
            >
                Update Password
            </button>
        </form>

        <!-- Back to Login -->
        <p class="text-center text-gray-500 text-sm mt-6">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                ← Back to Login
            </a>
        </p>

    </div>

</body>
</html>
