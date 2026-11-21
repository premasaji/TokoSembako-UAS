<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $order->invoice_number }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body {
                background: white !important;
            }

            .receipt-actions {
                display: none !important;
            }

            .receipt {
                box-shadow: none !important;
                margin: 0 auto !important;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-sky-50 px-4 py-8 text-slate-800">
    <main class="mx-auto max-w-lg">
        <div class="receipt-actions mb-4 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('cashier.index') }}" class="font-medium text-sky-700 hover:text-sky-900">
                ← Transaksi baru
            </a>
            <button type="button" onclick="window.print()"
                class="rounded-lg bg-sky-600 px-5 py-2.5 font-semibold text-white hover:bg-sky-700">
                Cetak ulang struk
            </button>
        </div>

        <section class="receipt rounded-xl bg-white p-6 shadow-lg">
            <div class="mb-5 rounded-lg bg-sky-50 px-4 py-3 text-center text-sky-800">
                <p class="font-semibold">Pembayaran berhasil</p>
                <p class="mt-1 text-sm">Transaksi telah tersimpan</p>
            </div>

            <header class="border-b border-dashed border-slate-300 pb-5 text-center">
                <h1 class="text-2xl font-bold tracking-wide">TOKO SEDULURAN</h1>
                <p class="mt-1 text-sm text-slate-500">Struk pembayaran</p>
            </header>

            <dl class="space-y-2 py-4 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Invoice</dt>
                    <dd class="text-right font-semibold">{{ $order->invoice_number }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Tanggal</dt>
                    <dd class="text-right">{{ $order->created_at->format('d-m-Y H:i') }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Kasir</dt>
                    <dd class="text-right">{{ $order->user->name }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Metode pembayaran</dt>
                    <dd class="text-right">{{ $order->payment_method }}</dd>
                </div>
            </dl>

            <div class="border-y border-dashed border-slate-300 py-4">
                @foreach ($order->details as $item)
                    <div class="mb-4 last:mb-0">
                        <div class="font-medium">{{ $item->product->name }}</div>
                        <div class="mt-1 flex justify-between gap-4 text-sm text-slate-500">
                            <span>{{ $item->quantity }} x Rp {{ number_format($item->price_sell) }}</span>
                            <span class="font-medium text-slate-700">Rp {{ number_format($item->subtotal) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <dl class="space-y-2 py-4 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Jumlah barang</dt>
                    <dd>{{ $order->total_items }}</dd>
                </div>
                <div class="flex justify-between text-base font-bold">
                    <dt>Total pembayaran</dt>
                    <dd>Rp {{ number_format($order->total_price) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Uang diterima</dt>
                    <dd>Rp {{ number_format($order->money_received) }}</dd>
                </div>
                <div class="flex justify-between font-semibold text-sky-800">
                    <dt>Kembalian</dt>
                    <dd>Rp {{ number_format($order->money_change) }}</dd>
                </div>
            </dl>

            <footer class="border-t border-dashed border-slate-300 pt-4 text-center text-sm text-slate-500">
                <p class="font-medium text-slate-700">Terima kasih telah berbelanja</p>
                <p class="mt-1">Simpan struk ini sebagai bukti pembayaran.</p>
            </footer>
        </section>
    </main>

    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>

</html>
