<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customer->name }} | Customer Profile | ServEase Admin</title>
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
                <a href="{{ route('admin.providers') }}" class="block hover:text-orange-400">🧑‍🔧 Providers</a>
                <a href="{{ route('admin.customers') }}" class="block text-orange-400 font-semibold">👥 Customers</a>
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
        <h1 class="text-3xl font-bold mb-8">Customer Profile</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Info -->
            <div class="col-span-1 bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-orange-500 flex items-center justify-center text-3xl font-bold">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <h2 class="mt-4 text-2xl font-semibold">{{ $customer->name }}</h2>
                    <p class="text-sm text-gray-200">{{ $customer->email }}</p>
                    <p class="text-sm text-gray-300 mt-2">Joined {{ $customer->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Activity / Requested Services -->
            <div class="col-span-2 bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4 text-orange-400">Recent Activity</h2>

                @if(isset($requestedServices) && $requestedServices->count())
                    @foreach($requestedServices as $service)
                        <div class="border-b border-white/10 py-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $service->title }}</h3>
                                    <p class="text-sm text-gray-300">{{ $service->description }}</p>
                                </div>
                                <span class="
                                    px-3 py-1 rounded text-xs font-semibold
                                    @if($service->status === 'approved') bg-green-500
                                    @elseif($service->status === 'pending') bg-yellow-500
                                    @else bg-red-500 @endif">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-300">This customer has no recent service activity.</p>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.customers') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">
                ← Back to Customers
            </a>
        </div>
    </main>
</body>
</html>
