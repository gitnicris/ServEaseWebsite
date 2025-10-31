<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers | ServEase Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="flex min-h-screen bg-gradient-to-br from-purple-700 to-orange-500 text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-black/50 backdrop-blur-lg p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold text-orange-400 mb-6">ServEase Admin</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-orange-400">🏠 Dashboard</a>
                <a href="{{ route('admin.providers') }}" class="block text-orange-400 font-semibold">🧑‍🔧 Providers</a>
                <a href="#" class="block hover:text-orange-400">👥 Customers</a>
                <a href="{{ route('admin.services.pending') }}" class="block hover:text-orange-400">🧾 Pending Services</a>
                <a href="#" class="block hover:text-orange-400">⚙️ Settings</a>
            </nav>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-md font-semibold w-full">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-8">Providers Management</h1>

        <div class="card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-white/20">
                        <th class="py-2">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Services Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($providers as $index => $provider)
                        <tr class="border-b border-white/10">
                            <td class="py-2">{{ $providers->firstItem() + $index }}</td>
                            <td>{{ $provider->name }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->created_at->format('M d, Y') }}</td>
                            <td>{{ $provider->services_count }}</td>
                            <td>
                                <a href="{{ route('admin.providers.view', $provider->id) }}" 
                            class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded text-xs font-semibold inline-block">
                                  View Profile
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-300">No providers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $providers->links() }}
            </div>
        </div>
    </main>
</body>
</html>
