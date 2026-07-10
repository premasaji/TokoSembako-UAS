<?php

namespace App\Http\Controllers;

use App\Models\Order;

class HistoryController extends Controller
{
    public function index()
    {
        $orders=Order::latest()->paginate(10);
        return view('history.index',compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('details.product');
        return view('history.show',compact('order'));
    }
}