@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<h2 class="text-3xl font-bold mb-6">
    Dashboard Admin
</h2>

@if(session('success'))
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
        <p class="text-gray-500">Total Penjualan Hari Ini</p>
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

    <h3 class="text-xl font-bold text-teal-600 mb-4">
        Tambah Produk
    </h3>

    <form action="{{ route('product.store') }}" method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block mb-1">Nama Produk</label>
                <input
                    type="text"
                    name="name"
                    class="w-full border rounded p-2"
                    required>
            </div>

            <div>
                <label class="block mb-1">Kategori</label>

                <select
                    name="category"
                    class="w-full border rounded p-2">

                    <option value="Sembako">Sembako</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                    <option value="Sabun/Sampo">Sabun/Sampo</option>

                </select>
            </div>

            <div>
                <label class="block mb-1">Harga Beli</label>

                <input
                    type="number"
                    name="price_buy"
                    class="w-full border rounded p-2"
                    required>

            </div>

            <div>

                <label class="block mb-1">Harga Jual</label>

                <input
                    type="number"
                    name="price_sell"
                    class="w-full border rounded p-2"
                    required>

            </div>

            <div>

                <label class="block mb-1">Stok</label>

                <input
                    type="number"
                    name="stock"
                    class="w-full border rounded p-2"
                    required>

            </div>

        </div>

        <button
            type="submit"
            class="mt-5 bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded">

            Simpan Produk

        </button>

    </form>

</div>

{{-- Tabel Produk --}}
<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-teal-600 text-white">

            <tr>

                <th class="p-3">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

            <tr class="border-b hover:bg-gray-50">

                <td class="p-3 text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $product->name }}
                </td>

                <td>
                    {{ $product->category }}
                </td>

                <td>
                    Rp {{ number_format($product->price_sell) }}
                </td>

                <td>

                    @if($product->stock < 5)

                        <span class="text-red-600 font-bold">

                            {{ $product->stock }}

                        </span>

                    @else

                        {{ $product->stock }}

                    @endif

                </td>

                <td>

                    <a href="{{ route('product.edit',$product->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                        Edit

                    </a>

                    <form action="{{ route('product.destroy',$product->id) }}"
                        method="POST"
                        class="inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus produk ini?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6" class="text-center p-5">

                    Belum ada data produk.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection