<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ServEase</title>
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
        .left-panel {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,0.05);
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
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
        a { color: var(--orange); transition: color 0.3s; }
        a:hover { color: #ec6c10ff; }
        input { color: black; }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel, .right-panel { width: 100%; height: 50vh; }
        }
    </style>
</head>
<body>
    <div class="left-panel animate__animated animate__fadeInLeft">
        <img src="{{ asset('images/servease-logo.png') }}" alt="ServEase Logo">
        <h1>Forgot Password</h1>
        <p>Enter your email and we’ll send you a verification code to reset your password.</p>
    </div>

    <div class="right-panel animate__animated animate__fadeInRight">
        <div class="card">
            <h2 class="text-2xl font-bold text-center text-orange-400 mb-6">Reset Password</h2>

            <form method="POST" action="{{ route('password.code.send') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-white font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" required placeholder="Enter your email"
                           class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800">
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-md font-semibold transition w-full">
                        Send Verification Code
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-gray-300 text-sm">
                <a href="{{ route('login') }}" class="text-orange-400 hover:underline font-semibold">← Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
