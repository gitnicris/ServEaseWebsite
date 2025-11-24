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
            --primary: #111827;
            --accent:  #2563eb;
            --bg-soft: #f3f4f6;
            --border-soft: #e5e7eb;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-soft);
            color: #111827;
            min-height: 100vh;
        }

        /* LAYOUT WRAPPER (SIDEBAR + MAIN) */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid var(--border-soft);
            padding: 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: fixed;
            inset-block: 0;
            z-index: 40;
            transition: width 0.2s ease, transform 0.25s ease;
        }

        /* collapsed sidebar */
        .sidebar-collapsed .sidebar {
            width: 72px;
            padding-inline: 0.75rem;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: space-between;
        }

        .sidebar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo {
            width: 42px;
            height: 42px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--accent), #4b5563);
            flex-shrink: 0;
        }

        .sidebar-title-block {
            display: flex;
            flex-direction: column;
        }

        .sidebar-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary);
        }

        .sidebar-subtitle {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .sidebar-collapsed .sidebar-title-block {
            display: none;
        }

        .sidebar-toggle-btn {
            border: none;
            background: transparent;
            padding: 0.15rem;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #9ca3af;
            transition: background 0.15s ease, color 0.15s ease, transform 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            background: #eef2ff;
            color: var(--accent);
        }

        .sidebar-collapsed .sidebar-toggle-btn i {
            transform: rotate(180deg);
        }

        .sidebar-section-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #9ca3af;
            margin-bottom: 0.75rem;
            margin-left: 0.25rem;
        }

        .sidebar-collapsed .sidebar-section-label {
            display: none;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.55rem 0.85rem;
            border-radius: 0.6rem;
            font-size: 0.9rem;
            color: #4b5563;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease;
            white-space: nowrap;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sidebar-link span {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-link:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        .sidebar-link.active {
            background: #e5edff;
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-collapsed .sidebar-link span {
            display: none;
        }

        .sidebar-footer {
            margin-top: auto;
        }

        .sidebar-logout-btn {
            width: 100%;
            border-radius: 0.6rem;
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
        }

        /* MOBILE SIDEBAR (slide in/out) */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar-open-mobile .sidebar {
                transform: translateX(0%);
            }
        }

        /* OVERLAY FOR MOBILE SIDEBAR */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 35;
            display: none;
        }

        .sidebar-open-mobile .sidebar-overlay {
            display: block;
        }

        /* TOPBAR */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: #f9fafb;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            min-width: 0;
            flex: 1 1 auto;
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            font-size: 0.9rem;
            flex-wrap: wrap;
        }

        .topbar-nav a {
            text-decoration: none;
            color: #4b5563;
            padding-bottom: 2px;
            border-bottom: 2px solid transparent;
            transition: color 0.15s ease, border-color 0.15s ease;
        }

        .topbar-nav a:hover {
            color: var(--primary);
        }

        .topbar-nav a.active {
            color: var(--accent);
            border-color: var(--accent);
            font-weight: 600;
        }

        /* SEARCH BAR */
        .topbar-search {
            max-width: 260px;
            width: 100%;
            position: relative;
        }

        .topbar-search input {
            width: 100%;
            border-radius: 999px;
            border: 1px solid var(--border-soft);
            padding: 0.35rem 2.25rem 0.35rem 0.85rem;
            font-size: 0.85rem;
            outline: none;
            background: #ffffff;
        }

        .topbar-search button {
            position: absolute;
            right: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 0;
        }

        .topbar-search i {
            font-size: 0.95rem;
            color: #9ca3af;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .topbar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            object-fit: cover;
            border: 1px solid var(--border-soft);
        }

        .topbar-user-name {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .topbar-user-role {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* BURGER BUTTON (mobile) */
        .topbar-burger {
            display: none;
            border: none;
            background: transparent;
            font-size: 1.4rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .topbar-burger {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* MAIN AREA */
        .main-area {
            margin-left: 250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.2s ease;
            width: 100%;
        }

        .sidebar-collapsed .main-area {
            margin-left: 72px;
        }

        @media (max-width: 768px) {
            .main-area {
                margin-left: 0;
            }
        }

        main {
            padding: 1.75rem;
        }

        .page-card {
            background: #ffffff;
            border-radius: 0.9rem;
            border: 1px solid var(--border-soft);
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(15,23,42,0.03);
        }

        footer {
            border-top: 1px solid var(--border-soft);
            background: #f9fafb;
            color: #6b7280;
            font-size: 0.8rem;
        }

        /* TABLET: nicer stacking */
        @media (max-width: 992px) {
            .topbar {
                justify-content: center;
            }

            .topbar-left {
                justify-content: center;
                flex: 1 1 100%;
            }

            .topbar-right {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="layout-wrapper sidebar-expanded" id="layoutWrapper">

    {{-- MOBILE OVERLAY --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-left">
                <div class="sidebar-logo">
                    SE
                </div>
                <div class="sidebar-title-block">
                    <div class="sidebar-title">ServEase</div>
                    <div class="sidebar-subtitle">Service Panel</div>
                </div>
            </div>

            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" type="button">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        @auth
            <div>
                <div class="sidebar-section-label">Navigation</div>
                <nav class="sidebar-menu">
                    @php $role = Auth::user()->role; @endphp

                    @if ($role === 'provider')
                        <a href="{{ route('provider.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('provider.profile') }}"
                           class="sidebar-link {{ request()->routeIs('provider.profile') ? 'active' : '' }}">
                            <i class="bi bi-person-badge"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('provider.services') }}"
                           class="sidebar-link {{ request()->routeIs('provider.services') ? 'active' : '' }}">
                            <i class="bi bi-briefcase"></i>
                            <span>My Services</span>
                        </a>
                        <a href="{{ route('provider.pending') }}"
                           class="sidebar-link {{ request()->routeIs('provider.pending') ? 'active' : '' }}">
                            <i class="bi bi-hourglass-split"></i>
                            <span>Pending Bookings</span>
                        </a>
                        <a href="{{ route('provider.bookings') }}"
                           class="sidebar-link {{ request()->routeIs('provider.bookings') ? 'active' : '' }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>Bookings</span>
                        </a>
                        <a href="{{ route('provider.messages.index') }}"
                           class="sidebar-link {{ request()->routeIs('provider.messages.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-dots"></i>
                            <span>Chats</span>
                        </a>
                        <a href="{{ route('provider.settings') }}"
                           class="sidebar-link {{ request()->routeIs('provider.settings') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>

                    @elseif ($role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>

                    @else
                        <a href="{{ route('customer.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('customer.profile') }}"
                           class="sidebar-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('customer.bookings') }}"
                           class="sidebar-link {{ request()->routeIs('customer.bookings') ? 'active' : '' }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>My Bookings</span>
                        </a>
                        <a href="{{ route('customer.messages.index') }}"
                           class="sidebar-link {{ request()->routeIs('customer.messages.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-dots"></i>
                            <span>Chats</span>
                        </a>
                        <a href="{{ route('customer.settings') }}"
                           class="sidebar-link {{ request()->routeIs('customer.settings') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    @endif
                </nav>
            </div>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger sidebar-logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- MAIN AREA --}}
    <div class="main-area">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                {{-- Burger for mobile --}}
                <button class="topbar-burger" id="mobileBurger" type="button">
                    <i class="bi bi-list"></i>
                </button>

                {{-- Main nav --}}
                <nav class="topbar-nav">
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

                    <a href="{{ route('services.index') }}"
                       class="{{ request()->routeIs('services.index') ? 'active' : '' }}">Services</a>

                    <a href="{{ route('about') }}"
                       class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                </nav>

            
            </div>

            <div class="topbar-right">
                @auth
                    <div class="topbar-user">
                        <img
                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                            class="topbar-user-avatar"
                        >
                        <div>
                            <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                            <div class="topbar-user-role text-capitalize">{{ Auth::user()->role }}</div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Register</a>
                @endauth
            </div>
        </header>

        <main>
            <div class="page-card">
                @yield('content')
            </div>
        </main>

        <footer class="py-3 text-center">
            © {{ date('Y') }} <strong>ServEase</strong>. All Rights Reserved.
        </footer>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const layout      = document.getElementById('layoutWrapper');
        const toggleBtn   = document.getElementById('sidebarToggleBtn');
        const burger      = document.getElementById('mobileBurger');
        const overlay     = document.getElementById('sidebarOverlay');

        // collapse/expand (desktop)
        toggleBtn?.addEventListener('click', () => {
            layout.classList.toggle('sidebar-collapsed');
        });

        // mobile open
        burger?.addEventListener('click', () => {
            layout.classList.add('sidebar-open-mobile');
        });

        // mobile close
        overlay?.addEventListener('click', () => {
            layout.classList.remove('sidebar-open-mobile');
        });
    });
</script>

</body>
</html>
