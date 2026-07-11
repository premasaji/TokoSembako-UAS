@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold ">
            Riwayat Transaksi
        </h2>
        <a href="{{ route('cashier.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg">
            ← Kembali ke Beranda
        </a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-teal-600 text-white">
                <tr>
                    <th class="p-3">No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Total Barang</th>
                    <th>Total Bayar</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $order->invoice_number }}
                        </td>
                        <td>
                            {{ $order->created_at->format('d-m-Y H:i') }}
                        </td>
                        <td>
                            {{ $order->total_items }}
                        </td>
                        <td>
                            Rp {{ number_format($order->total_price) }}
                        </td>
                        <td>
                            {{ $order->payment_method }}
                        </td>
                        <td>
                            <a href="{{ route('history.show', $order->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6">
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $orders->links() }}
    </div>
@endsection
