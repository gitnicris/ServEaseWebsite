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
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="flex min-h-screen animate__animated animate__fadeIn">

    <!-- Sidebar -->
    <aside class="w-64 sidebar p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold text-orange-400 mb-6">ServEase Admin</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-orange-400">🏠 Dashboard</a>
                <a href="#" class="block hover:text-orange-400">🧑‍🔧 Providers</a>
                <a href="#" class="block hover:text-orange-400">👥 Customers</a>
                <a href="{{ route('admin.services.pending') }}" class="block hover:text-orange-400">🧾 Pending Services</a>
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
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-8">Dashboard Overview</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="card p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold text-orange-400">Total Providers</h2>
                <p class="text-4xl mt-2 font-bold">{{ $providersCount ?? 0 }}</p>
            </div>

            <div class="card p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold text-orange-400">Total Customers</h2>
                <p class="text-4xl mt-2 font-bold">{{ $customersCount ?? 0 }}</p>
            </div>

            <div class="card p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-orange-400">Pending Services</h2>
                    <p class="text-4xl mt-2 font-bold">{{ $pendingServicesCount ?? 0 }}</p>
                </div>
                <a href="{{ route('admin.services.pending') }}"
                   class="mt-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg btn text-center">
                    Review Pending Services →
                </a>
            </div>
        </div>

        <div class="mt-10 card p-6 rounded-xl">
            <h2 class="text-xl font-semibold mb-4 text-orange-400">Recent Service Posts</h2>
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-400/30">
                        <th class="py-2">#</th>
                        <th>Title</th>
                        <th>Provider</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentServices ?? [] as $index => $service)
                        <tr class="border-b border-gray-400/20">
                            <td class="py-2">{{ $index + 1 }}</td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($service->status === 'approved')
                                    <span class="bg-green-500 px-2 py-1 rounded text-xs">Approved</span>
                                @elseif($service->status === 'pending')
                                    <span class="bg-yellow-500 px-2 py-1 rounded text-xs">Pending</span>
                                @else
                                    <span class="bg-red-500 px-2 py-1 rounded text-xs">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-300">No recent service posts</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
