<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->get();
        $todaySales = Order::whereDate('created_at', today())
            ->sum('total_price');
        $totalStock = Product::sum('stock');

        return view('admin.dashboard', compact(
            'products',
            'todaySales',
            'totalStock'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'image' => $imageName,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'stock' => $request->stock
        ]);
        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageName = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(
                public_path('images/products'),
                $imageName
            );
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'image' => $imageName,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'stock' => $request->stock
        ]);
        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }

        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function history()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.history', compact('orders'));
    }

    public function historyDetail($id)
    {
        $order = Order::with('details.product', 'user')
            ->findOrFail($id);

        return view('admin.history-detail', compact('order'));
    }

    public function destroyHistory($id)
    {
        $order = Order::findOrFail($id);
        $order->details()->delete();
        $order->delete();
        return redirect()->route('admin.history')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
