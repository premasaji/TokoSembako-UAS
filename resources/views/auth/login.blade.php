<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login POS</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-teal-100 flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-96">
    <h2 class="text-3xl font-bold text-center text-teal-600 mb-6">
        TOKO MADURA
    </h2>
    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" action="/login">
        @csrf
        <label>Email</label>
        <input
            type="email"
            name="email"
            class="w-full border rounded p-2 mb-4">
        <label>Password</label>
        <input
            type="password"
            name="password"
            class="w-full border rounded p-2 mb-4">
        <button
            class="w-full bg-teal-600 text-white py-2 rounded">
            Login
        </button>
    </form>
</div>
</body>
</html>