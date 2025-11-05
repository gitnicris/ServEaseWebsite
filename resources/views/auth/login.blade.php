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

        /* Left Panel */
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

        /* Right Panel */
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

        /* Google Button */
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: #444;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.7rem;
            width: 100%;
            transition: background 0.3s;
        }

        .google-btn:hover {
            background: #f3f3f3;
        }

        .google-btn img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        /* Responsive Design */
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
        <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo" onerror="this.style.display='none'">
        <h1>Welcome Back</h1>
        <p>Log in to ServEase and manage your services, bookings, and connections effortlessly.</p>
    </div>

    <!-- Right Panel -->
    <div class="right-panel animate__animated animate__fadeInRight">
        <div class="card">
            <h2 class="text-2xl font-bold text-center text-orange-400 mb-6">Login to Your Account</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-white font-semibold mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    @error('email')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-white font-semibold mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                    @error('password')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm text-gray-300">
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

                <!-- Login Button -->
                <div class="text-center pt-3">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-md font-semibold transition w-full">
                        Login
                    </button>
                </div>
            </form>

        
            <div class="my-6 flex items-center justify-center text-gray-400 text-sm">
                <span class="w-1/4 border-b border-gray-600"></span>
                <span class="mx-2">or</span>
                <span class="w-1/4 border-b border-gray-600"></span>
            </div>

            <div class="text-center">
                <a href="{{ route('auth.google') }}" class="google-btn">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo">
                    Sign in with Google
                </a>
            </div>

            <div class="mt-6 text-center text-gray-300 text-sm">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-orange-400 hover:underline font-semibold">Create one</a>
            </div>
        </div>
    </div>
</body>
</html>
