<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ServEase</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --violet: #6C63FF;
            --orange: #ff7b00;
            --dark-bg: #1a1a2e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--violet), var(--orange));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            border-radius: 18px;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            color: white;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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
<body>
    <div class="card">
        <div class="text-center mb-6">
            <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo" class="mx-auto mb-3 w-16" onerror="this.style.display='none'">
            <h2 class="text-2xl font-bold text-orange-400">Forgot Password?</h2>
            <p class="text-sm text-gray-200 mt-2">
                Enter your registered email address and we’ll send a link to reset your password.
            </p>
        </div>

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-white font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if (session('status'))
                <div class="text-green-400 text-sm text-center bg-green-900/30 p-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="text-center pt-3">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-md font-semibold transition">
                    Send Reset Link
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">← Back to Login</a>
        </div>
    </div>
</body>
</html>
