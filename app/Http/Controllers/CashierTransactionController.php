<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierTransactionController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('cashier.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {

            $invoice = 'INV-' . date('YmdHis');

            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => $invoice,
                'total_items' => count($request->products),
                'total_price' => $request->total_price,
                'money_received' => $request->money_received,
                'money_change' => $request->money_change,
            ]);

            foreach ($request->products as $item) {

                $product = Product::find($item['id']);

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

            return redirect()->route('cashier.receipt', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());

        }
    }

    public function receipt(Order $order)
    {
        $order->load('details.product');

        return view('cashier.receipt', compact('order'));
    }
}