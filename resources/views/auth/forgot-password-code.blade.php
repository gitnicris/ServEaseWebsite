<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ServEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col md:flex-row bg-gradient-to-br from-indigo-500 to-orange-400 font-[Poppins]">
    <!-- Left Panel -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center text-center text-white p-10 backdrop-blur-sm bg-white/10">
        <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo" class="w-28 mb-4">
        <h1 class="text-3xl font-bold mb-2">Forgot Your Password?</h1>
        <p class="max-w-md text-gray-200">Enter your email below and we’ll send you a 6-digit verification code to reset your password securely.</p>
    </div>

    <!-- Right Panel -->
    <div class="w-full md:w-1/2 flex justify-center items-center bg-[#1a1a2e]">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-11/12 max-w-md">
            <h2 class="text-2xl font-bold text-center text-orange-400 mb-6">Request Verification Code</h2>

            <form action="{{ route('password.code.send') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-white font-semibold mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full p-3 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @error('email')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold w-full py-2.5 rounded-md transition">
                    Send Verification Code
                </button>
            </form>

            <p class="text-gray-300 text-center text-sm mt-6">
                Remember your password?
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">Back to Login</a>
            </p>
        </div>
    </div>
</body>
</html>
