<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code | ServEase</title>

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
            <h2 class="text-white text-2xl font-semibold tracking-tight">Verify Code</h2>
            <p class="text-gray-400 text-sm">A 6-digit verification code was sent to your email</p>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-500/20 text-green-300 rounded-md text-center">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-500/20 text-red-300 rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.code.verify') }}" method="POST" class="space-y-6">
            @csrf

            <!--Code Input -->
            <div>
                <label class="block text-gray-300 text-sm mb-2">Enter 6-Digit Code</label>
                <input type="text" maxlength="6" name="code" required
                       placeholder="••••••"
                       class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white tracking-widest text-center text-lg placeholder-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">

                @error('code')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

        <button class="btn btn-primary w-100">Verify Code</button>
    </form>
</div>
@endsection

</body>
</html>