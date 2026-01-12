<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes confetti {
            0% {
                transform: translateY(0) rotate(0);
                opacity: 1;
            }

            100% {
                transform: translateY(200px) rotate(720deg);
                opacity: 0;
            }
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #fbbf24;
            top: -20px;
            left: 50%;
            animation: confetti 2s infinite ease-in-out;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-green-100 via-white to-green-200 flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Confetti Animation -->
    <div class="confetti bg-yellow-400 left-1/3 animate-bounce"></div>
    <div class="confetti bg-pink-400 left-2/3 animate-ping"></div>
    <div class="confetti bg-blue-400 left-1/2 animate-bounce delay-200"></div>

    <div
        class="bg-white/90 backdrop-blur-md px-10 py-12 rounded-3xl shadow-2xl text-center max-w-md w-full transform transition hover:scale-105 duration-300">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-500 mx-auto animate-pulse"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-green-600 mb-4">Payment Successful 🎉</h1>
        <p class="text-gray-700 text-lg mb-3">
            Your event has been submitted successfully!
        </p>
        <p class="text-gray-600 mb-6">
            Please wait until an admin approves your event.
        </p>
        <p class="text-orange-700 font-semibold mb-8">Until then, enjoy AffirmSpace 🌸</p>

        <a href="/"
            class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full text-lg font-medium transition duration-300">
            Go to Homepage
        </a>
    </div>

</body>

</html>
