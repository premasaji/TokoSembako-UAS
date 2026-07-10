@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')

    <h2 class="text-3xl font-bold mb-6">Edit Produk</h2>

    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block mb-2">Kategori</label>
                    <select name="category" class="w-full border rounded-lg p-3">
                        <option value="Sembako" {{ $product->category == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                        <option value="Minuman" {{ $product->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Camilan" {{ $product->category == 'Camilan' ? 'selected' : '' }}>Camilan</option>
                        <option value="Sabun/Sampo" {{ $product->category == 'Sabun/Sampo' ? 'selected' : '' }}>Sabun/Sampo
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2">Harga Beli</label>
                    <input type="number" name="price_buy" value="{{ old('price_buy', $product->price_buy) }}"
                        class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block mb-2">Harga Jual</label>
                    <input type="number" name="price_sell" value="{{ old('price_sell', $product->price_sell) }}"
                        class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block mb-2">Gambar Produk</label>
                    <input type="file" name="image" class="w-full border rounded-lg p-3">
                </div>

            </div>

            @if ($product->image)
                <div class="mt-6">
                    <p class="font-semibold mb-2">Gambar Saat Ini</p>
                    <img src="{{ asset('images/products/' . $product->image) }}"
                        class="w-40 h-40 object-cover rounded shadow">
                </div>
            @endif

            <div class="mt-8 flex gap-3">
                <button class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg">
                    Update Produk
                </button>

                <a href="{{ route('admin.dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                    Kembali
                </a>
            </div>

        </form>

    </div>

@endsection
