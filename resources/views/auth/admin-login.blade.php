<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl p-8">

        <!-- Heading -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-white">Admin Login</h2>
            <p class="text-gray-300 text-sm mt-1">Secure access to dashboard</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label class="block text-gray-300 mb-2 text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email">
                @error('email')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label class="block text-gray-300 mb-2 text-sm">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your password">
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 transition-all text-white py-2.5 rounded-lg font-semibold shadow-lg">
                Login
            </button>
        </form>

    </div>

</body>

</html>
