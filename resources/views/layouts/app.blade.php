<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ServEase')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #11100fff;
            --secondary: #11100fff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #222;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR FIX (no more transparency issue) */
        nav {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        nav a {
            color: #e5e5e5;
            transition: 0.2s;
        }

        nav a:hover,
        nav a.active {
            color: #fff;
        }

        /* Sidebar */
        .sidebar {
            background: #1b1b2f;
            box-shadow: 3px 0 15px rgba(0,0,0,0.25);
            transform: translateX(-100%);
            transition: 0.3s ease-in-out;
        }

        /* Main Content */
        main {
            padding: 2rem;
            max-width: 1400px;
            margin: auto;
            width: 100%;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <button id="burgerBtn" class="text-3xl text-white"><i class="bi bi-list"></i></button>
            <h1 class="text-2xl font-bold text-white flex items-center gap-1">
                <i class="bi bi-stars"></i> ServEase
            </h1>
        </div>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center space-x-6 text-lg">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.index') ? 'active' : '' }}">Services</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        </div>

        <!-- Auth -->
        <div class="hidden md:flex items-center gap-3">
            @auth
                <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                     class="w-9 h-9 rounded-full border-2 border-white shadow-md object-cover">

                <span class="text-white text-sm">Hi, {{ Auth::user()->name }}</span>

            @else
                <a href="{{ route('login') }}" class="text-white">Login</a>
                <a href="{{ route('register') }}" class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded text-white">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar"
           class="sidebar fixed top-0 left-0 w-64 h-full z-50 p-6 text-white flex flex-col space-y-5">
        
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Menu</h2>
            <button id="closeSidebar" class="text-2xl"><i class="bi bi-x"></i></button>
        </div>

        <hr class="border-gray-600">

        @auth
            <span class="text-sm text-gray-300 mb-2">Hi, {{ Auth::user()->name }}</span>

            @php $role = Auth::user()->role; @endphp

            @if ($role === 'provider')
                <a href="{{ route('provider.dashboard') }}">Dashboard</a>
                <a href="{{ route('provider.profile') }}">Profile</a>
                <a href="{{ route('provider.services') }}">My Services</a>
                <a href="{{ route('provider.pending') }}">Pending Bookings</a>
                <a href="{{ route('provider.bookings') }}">Bookings</a>
                <a href="{{ route('provider.messages.index') }}"><i class="bi bi-chat-dots"></i> Chats</a>
                <a href="{{ route('provider.settings') }}">Account Settings</a>

            @elseif ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            @else
                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                <a href="{{ route('customer.profile') }}">Profile</a>
                <a href="{{ route('customer.bookings') }}">My Bookings</a>
                <a href="{{ route('customer.messages.index') }}"><i class="bi bi-chat-dots"></i> Chats</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white">Logout</button>
            </form>

        @endauth
    </aside>

    <!-- Overlay -->
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-sm">
        © {{ date('Y') }} <strong>ServEase</strong>. All Rights Reserved.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            const open = document.getElementById("burgerBtn");
            const close = document.getElementById("closeSidebar");

            open.onclick = () => {
                sidebar.style.transform = "translateX(0%)";
                overlay.classList.remove("hidden");
            };

            const hideSidebar = () => {
                sidebar.style.transform = "translateX(-100%)";
                overlay.classList.add("hidden");
            };

            close.onclick = hideSidebar;
            overlay.onclick = hideSidebar;
        });
    </script>

</body>
</html>
