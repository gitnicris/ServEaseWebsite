<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | ServEase</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f0f16;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen px-4 bg-gradient-to-br from-[#141426] to-[#0b0b12]">

    <div class="w-full max-w-lg bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-8 shadow-xl">

        <div class="text-center mb-6">
            <h2 class="text-white text-2xl font-semibold">Reset Password</h2>
            <p class="text-gray-400 text-sm">Enter your new password below</p>
        </div>

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-500/20 text-red-300 rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.reset') }}" method="POST" class="space-y-6">
            @csrf

            <!-- New Password -->
            <div>
                <label class="block text-gray-300 text-sm mb-2">New Password</label>
                <input type="password" name="password" required
                       placeholder="Enter new password"
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-orange-400 focus:outline-none">

                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!--Confirm Password -->
            <div>
                <label class="block text-gray-300 text-sm mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       placeholder="Confirm new password"
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

        <button class="btn btn-success w-100">Update Password</button>
    </form>
</div>
@endsection

</body>
</html>