<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | ServEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col md:flex-row bg-gradient-to-br from-indigo-500 to-orange-400 font-[Poppins]">
    <!-- Left Panel -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center text-center text-white p-10 backdrop-blur-sm bg-white/10">
        <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo" class="w-28 mb-4">
        <h1 class="text-3xl font-bold mb-2">Set a New Password</h1>
        <p class="max-w-md text-gray-200">Create a strong new password to regain access to your ServEase account.</p>
    </div>

    <!-- Right Panel -->
    <div class="w-full md:w-1/2 flex justify-center items-center bg-[#1a1a2e]">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-11/12 max-w-md">
            <h2 class="text-2xl font-bold text-center text-orange-400 mb-6">Reset Your Password</h2>

            <form action="{{ route('password.reset.code') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="password" class="block text-white font-semibold mb-1">New Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full p-3 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-white font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full p-3 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold w-full py-2.5 rounded-md transition">
                    Reset Password
                </button>
            </form>

            <p class="text-gray-300 text-center text-sm mt-6">
                Back to
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
