<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Maintenance</title>
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

                <!-- wrench -->
                <path d="M40 80L80 40" stroke="#9ca3af" stroke-width="4" />
                <circle cx="40" cy="80" r="6" stroke="#9ca3af" stroke-width="3" />
                <circle cx="80" cy="40" r="6" stroke="#9ca3af" stroke-width="3" />

            </svg>
        </div>

        <h1 class="text-5xl font-bold text-gray-900">503</h1>

        <p class="text-lg mt-4 text-gray-600">
            We are under maintenance. Please come back later.
        </p>

        <!-- button -->
        {{-- <div class="mt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-6 py-2 rounded-full text-white text-sm font-medium bg-gray-900 hover:bg-gray-800 transition">
                    Back To Home
                </button>
            </form>
        </div> --}}

    </div>

</body>

</html>
