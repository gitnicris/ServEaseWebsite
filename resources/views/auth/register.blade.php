<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ServEase</title>
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

        input, select {
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
        <h1 class="text-3xl font-bold text-center text-orange-400 mb-6">Create Your Account</h1>
        <p class="text-center text-gray-200 mb-8">Join ServEase to connect with others easily</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-semibold mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                @error('name')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
            </div>

            <!-- User Role -->
            <div>
                <label for="role" class="block text-sm font-semibold mb-1">Register As</label>
                <select id="role" name="role" required
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    <option value="">Select your role</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>Service Provider</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="text-center pt-3">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-md font-semibold transition">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-gray-200 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">Log in here</a>
        </div>
    </div>
</body>
</html>
