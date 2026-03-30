<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Required</title>
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

        <!-- line -->
        <div class="rainbow-bar rounded-full mb-8"></div>

        <!-- Illustration -->
        <div class="flex justify-center mb-6 float">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none">

                <!-- user -->
                <circle cx="60" cy="45" r="15" stroke="#9ca3af" stroke-width="4" />
                <path d="M30 90C30 70 90 70 90 90" stroke="#9ca3af" stroke-width="4" />

                <!-- lock -->
                <rect x="50" y="65" width="20" height="20" rx="4" stroke="#ef4444" stroke-width="3" />

            </svg>
        </div>

        <h1 class="text-5xl font-bold text-gray-900">401</h1>

        <p class="text-lg mt-4 text-gray-600">
            Please login to continue.
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
