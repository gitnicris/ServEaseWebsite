<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ServEase')</title>

    <!-- 🧩 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 🧩 Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- 🧩 Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- 🧩 Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

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

        nav {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
        }

        nav a {
            position: relative;
            padding-bottom: 4px;
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

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        footer {
            background: rgba(0, 0, 0, 0.4);
        }

        /* 🌟 Optional - make inner content readable */
        main {
            color: #222;
        }

        .card {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- 🧭 Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 sticky top-0 z-50 shadow-md">
        <div class="flex items-center space-x-3">
            <!-- 🍔 Burger Button -->
            <button id="burgerBtn" class="text-3xl text-orange-400 focus:outline-none">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="text-2xl font-bold text-orange-400">ServEase</h1>
        </div>

        <!-- 🌐 Desktop Nav -->
        <div class="hidden md:flex items-center space-x-6 text-lg">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Home</a>
            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.index') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Services</a>
            <a href="{{ route('messages') }}" class="{{ request()->routeIs('messages') ? 'active text-orange-400' : 'hover:text-orange-400' }}">Messages</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active text-orange-400' : 'hover:text-orange-400' }}">About</a>
        </div>

        <!-- 👤 Auth Section -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <span class="text-sm text-gray-200">Hi, {{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" class="hover:text-orange-400 font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded-md text-sm font-semibold text-white">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- 📱 Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 left-0 w-64 h-full bg-black/90 backdrop-blur-lg z-50 transform -translate-x-full flex flex-col p-6 space-y-5 text-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-orange-400">Menu</h2>
            <button id="closeSidebar" class="text-3xl text-gray-300 hover:text-orange-400">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <a href="{{ route('home') }}" class="hover:text-orange-400">Home</a>
        <a href="{{ route('services.index') }}" class="hover:text-orange-400">Services</a>
        <a href="{{ route('messages') }}" class="hover:text-orange-400">Messages</a>
        <a href="{{ route('about') }}" class="hover:text-orange-400">About</a>

        <hr class="border-gray-600">

        @auth
            <span class="text-sm text-gray-300">Hi, {{ Auth::user()->name }}</span>
            @php $role = Auth::user()->role; @endphp

            @if ($role === 'provider')
                <a href="{{ route('provider.dashboard') }}" class="hover:text-orange-400">Dashboard</a>
                <a href="{{ route('provider.profile') }}" class="hover:text-orange-400">Profile</a>
                <a href="{{ route('provider.services') }}" class="hover:text-orange-400">My Services</a>
            @elseif ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-400">Dashboard</a>
            @else
                <a href="{{ route('customer.dashboard') }}" class="hover:text-orange-400">Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 w-full text-center px-3 py-1 rounded-md text-sm font-semibold text-white mt-3">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:text-orange-400">Login</a>
            <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 w-full text-center px-3 py-1 rounded-md text-sm font-semibold text-white mt-2">Register</a>
        @endauth
    </div>

    <!-- 🔲 Overlay -->
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- 🧩 Main Content -->
    <main class="flex-1 p-10">
        @yield('content')
    </main>

    <!-- 🦶 Footer -->
    <footer class="text-center py-6 text-sm mt-12 text-gray-200">
        © {{ date('Y') }} <span class="text-orange-400 font-semibold">ServEase</span>. All Rights Reserved.
    </footer>

    <!-- 🧠 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const burgerBtn = document.getElementById("burgerBtn");
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            const closeSidebar = document.getElementById("closeSidebar");

            burgerBtn.addEventListener("click", () => {
                sidebar.classList.remove("-translate-x-full");
                overlay.classList.remove("hidden");
            });

            const hideSidebar = () => {
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
            };

            closeSidebar.addEventListener("click", hideSidebar);
            overlay.addEventListener("click", hideSidebar);
        });
    </script>
</body>
</html>
