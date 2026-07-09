@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-2xl font-bold text-teal-600 mb-6">

            Edit Produk

        </h2>

        <form action="{{ route('product.update', $product->id) }}" method="POST">

            @csrf
            @method('PUT')

            <label>Nama Produk</label>

            <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded p-2 mb-4">

            <label>Kategori</label>

            <select name="category" class="w-full border rounded p-2 mb-4">

                <option {{ $product->category == 'Sembako' ? 'selected' : '' }}>

                    Sembako

                </option>

                <option {{ $product->category == 'Minuman' ? 'selected' : '' }}>

                    Minuman

                </option>

                <option {{ $product->category == 'Camilan' ? 'selected' : '' }}>

                    Camilan

                </option>

                <option {{ $product->category == 'Sabun/Sampo' ? 'selected' : '' }}>

                    Sabun/Sampo

                </option>

            </select>

            <label>Harga Beli</label>

            <input type="number" name="price_buy" value="{{ $product->price_buy }}" class="w-full border rounded p-2 mb-4">

            <label>Harga Jual</label>

            <input type="number" name="price_sell" value="{{ $product->price_sell }}"
                class="w-full border rounded p-2 mb-4">

            <label>Stok</label>

            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded p-2 mb-4">

            <button class="bg-teal-600 text-white px-6 py-2 rounded">

                Update Produk

            </button>

        </form>

    </div>

@endsection
