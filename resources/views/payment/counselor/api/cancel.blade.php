<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled | AffirmSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #fef2f2, #fee2e2, #ffffff);
        }

        .fade-in {
            animation: fadeIn 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            position: absolute;
            bottom: 15px;
            width: 100%;
            text-align: center;
            font-size: 13px;
            color: #7f1d1d;
            font-weight: 500;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen relative">

    <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl px-10 py-12 max-w-md w-full text-center fade-in">

        <div class="mb-6">
            <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 text-red-600"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold text-red-600 mb-3">
            Payment Cancelled
        </h2>

        <p class="text-gray-700 text-lg mb-2">
            Your transaction was not completed.
        </p>

        <p class="text-gray-500 mb-6">
            You can retry the payment or contact support if needed.
        </p>

        {{-- <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="javascript:history.back()"
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full font-semibold transition duration-300 transform hover:scale-105">
                Try Again
            </a>

            <a href="/"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-full font-semibold transition duration-300">
                Go to Homepage
            </a>
        </div> --}}
    </div>

    <footer>
        © 2026 AffirmSpace. All Rights Reserved.
    </footer>

</body>

</html>
