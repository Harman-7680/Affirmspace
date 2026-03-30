<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>403 Unauthorized</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .rainbow-bar {
            height: 4px;
            background: linear-gradient(to right,
                    #e11d48,
                    #f97316,
                    #eab308,
                    #22c55e,
                    #3b82f6,
                    #8b5cf6);
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="bg-white h-screen flex items-center justify-center">

    <div class="w-full max-w-md text-center px-6">

        <!-- LGBTQ line -->
        <div class="rainbow-bar rounded-full mb-8"></div>

        <!-- Illustration -->
        <div class="flex justify-center mb-6 float">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none">

                <!-- lock body -->
                <rect x="30" y="50" width="60" height="40" rx="10" stroke="#9ca3af" stroke-width="4" />

                <!-- lock top -->
                <path d="M40 50V40a20 20 0 0 1 40 0v10" stroke="#9ca3af" stroke-width="4" />

                <!-- cross -->
                <line x1="45" y1="60" x2="75" y2="80" stroke="#ef4444" stroke-width="3" />
                <line x1="75" y1="60" x2="45" y2="80" stroke="#ef4444" stroke-width="3" />

            </svg>
        </div>

        <!-- 403 -->
        <h1 class="text-5xl font-bold text-gray-900 tracking-tight">
            403
        </h1>

        <!-- message -->
        <p class="text-lg mt-4 text-gray-600">
            You don’t have permission to access this page.
        </p>

        <!-- button -->
        <div class="mt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-6 py-2 rounded-full text-white text-sm font-medium bg-gray-900 hover:bg-gray-800 transition">
                    Back To Home
                </button>
            </form>
        </div>

    </div>

</body>

</html>
