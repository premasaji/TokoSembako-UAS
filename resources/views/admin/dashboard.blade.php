@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

    <div class="flex px-6 pb-6 gap-6">
        {{-- Sidebar --}}
        <aside class="fixed top-20 left-0 w-60 h-[calc(100vh-80px)] bg-teal-600 text-white p-5 overflow-y-auto">
            <h2 class="text-2xl font-bold">
                TOKO
                <br>
                SEDULURAN
            </h2>
            <p class="text-sm text-teal-100 mt-2 mb-8">
                Administrator
            </p>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="block bg-white text-teal-700 font-semibold px-4 py-3 rounded-lg">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.history') }}" class="block hover:bg-teal-700 px-4 py-3 rounded-lg">
                        🧾 Riwayat Transaksi
                    </a>
                </li>
                <li class="pt-10">
                    <a href="{{ route('logout') }}"
                        class="block text-center bg-red-500 hover:bg-red-600 px-4 py-3 rounded-lg">
                        Logout
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Content --}}
        <div class="flex-1 pl-64">
            <h2 class="text-3xl font-bold mb-6">
                Dashboard Admin
            </h2>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500">Total Produk</p>
                    <h1 class="text-4xl font-bold text-teal-600">
                        {{ $products->count() }}
                    </h1>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500">Penjualan Hari Ini</p>
                    <h1 class="text-4xl font-bold text-teal-600">
                        Rp {{ number_format($todaySales) }}
                    </h1>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500">Total Stok</p>
                    <h1 class="text-4xl font-bold text-teal-600">
                        {{ $totalStock }}
                    </h1>
                </div>
            </div>

            {{-- Form Tambah Produk --}}
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="text-xl font-bold text-teal-600 mb-5">
                    Tambah Produk
                </h3>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Nama Produk</label>
                            <input type="text" name="name" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block mb-1">Kategori</label>
                            <select name="category" class="w-full border rounded-lg p-2">
                                <option value="Sembako">Sembako</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Camilan">Camilan</option>
                                <option value="Sabun/Sampo">Sabun/Sampo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1">Gambar Produk</label>
                            <input type="file" name="image" accept="image/*" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block mb-1">Harga Beli</label>
                            <input type="number" name="price_buy" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block mb-1">Harga Jual</label>
                            <input type="number" name="price_sell" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block mb-1">Stok</label>
                            <input type="number" name="stock" class="w-full border rounded-lg p-2" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-5 bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg">
                        Simpan Produk
                    </button>
                </form>
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-teal-600 text-white">
                        <tr>
                            <th class="p-3 w-16">No</th>
                            <th class="w-24">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th class="w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-2 text-center">
                                    @if ($product->image)
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                            class="w-16 h-16 object-cover rounded mx-auto">
                                    @else
                                        <img src="{{ asset('images/products/no-image.png') }}"
                                            class="w-16 h-16 object-cover rounded mx-auto">
                                    @endif
                                </td>
                                <td class="font-medium">
                                    {{ $product->name }}
                                </td>
                                <td>
                                    <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full text-xs">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="font-semibold text-teal-600">
                                    Rp {{ number_format($product->price_sell) }}
                                </td>
                                <td>
                                    @if ($product->stock < 5)
                                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded font-semibold">
                                            {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                            {{ $product->stock }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
