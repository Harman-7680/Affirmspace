<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <h1 class="text-6xl font-bold text-blue-600">404</h1>
        <p class="text-xl mt-4 text-gray-800">Oops! The page you are looking for doesn't exist.</p><br>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full text-lg hover:bg-blue-700 transition">
                ⬅️ Back To Home
            </button>
        </form>
    </div>
</body>

</html>
