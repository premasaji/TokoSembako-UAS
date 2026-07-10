@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')

    <h2 class="text-3xl font-bold mb-6">
        Detail Transaksi
    </h2>
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <p><b>Invoice :</b> {{ $order->invoice_number }}</p>
        <p><b>Tanggal :</b> {{ $order->created_at->format('d-m-Y H:i') }}</p>
        <p><b>Total :</b> Rp {{ number_format($order->total_price) }}</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-teal-600 text-white">
                <tr>
                    <th class="p-3">Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details as $detail)
                    <tr class="border-b">
                        <td class="p-3">
                            {{ $detail->product->name }}
                        </td>
                        <td>
                            {{ $detail->quantity }}
                        </td>
                        <td>
                            Rp {{ number_format($detail->price_sell) }}
                        </td>
                        <td>
                            Rp {{ number_format($detail->subtotal) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('history.index') }}"
        class="inline-block mt-5 bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded">
        Kembali
    </a>
@endsection
