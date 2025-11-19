<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ServEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --violet: #8e44ad;
            --orange: #f39c12;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--violet), var(--orange));
            min-height: 100vh;
            color: white;
        }
        .sidebar {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(12px);
        }
        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .active-link {
            color: #f39c12;
            font-weight: 600;
        }
        table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }
        td, th {
            padding: 0.75rem 1rem;
        }
    </style>
</head>
<body class="flex min-h-screen animate__animated animate__fadeIn">

    <aside class="w-64 sidebar p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold text-orange-400 mb-6">ServEase Admin</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">🏠 Dashboard</a>
                <a href="{{ route('admin.providers') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('admin.providers') ? 'active-link' : '' }}">🧑‍🔧 Providers</a>
                <a href="{{ route('admin.customers') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('admin.customers') ? 'active-link' : '' }}">👥 Customers</a>
                <a href="{{ route('admin.services.pending') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('admin.services.pending') ? 'active-link' : '' }}">🧾 Pending Services</a>
                <a href="#" class="block hover:text-orange-400">⚙️ Settings</a>
            </nav>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-md text-white font-semibold w-full">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-10 text-white">📊 Dashboard Overview</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="card p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="text-4xl">🧑‍🔧</div>
                    <div>
                        <h2 class="text-lg font-semibold text-orange-400">Total Providers</h2>
                        <p class="text-3xl mt-1 font-bold">{{ $providersCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="text-4xl">👥</div>
                    <div>
                        <h2 class="text-lg font-semibold text-orange-400">Total Customers</h2>
                        <p class="text-3xl mt-1 font-bold">{{ $customersCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <div class="flex items-center space-x-4">
                    <div class="text-4xl">🧾</div>
                    <div>
                        <h2 class="text-lg font-semibold text-orange-400">Pending Services</h2>
                        <p class="text-3xl mt-1 font-bold">{{ $pendingCount ?? 0 }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.services.pending') }}"
                   class="mt-6 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg btn text-center">
                    Review Pending →
                </a>
            </div>
        </div>

        <!-- Recent Services Table -->
        <div class="mt-12 card p-6 rounded-xl">
            <h2 class="text-xl font-semibold mb-6 text-orange-400">🕒 Recent Service Posts</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-orange-300 border-b border-gray-400/30">
                            <th>#</th>
                            <th>Title</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentServices ?? [] as $index => $service)
                            <tr class="border-b border-white/10 hover:bg-white/10 transition">
                                <td>{{ $index + 1 }}</td>
                                <td class="font-medium">{{ $service->title }}</td>
                                <td>{{ $service->user->name ?? 'N/A' }}</td>
                                <td>
                                    @if($service->status === 'approved')
                                        <span class="bg-green-500/70 px-2 py-1 rounded text-xs text-white">Approved</span>
                                    @elseif($service->status === 'pending')
                                        <span class="bg-yellow-500/70 px-2 py-1 rounded text-xs text-white">Pending</span>
                                    @else
                                        <span class="bg-red-500/70 px-2 py-1 rounded text-xs text-white">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-300">No recent service posts</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
