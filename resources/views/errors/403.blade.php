<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>403 Unauthorized</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-white min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-10 max-w-md text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="403" class="w-24 h-24 mx-auto mb-6">
        <h1 class="text-5xl font-bold text-red-500 mb-2">403</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Unauthorized Access</h2>
        <p class="text-gray-600 mb-6">You don't have permission to view this page.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full text-lg hover:bg-blue-700 transition">
                ⬅️ Go Back Home
            </button>
        </form>
    </div>
</body>

</html>
