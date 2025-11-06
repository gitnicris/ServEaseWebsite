<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code | ServEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gradient-to-r from-[#6C63FF] to-[#ff7b00]">
    <div class="w-1/2 flex flex-col justify-center items-center text-white bg-opacity-10 backdrop-blur-lg p-8">
        <img src="{{ asset('images/servease-logo.png') }}" class="w-28 mb-5">
        <h1 class="text-4xl font-bold mb-4">Verify Code</h1>
        <p>Enter the verification code sent to your email to proceed resetting your password.</p>
    </div>

    <div class="w-1/2 flex justify-center items-center bg-[#1a1a2e]">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 w-96">
            <h2 class="text-center text-2xl font-bold text-orange-400 mb-6">Enter Verification Code</h2>

            <form method="POST" action="{{ route('password.code.verify') }}">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', session('email')) }}">
                <input type="text" name="verification_code" maxlength="6" required placeholder="Enter code"
                    class="w-full p-3 rounded-md text-gray-800 focus:ring-2 focus:ring-orange-400 mb-4">

                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white w-full py-2.5 rounded-md font-semibold transition">
                    Verify Code
                </button>
            </form>

            <div class="text-center text-sm text-gray-300 mt-4">
                Didn’t receive a code? <br>
                <a href="{{ route('password.code.request') }}" class="text-orange-400 hover:underline">Resend Code</a>
            </div>

            <div class="mt-6 text-center text-gray-300 text-sm">
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">← Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
