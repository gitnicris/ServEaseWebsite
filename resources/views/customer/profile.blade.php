<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile | ServEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
            transform: translateY(-3px);
        }
        input, textarea {
            color: black;
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 sidebar p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold text-orange-400 mb-6">ServEase</h2>
            <nav class="space-y-3">
                <a href="{{ route('customer.dashboard') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('customer.dashboard') ? 'text-orange-400 font-semibold' : '' }}">
                   🏠 Dashboard
                </a>
                <a href="{{ route('customer.bookings') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('customer.bookings') ? 'text-orange-400 font-semibold' : '' }}">
                   📅 My Bookings
                </a>
                <a href="{{ route('customer.messages') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('customer.messages') ? 'text-orange-400 font-semibold' : '' }}">
                   💬 Messages
                </a>
                <a href="{{ route('customer.profile') }}" 
                   class="block hover:text-orange-400 {{ request()->routeIs('customer.profile') ? 'text-orange-400 font-semibold' : '' }}">
                   👤 Profile
                </a>
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
        <h1 class="text-3xl font-bold mb-8">My Profile</h1>

        @if(session('success'))
            <div class="bg-green-500/80 p-3 rounded-lg mb-6 text-center text-white">
                {{ session('success') }}
            </div>
        @endif

        <div class="card p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo -->
                <div class="text-center mb-6">
                    @if($profile->photo)
                        <img src="{{ asset('storage/' . $profile->photo) }}" class="w-28 h-28 mx-auto rounded-full object-cover border-4 border-orange-400">
                    @else
                        <div class="w-28 h-28 mx-auto bg-orange-400 rounded-full flex items-center justify-center text-3xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <label class="text-sm font-medium block">Change Photo</label>
                        <input type="file" name="photo" class="mt-1 text-white text-sm">
                        @error('photo') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-orange-300">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @error('name') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-orange-300">Bio</label>
                    <textarea name="bio" rows="3" class="w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-orange-300">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label class="block mb-1 font-semibold text-orange-300">Address</label>
                    <input type="text" name="address" value="{{ old('address', $profile->address) }}" class="w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-6 py-2 rounded-lg font-semibold text-white shadow-md">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
