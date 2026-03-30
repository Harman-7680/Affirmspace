<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">

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
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="bg-white h-screen flex items-center justify-center">

    <div class="w-full max-w-md text-center px-6">

        <!-- subtle LGBTQ line -->
        <div class="rainbow-bar rounded-full mb-8"></div>

        <!-- Illustration -->
        <div class="flex justify-center mb-6 float">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none">

                <!-- circle (search) -->
                <circle cx="50" cy="50" r="30" stroke="#9ca3af" stroke-width="4" />

                <!-- handle -->
                <line x1="72" y1="72" x2="100" y2="100" stroke="#9ca3af" stroke-width="4"
                    stroke-linecap="round" />

                <!-- small X inside -->
                <line x1="40" y1="40" x2="60" y2="60" stroke="#ef4444" stroke-width="3" />
                <line x1="60" y1="40" x2="40" y2="60" stroke="#ef4444" stroke-width="3" />
            </svg>
        </div>

        <!-- 404 -->
        <h1 class="text-5xl font-bold text-gray-900 tracking-tight">
            404
        </h1>

        <!-- message -->
        <p class="text-lg mt-4 text-gray-600">
            We couldn’t find the page you’re looking for.
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
