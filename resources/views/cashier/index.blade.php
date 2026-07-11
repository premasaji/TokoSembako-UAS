@extends('layouts.app')
@section('title', 'Kasir')
@section('content')

    @if (session('success'))
        <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex h-screen bg-gray-100">
        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-teal-600 text-white flex flex-col">
            <div class="p-6 border-b border-teal-500">
                <h1 class="text-2xl font-bold">
                    🛒 TOKO
                    <br>
                    SEDULURAN
                </h1>
                
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
                            🛒 Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('history.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-teal-700">
                            📋 Riwayat
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-5 border-t border-teal-500">
                <a href="{{ route('logout') }}" class="block text-center bg-red-500 hover:bg-red-600 py-3 rounded-lg">
                    Logout
                </a>
            </div>
        </aside>

        {{-- ================= CONTENT ================= --}}
        <main class="flex flex-1 w-full">
            {{-- ================= PRODUK ================= --}}
            <section class="flex-1 p-6 overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-3xl font-bold">
                            Pak Kasir
                        </h2>
                        <p class="text-gray-500">
                            Selamat Datang,
                            <b>{{ auth()->user()->name }}</b>
                        </p>
                    </div>
                    <form action="{{ route('cashier.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk..."
                            class="w-80 border rounded-lg p-3">
                    </form>
                </div>

                {{-- FILTER KATEGORI --}}
                <div class="flex gap-3 mb-6">
                    <a href="{{ route('cashier.index') }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == '' ? 'bg-teal-600 text-white' : 'bg-white shadow' }}">
                        Semua
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Sembako']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Sembako' ? 'bg-teal-600 text-white' : 'bg-white shadow' }}">
                        Sembako
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Minuman']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Minuman' ? 'bg-teal-600 text-white' : 'bg-white shadow' }}">
                        Minuman
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Camilan']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Camilan' ? 'bg-teal-600 text-white' : 'bg-white shadow' }}">
                        Snack
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Sabun']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Sabun' ? 'bg-teal-600 text-white' : 'bg-white shadow' }}">
                        Sabun
                    </a>
                </div>

                {{-- DAFTAR PRODUK --}}
                <div class="grid grid-cols-2 xl:grid-cols-3 gap-5">
                    @forelse($products as $product)
                        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4">
                            <div class="h-40 overflow-hidden rounded-lg bg-gray-100">
                                @if ($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/products/no-image.png') }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="mt-4">
                                <h3 class="font-bold text-lg">
                                    {{ $product->name }}
                                </h3>
                                <span class="inline-block mt-2 bg-teal-100 text-teal-700 text-xs px-2 py-1 rounded-full">
                                    {{ $product->category }}
                                </span>
                                <p class="text-2xl font-bold text-teal-600 mt-3">
                                    Rp {{ number_format($product->price_sell) }}
                                </p>
                                <p class="mt-1">
                                    Stock :
                                    <span class="{{ $product->stock <= 5 ? 'text-red-600 font-bold' : '' }}">
                                        {{ $product->stock }}
                                    </span>
                                </p>
                            </div>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2 rounded-lg">
                                    + Tambah
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-3">
                            <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500">
                                Produk tidak ditemukan.
                            </div>
                        </div>
                    @endforelse
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

                        <div class="mt-4">
                            <label class="block font-medium mb-2">
                                Metode Pembayaran
                            </label>
                            <select name="payment_method" class="w-full border rounded-lg p-2">
                                <option value="Tunai">Tunai</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
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
