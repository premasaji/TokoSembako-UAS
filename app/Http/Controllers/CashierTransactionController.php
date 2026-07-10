<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashierTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->orderBy('name')->get();
        return view('cashier.index', compact('products'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $product->stock) {
                $cart[$id]['qty']++;
            }
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price_sell,
                'qty' => 1
            ];
        }
        session()->put('cart', $cart);
        return back();
    }

    public function plus($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $product = Product::find($id);
            if ($cart[$id]['qty'] < $product->stock) {
                $cart[$id]['qty']++;
            }
        }
        session()->put('cart', $cart);
        return back();
    }

    public function minus($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty']--;
            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }
        session()->put('cart', $cart);
        return back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back();
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $totalItems = 0;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalItems += $item['qty'];
            $totalPrice += $item['qty'] * $item['price'];
        }

        $request->validate([
            'money_paid' => 'required|numeric|min:' . $totalPrice
        ]);

        DB::beginTransaction();

        try {
            $invoice = 'INV-' . now()->format('YmdHis');

            $order = Order::create([
                'user_id' => auth::id(),
                'invoice_number' => $invoice,
                'payment_method' => $request->payment_method,
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
                'money_received' => $request->money_paid,
                'money_change' => $request->money_paid - $totalPrice
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price_sell' => $product->price_sell,
                    'subtotal' => $item['qty'] * $product->price_sell,
                ]);

                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            session()->forget('cart');
            return redirect()->route('cashier.index')
                ->with('success', 'Transaksi berhasil.');
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function receipt($id)
    {
        $order = Order::with('details.product')->findOrFail($id);

        return view('cashier.receipt', compact('order'));
    }
}
