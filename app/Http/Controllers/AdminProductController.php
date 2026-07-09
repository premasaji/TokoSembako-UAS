<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class AdminProductController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $products = Product::all();

        $todaySales = Order::whereDate('created_at', today())
            ->sum('total_price');

        $totalStock = Product::sum('stock');

        return view('admin.dashboard', compact(
            'products',
            'todaySales',
            'totalStock'
        ));
    }

    // Simpan Produk
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form Edit
    public function edit(Product $product)
    {
        $products = Product::all();

        $todaySales = Order::whereDate('created_at', today())
            ->sum('total_price');

        $totalStock = Product::sum('stock');

        return view('admin.dashboard', compact(
            'product',
            'products',
            'todaySales',
            'totalStock'
        ));
    }

    // Update Produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil diubah.');
    }

    // Hapus Produk
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()
            ->with('success', 'Produk berhasil dihapus.');
    }
}