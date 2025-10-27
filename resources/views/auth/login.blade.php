<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ServEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --violet: #8e44ad;
            --orange: #f39c12;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--violet), var(--orange));
            color: white;
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        }

        input {
            color: black;
        }

        a {
            color: var(--orange);
            transition: color 0.3s;
        }

        a:hover {
            color: white;
        }
    </style>
</head>

<body class="flex items-center justify-center animate__animated animate__fadeIn">
    <div class="max-w-md w-full mx-auto p-8 rounded-2xl card">
        <h1 class="text-3xl font-bold text-center text-orange-400 mb-6">Welcome Back</h1>
        <p class="text-center text-gray-200 mb-8">Login to your ServEase account</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-sm text-gray-200">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 accent-orange-500">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-orange-400 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <div class="text-center pt-3">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-md font-semibold transition">
                    Login
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-gray-200 text-sm">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-orange-400 hover:underline font-semibold">Create one</a>
        </div>
    </div>
</body>
</html>
