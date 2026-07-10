<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-teal-600 shadow">
        <div class="flex justify-between items-center px-10 py-4">

            <h1 class="text-3xl font-bold text-white">
                TOKO SEDULURAN
            </h1>

            <div class="flex items-center gap-5 text-white">
                <span>{{ auth()->user()->name }}</span>

                <a href="{{ route('logout') }}" class="hover:underline">
                    Logout
                </a>
            </div>

        </div>
    </nav>

    {{-- ISI HALAMAN --}}
    <main class="pt-24">
        @yield('content')
    </main>

</body>

</html>
