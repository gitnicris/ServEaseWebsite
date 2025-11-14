<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ServEase')</title>

    <!-- 🧩 Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- 🧩 Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- 🧩 Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* 🧭 Navbar */
        nav {
            background: rgba(15, 15, 30, 0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        nav a {
            position: relative;
            color: #e5e5e5;
            transition: color 0.3s ease;
        }

        nav a:hover,
        nav a.active {
            color: #ffffff;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fff;
            transition: width 0.3s ease;
        }

        nav a:hover::after,
        nav a.active::after {
            width: 100%;
        }

        /* 📱 Sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
            background: rgba(20, 20, 40, 0.9);
            backdrop-filter: blur(14px);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar a {
            color: #d1d5db;
            transition: color 0.2s ease;
        }

        .sidebar a:hover {
            color: #ffffff;
        }

        /* 🦶 Footer */
        footer {
            background: rgba(0, 0, 0, 0.25);
            color: #ccc;
        }

        /* 📱 Responsive Adjustments */
        @media (max-width: 768px) {
            main {
                padding: 1.5rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- 🧭 Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 sticky top-0 z-50 shadow-md">
        <div class="flex items-center space-x-3">
            <button id="burgerBtn" class="text-3xl text-white focus:outline-none">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="text-2xl font-bold text-white tracking-wide">
                <i class="bi bi-stars me-1"></i> ServEase
            </h1>
        </div>

        <!-- 🌐 Desktop Nav -->
        <div class="hidden md:flex items-center space-x-6 text-lg">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.index') ? 'active' : '' }}">Services</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        </div>

        <!-- 👤 Auth Section -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <div class="flex items-center space-x-3">
                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                         alt="Profile" 
                         class="w-9 h-9 rounded-full border-2 border-white shadow-md object-cover">
                    <span class="text-sm text-gray-200 font-medium">
                        Hi, {{ Auth::user()->name }}
                    </span>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-white font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded-md text-sm font-semibold text-white">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- 📱 Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 left-0 w-64 h-full z-50 transform -translate-x-full flex flex-col p-6 space-y-5 text-lg text-white">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Menu</h2>
            <button id="closeSidebar" class="text-3xl hover:text-gray-300">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('services.index') }}">Services</a>
        <a href="{{ route('about') }}">About</a>

        <hr class="border-gray-600">

        @auth
            <span class="text-sm text-gray-300">Hi, {{ Auth::user()->name }}</span>
            @php $role = Auth::user()->role; @endphp

            @if ($role === 'provider')
                <a href="{{ route('provider.dashboard') }}">Dashboard</a>
                <a href="{{ route('provider.profile') }}">Profile</a>
                <a href="{{ route('provider.services') }}">My Services</a>
                <a href="{{ route('provider.pending') }}">Pending Bookings</a>
                <a href="{{ route('provider.bookings') }}">Bookings</a>
                <a href="{{ route('provider.messages.index') }}" class="flex items-center space-x-2">
                    <i class="bi bi-chat-dots"></i> <span>Chats</span>
                </a>
                <a href="{{ route('provider.settings') }}">Account Settings</a>

            @elseif ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                <a href="{{ route('customer.profile') }}">Profile</a>
                <a href="{{ route('customer.bookings') }}">My Bookings</a>
                <a href="{{ route('customer.messages.index') }}" class="flex items-center space-x-2">
                    <i class="bi bi-chat-dots"></i> <span>Chats</span>
                </a>
              
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 w-full text-center px-3 py-1 rounded-md text-sm font-semibold text-white mt-3">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}" 
               class="bg-white/20 hover:bg-white/30 w-full text-center px-3 py-1 rounded-md text-sm font-semibold mt-2">
               Register
            </a>
        @endauth
    </div>

    <!-- 🔲 Overlay -->
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- 🧩 Main Content -->
    <main class="flex-1 p-8 md:p-10 bg-white text-gray-900 shadow-inner rounded-t-none mt-0 min-h-[calc(100vh-64px)]">
        @yield('content')
    </main>

    <!-- 🦶 Footer -->
    <footer class="text-center py-6 text-sm mt-auto">
        © {{ date('Y') }} <span class="text-white font-semibold">ServEase</span>. All Rights Reserved.
    </footer>

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
