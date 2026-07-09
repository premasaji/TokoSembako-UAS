<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-teal-600 shadow">
        <div class="max-w-7xl mx-auto flex justify-between px-6 py-4">
            <h1 class="text-2xl font-bold text-white">
                POS TOKO KELONTONG
            </h1>
            <div>
                <span class="text-white">
                    {{ auth()->user()->name }}
                </span>
                <a href="/logout" class="text-white">
                    Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto mt-8">
        @yield('content')
    </div>
</body>
</html>
