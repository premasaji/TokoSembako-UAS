<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50">

    {{-- NAVBAR --}}
    <nav class="app-navbar sticky top-0 z-50 h-[68px] bg-sky-700 shadow-sm">
        <div class="flex h-full justify-between items-center px-10">

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
    <main>
        @yield('content')
    </main>

</body>

</html>
