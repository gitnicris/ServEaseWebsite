<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ServEase</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Styles -->
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
            transition: background 0.6s ease-in-out;
        }

        nav {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        nav a {
            position: relative;
            padding-bottom: 4px;
            transition: color 0.3s ease;
        }

        nav a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background: var(--orange);
            transition: width 0.3s ease;
        }

        nav a:hover::after,
        nav a.active::after {
            width: 100%;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        footer {
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(6px);
        }
    </style>
</head>

<body class="animate__animated animate__fadeIn min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="flex justify-between items-center px-8 py-4 sticky top-0 z-50 shadow-md">
        <h1 class="text-2xl font-bold text-orange-400">ServEase</h1>

        <div class="hidden md:flex items-center space-x-6 text-lg">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Home</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Services</a>
            <a href="{{ route('messages') }}" class="{{ request()->routeIs('messages') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Messages</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active text-orange-400' : 'hover:text-orange-400' }}">About</a>
        </div>

        <!-- Auth Links -->
<div class="flex items-center space-x-4">
    @auth
        <span class="text-sm text-gray-200">Hi, {{ Auth::user()->name }}</span>

        @php
            $role = Auth::user()->role;
        @endphp

        @if ($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-sm font-semibold text-white transition">
                Dashboard
            </a>
        @elseif ($role === 'provider')
            <a href="{{ route('provider.dashboard') }}" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-sm font-semibold text-white transition">
                Dashboard
            </a>
        @else
            <a href="{{ route('customer.dashboard') }}" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-sm font-semibold text-white transition">
                Dashboard
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-sm font-semibold text-white transition">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="hover:text-orange-400 font-medium">Login</a>
        <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-sm font-semibold text-white transition">Register</a>
    @endauth
</div>

    </nav>

    <!-- Page Content -->
    <main class="flex-1 p-10 animate__animated animate__fadeInUp animate__faster">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm mt-12">
        © {{ date('Y') }} <span class="text-orange-400 font-semibold">ServEase</span>. All Rights Reserved.
    </footer>

</body>
</html>
