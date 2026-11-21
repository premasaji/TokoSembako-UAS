@extends('layouts.app')
@section('title', 'Kasir')
@section('content')

    @if (session('success'))
        <div class="mb-5 bg-sky-50 border border-sky-200 text-sky-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex h-screen bg-sky-50">
        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-sky-700 text-white transition-all duration-200 shadow-sm hover:shadow-md">
            <div class="p-6 border-b border-sky-600 flex items-center justify-center">
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
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-sky-600">
                            📊 Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cashier.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg bg-sky-100 text-sky-800 font-semibold">
                            🛒 Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('history.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-sky-600">
                            📋 Riwayat
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-5 border-t border-sky-600">
                <a href="{{ route('logout') }}" class="block text-center bg-sky-600 hover:bg-sky-500 py-3 rounded-lg">
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
                        class="px-5 py-2 rounded-lg {{ request('category') == '' ? 'bg-sky-600 text-white' : 'bg-white shadow' }}">
                        Semua
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Sembako']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Sembako' ? 'bg-sky-600 text-white' : 'bg-white shadow' }}">
                        Sembako
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Minuman']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Minuman' ? 'bg-sky-600 text-white' : 'bg-white shadow' }}">
                        Minuman
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Camilan']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Camilan' ? 'bg-sky-600 text-white' : 'bg-white shadow' }}">
                        Snack
                    </a>
                    <a href="{{ route('cashier.index', ['category' => 'Sabun']) }}"
                        class="px-5 py-2 rounded-lg {{ request('category') == 'Sabun' ? 'bg-sky-600 text-white' : 'bg-white shadow' }}">
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
                                <span class="inline-block mt-2 bg-sky-100 text-sky-800 text-xs px-2 py-1 rounded-full">
                                    {{ $product->category }}
                                </span>
                                <p class="text-2xl font-bold text-sky-800 mt-3">
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
                                <button class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2 rounded-lg">
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
            <aside class="flex w-96 flex-col border-l border-sky-100 bg-white shadow-lg">
                @php
                    $cart = session('cart', []);
                    $totalQty = 0;
                    $totalPrice = 0;
                    $totalLines = count($cart);
                @endphp

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Pesanan Saat Ini</h2>
                        <p class="mt-1 text-sm text-slate-500">Rincian belanja pelanggan</p>
                    </div>
                    <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-800">
                        {{ $totalLines }} item
                    </span>
                </div>

                <div class="flex-1 overflow-y-auto bg-slate-50/70 p-4">
                    @forelse($cart as $item)
                        @php
                            $subtotal = $item['price'] * $item['qty'];
                            $totalQty += $item['qty'];
                            $totalPrice += $subtotal;
                        @endphp

                        <article class="mb-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate font-semibold text-slate-800">{{ $item['name'] }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Rp {{ number_format($item['price']) }} <span class="text-slate-400">/ item</span>
                                    </p>
                                </div>
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" aria-label="Hapus {{ $item['name'] }}"
                                        class="rounded-lg px-2 py-1 text-sm text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('cart.minus', $item['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" aria-label="Kurangi jumlah {{ $item['name'] }}"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-lg font-semibold text-slate-600 transition hover:bg-slate-100">
                                            -
                                        </button>
                                    </form>
                                    <span class="min-w-6 text-center font-semibold text-slate-700">{{ $item['qty'] }}</span>
                                    <form action="{{ route('cart.plus', $item['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" aria-label="Tambah jumlah {{ $item['name'] }}"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-600 text-lg font-semibold text-white transition hover:bg-sky-700">
                                            +
                                        </button>
                                    </form>
                                </div>
                                <span class="font-bold text-slate-800">Rp {{ number_format($subtotal) }}</span>
                            </div>
                        </article>
                    @empty
                        <div class="flex h-full min-h-48 flex-col items-center justify-center text-center">
                            <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-sky-100 text-2xl">
                                🛒
                            </div>
                            <p class="font-semibold text-slate-700">Belum ada pesanan</p>
                            <p class="mt-1 text-sm text-slate-500">Pilih produk untuk memulai transaksi.</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-slate-200 bg-white p-5">
                    <div class="mb-4 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-500">
                            <span>Jumlah barang</span>
                            <span>{{ $totalQty }} pcs</span>
                        </div>
                        <div class="flex justify-between border-t border-dashed border-slate-200 pt-3">
                            <span class="font-semibold text-slate-700">Total pembayaran</span>
                            <span class="text-xl font-bold text-sky-800">Rp {{ number_format($totalPrice) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout') }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <label for="payment_method" class="mb-1 block text-sm font-medium text-slate-700">
                                Metode pembayaran
                            </label>
                            <select id="payment_method" name="payment_method"
                                class="w-full rounded-lg border border-slate-300 bg-white p-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-100">
                                <option value="Tunai">Tunai</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div>
                            <label for="money_paid" class="mb-1 block text-sm font-medium text-slate-700">Uang diterima</label>
                            <input id="money_paid" type="number" name="money_paid" min="{{ $totalPrice }}" step="any"
                                class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-100"
                                placeholder="Masukkan nominal pembayaran" required {{ $totalQty === 0 ? 'disabled' : '' }}>
                        </div>
                        <button type="submit" {{ $totalQty === 0 ? 'disabled' : '' }}
                            class="w-full rounded-lg bg-sky-600 py-3 font-semibold text-white transition hover:bg-sky-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                            Proses Pembayaran
                        </button>
                    </form>
                </div>
            </aside>
        </main>
    </div>


@endsection
