@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')

    <div class="flex px-6 pb-6 gap-6">
        {{-- Sidebar --}}
        <aside class="admin-sidebar fixed top-[68px] left-0 w-60 h-[calc(100vh-68px)] bg-sky-700 text-white p-5 overflow-y-auto">
            <h2 class="text-2xl font-bold">
                TOKO
                <br>
                SEDULURAN
            </h2>
            <p class="text-sm text-sky-100 mt-2 mb-8">
                Administrator
            </p>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block hover:bg-sky-600 px-4 py-3 rounded-lg">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.history') }}"
                        class="block bg-sky-100 text-sky-800 font-semibold px-4 py-3 rounded-lg">
                        🧾 Riwayat Transaksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}" class="block hover:bg-sky-600 px-4 py-3 rounded-lg">
                        📈 Laporan
                    </a>
                </li>
                <li class="pt-10">
                    <a href="{{ route('logout') }}"
                        class="block text-center bg-sky-600 hover:bg-sky-500 px-4 py-3 rounded-lg">
                        Logout
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Content --}}
        <div class="flex-1 pl-64">
            <h2 class="text-3xl font-bold mb-6">
                Riwayat Transaksi
            </h2>
            @if (session('success'))
                <div class="bg-sky-50 border border-sky-200 text-sky-800 px-4 py-3 rounded mb-5">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-sky-700 text-white">
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
                            <tr class="border-b hover:bg-sky-50">
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
