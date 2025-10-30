<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Services | ServEase Admin</title>
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
    </style>
</head>
<body class="flex min-h-screen animate__animated animate__fadeIn">

    <!-- Sidebar -->
    <aside class="w-64 sidebar p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold text-orange-400 mb-6">ServEase Admin</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-orange-400">🏠 Dashboard</a>
                <a href="{{ route('admin.services.pending') }}" class="block hover:text-orange-400 text-orange-300 font-semibold">🧾 Pending Services</a>
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
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Pending Services</h1>
            <div class="text-sm text-gray-200 mt-3 sm:mt-0">
                Approved: <span class="text-green-400 font-semibold">{{ $approvedCount }}</span> | 
                Rejected: <span class="text-red-400 font-semibold">{{ $rejectedCount }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4 animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4 animate__animated animate__fadeInDown">
                {{ session('error') }}
            </div>
        @endif

        @if ($pendingServices->isEmpty())
            <p class="text-center text-gray-200 mt-10">🎉 No pending services at the moment!</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-400/30">
                            <th class="py-3 px-2">#</th>
                            <th class="py-3 px-2">Service Title</th>
                            <th class="py-3 px-2">Provider</th>
                            <th class="py-3 px-2">Price</th>
                            <th class="py-3 px-2">Category</th>
                            <th class="py-3 px-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingServices as $index => $service)
                            <tr class="border-b border-gray-400/20 hover:bg-white/10 transition">
                                <td class="py-3 px-2">{{ $index + 1 }}</td>
                                <td class="py-3 px-2 font-semibold">{{ $service->title }}</td>
                                <td class="py-3 px-2">{{ $service->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-2">₱{{ number_format($service->price, 2) }}</td>
                                <td class="py-3 px-2">{{ $service->category ?? '—' }}</td>
                                <td class="py-3 px-2 space-x-2">
                                    <form method="POST" action="{{ route('admin.services.approve', $service->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-white text-xs font-medium">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.services.reject', $service->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-xs font-medium">
                                            ❌ Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</body>
</html>
