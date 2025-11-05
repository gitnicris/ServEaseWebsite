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
            --violet: #6C63FF;
            --orange: #ff7b00;
            --dark-bg: #1a1a2e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--violet), var(--orange));
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        /* Left panel */
        .left-panel {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            text-align: center;
            padding: 2rem;
        }

        .left-panel img {
            width: 130px;
            height: auto;
            margin-bottom: 1rem;
        }

        .left-panel h1 {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .left-panel p {
            color: #e8e8e8;
            max-width: 400px;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Right panel */
        .right-panel {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--dark-bg);
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            width: 90%;
            max-width: 420px;
            padding: 2.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Responsive Design */
        @media (max-width: 1024px) {
            .left-panel h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100%;
                height: 50vh;
            }

            .left-panel {
                justify-content: center;
                padding: 3rem 1rem;
            }

            .right-panel {
                padding: 2rem 1rem;
            }

            .card {
                max-width: 95%;
            }
        }
    </style>
</head>

<body>
    <!-- Left Panel -->
    <div class="left-panel animate__animated animate__fadeInLeft">
        <!-- Replace with your logo if available -->
        <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo" onerror="this.style.display='none'">
        <h1>ServEase</h1>
        <p>Join ServEase today and discover a smarter way to connect with trusted service providers and customers in one place.</p>
    </div>

    <!-- Right Panel -->
    <div class="right-panel animate__animated animate__fadeInRight">
        <div class="card">
            <h2 class="text-2xl font-bold text-center text-orange-400 mb-6">Create Your Account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-white font-semibold mb-1">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    @error('name')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-white font-semibold mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    @error('email')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-white font-semibold mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    @error('password')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-white font-semibold mb-1">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-white font-semibold mb-1">Register As</label>
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

            <div class="mt-6 text-center text-gray-300 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">Log in here</a>
            </div>
        </div>
    </div>
</body>
</html>
