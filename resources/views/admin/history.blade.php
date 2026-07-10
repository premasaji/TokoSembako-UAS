@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')

    <div class="flex gap-6">
        {{-- Sidebar --}}
        <aside class="w-60 bg-teal-600 text-white rounded-xl p-5 h-fit sticky top-5">
            <h2 class="text-2xl font-bold">
                TOKO
                <br>
                SEDULURAN
            </h2>
            <p class="text-sm text-teal-100 mt-2 mb-8">
                Administrator
            </p>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block hover:bg-teal-700 px-4 py-3 rounded-lg">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.history') }}"
                        class="block bg-white text-teal-700 font-semibold px-4 py-3 rounded-lg">
                        🧾 Riwayat Transaksi
                    </a>
                </li>
                <li class="pt-10">
                    <a href="{{ route('logout') }}"
                        class="block text-center bg-red-500 hover:bg-red-600 px-4 py-3 rounded-lg">
                        Logout
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Content --}}
        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-6">
                Riwayat Transaksi
            </h2>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-teal-600 text-white">
                        <tr>
                            <th class="p-3">No</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
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
                                    {{ $order->user->name }}
                                </td>
                                <td>
                                    Rp {{ number_format($order->total_price) }}
                                </td>
                                <td>
                                    {{ $order->payment_method }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.history.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6">
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
        </div>
    </div>
@endsection
