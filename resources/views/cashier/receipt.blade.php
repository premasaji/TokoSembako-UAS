<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pembayaran</title>
<script>
window.onload = function(){
    window.print();
}
</script>
<script>
window.onafterprint = function(){
    window.location="{{ route('cashier.index') }}";
}
</script>
@vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
    <div class="text-center border-b pb-4">
        <h1 class="text-2xl font-bold">
            TOKO KELONTONG
        </h1>
        <p class="text-gray-500">
            Jl. Contoh No.1
        </p>
        <p class="text-gray-500">
            Telp. 0812xxxxxxxx
        </p>
    </div>

    <div class="py-4 text-sm">
        <div class="flex justify-between">
            <span>Invoice</span>
            <span>{{ $order->invoice_number }}</span>
        </div>

        <div class="flex justify-between">
            <span>Tanggal</span>
            <span>{{ $order->created_at }}</span>
        </div>

        <div class="flex justify-between">
            <span>Kasir</span>
            <span>{{ $order->user->name }}</span>
        </div>
    </div>

    <hr>

    <table class="w-full text-sm mt-4">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->details as $item)
            <tr class="border-b">
                <td class="py-2">
                    {{ $item->product->name }}
                </td>
                <td class="text-center">
                    {{ $item->quantity }}
                </td>
                <td class="text-right">
                    {{ number_format($item->price_sell) }}
                </td>
                <td class="text-right">
                    {{ number_format($item->subtotal) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-5 space-y-2">
        <div class="flex justify-between">
            <span>Total Barang</span>
            <span>{{ $order->total_items }}</span>
        </div>

        <div class="flex justify-between">
            <span>Total Bayar</span>
            <span>Rp {{ number_format($order->total_price) }}</span>
        </div>

        <div class="flex justify-between">
            <span>Uang Bayar</span>
            <span>Rp {{ number_format($order->money_received) }}</span>
        </div>

        <div class="flex justify-between font-bold text-lg">
            <span>Kembalian</span>
            <span>Rp {{ number_format($order->money_change) }}</span>
        </div>
    </div>

    <div class="text-center mt-8 border-t pt-4">
        <p>Terima Kasih Telah Berbelanja</p>
        <p>Semoga Hari Anda Menyenangkan 😊</p>
    </div>

</div>
</body>
</html>