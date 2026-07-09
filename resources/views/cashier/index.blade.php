@extends('layouts.app')
@section('title','Kasir')
@section('content')
<div class="flex h-screen bg-gray-100">
    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-64 bg-teal-600 text-white flex flex-col">
        <div class="p-6 border-b border-teal-500">
            <h1 class="text-2xl font-bold">
                🛒 TOKO
                <br>
                KELONTONG
            </h1>
            <p class="text-sm mt-2 text-teal-100">
                Point Of Sale
            </p>
        </div>
        <nav class="flex-1 p-5">
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-teal-700">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('cashier.index') }}"
                        class="flex items-center gap-3 p-3 rounded-lg bg-white text-teal-600 font-semibold">
                        🛒 Kasir
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-teal-700">
                        📋 Riwayat
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-5 border-t border-teal-500">
            <a href="{{ route('logout') }}"
                class="block text-center bg-red-500 hover:bg-red-600 py-3 rounded-lg">
                Logout
            </a>
        </div>
    </aside>

    {{-- ================= CONTENT ================= --}}
    <main class="flex-1 flex">
        {{-- ================= PRODUK ================= --}}
        <section class="w-2/3 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-bold">
                        Kasir
                    </h2>
                    <p class="text-gray-500">
                        Selamat Datang,
                        <b>{{ auth()->user()->name }}</b>
                    </p>
                </div>
                <form method="GET">
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari Produk..."
                        class="w-80 border rounded-lg p-3 shadow-sm">
                </form>
            </div>

            {{-- FILTER KATEGORI --}}
            <div class="flex gap-3 mb-6">
                <button
                    class="bg-teal-600 text-white px-5 py-2 rounded-lg">
                    Semua
                </button>
                <button
                    class="bg-white px-5 py-2 rounded-lg shadow">
                    Sembako
                </button>
                <button
                    class="bg-white px-5 py-2 rounded-lg shadow">
                    Minuman
                </button>
                <button
                    class="bg-white px-5 py-2 rounded-lg shadow">
                    Snack
                </button>
                <button
                    class="bg-white px-5 py-2 rounded-lg shadow">
                    Sabun
                </button>
            </div>

            {{-- DAFTAR PRODUK --}}
            <div class="grid grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow hover:shadow-lg duration-200 p-5">
                    <div class="flex justify-between">
                        <h3 class="font-bold text-lg">
                            {{ $product->name }}
                        </h3>
                        <span class="bg-teal-100 text-teal-700 text-xs px-2 py-1 rounded">
                            {{ $product->category }}
                        </span>
                    </div>
                    <div class="mt-5">
                        <p class="text-3xl font-bold text-teal-600">
                            Rp {{ number_format($product->price_sell) }}
                        </p>
                    </div>
                    <div class="mt-3">
                        @if($product->stock <= 5)
                            <span class="text-red-600 font-bold">
                                Stock : {{ $product->stock }}
                            </span>
                        @else
                            <span>
                                Stock : {{ $product->stock }}
                            </span>
                        @endif
                    </div>
                    <form
                        action="{{ route('cart.add',$product->id) }}"
                        method="POST">
                        @csrf
                        <button
                            class="mt-5 w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg">
                            + Tambah
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    {{-- ================= KERANJANG ================= --}}
    <aside class="w-96 bg-white border-l border-gray-200 flex flex-col">
        <div class="p-5 border-b">
            <h2 class="text-2xl font-bold text-gray-700">Keranjang Belanja</h2>
        </div>

        @php
            $cart = session('cart', []);
            $totalQty = 0;
            $totalPrice = 0;
        @endphp

        <div class="flex-1 overflow-y-auto p-5">
            @forelse($cart as $item)
                @php
                    $subtotal = $item['price'] * $item['qty'];
                    $totalQty += $item['qty'];
                    $totalPrice += $subtotal;
                @endphp

                <div class="border rounded-lg p-4 mb-4">
                    <h3 class="font-semibold text-lg">{{ $item['name'] }}</h3>

                    <p class="text-teal-600 font-bold mt-1">
                        Rp {{ number_format($item['price']) }}
                    </p>

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-2">
                            <form action="{{ route('cart.minus', $item['id']) }}" method="POST">
                                @csrf
                                <button class="w-8 h-8 bg-red-500 text-white rounded">-</button>
                            </form>

                            <span class="font-bold">{{ $item['qty'] }}</span>

                            <form action="{{ route('cart.plus', $item['id']) }}" method="POST">
                                @csrf
                                <button class="w-8 h-8 bg-green-500 text-white rounded">+</button>
                            </form>
                        </div>

                        <span class="font-semibold">
                            Rp {{ number_format($subtotal) }}
                        </span>
                    </div>

                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="mt-3">
                        @csrf
                        <button class="text-red-500 text-sm hover:underline">
                            Hapus
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center text-gray-400 mt-10">
                    Keranjang masih kosong
                </div>
            @endforelse
        </div>

        <div class="border-t p-5">
            <div class="flex justify-between mb-3">
                <span>Total Barang</span>
                <span class="font-bold">{{ $totalQty }}</span>
            </div>

            <div class="flex justify-between mb-5">
                <span>Total Harga</span>
                <span class="font-bold text-teal-600">
                    Rp {{ number_format($totalPrice) }}
                </span>
            </div>

            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <label class="font-semibold">Uang Bayar</label>
                <input type="number" name="money_paid" class="w-full border rounded-lg p-3 mt-2 mb-4"
                    placeholder="Masukkan uang bayar" required>
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg">
                    CHECKOUT
                </button>
            </form>
        </div>
    </aside>
    </main>
    </div>


@endsection
