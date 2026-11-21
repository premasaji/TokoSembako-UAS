@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('content')

    <style>
        @media print {
            .app-navbar,
            .admin-sidebar,
            .no-print {
                display: none !important;
            }

            main {
                padding: 0 !important;
            }

            .report-content {
                padding-left: 0 !important;
            }

            .report-grid {
                display: block !important;
            }

            .report-card {
                display: none !important;
            }

            body[data-print-report="daily"] #daily-report,
            body[data-print-report="monthly"] #monthly-report {
                display: block !important;
                width: 100%;
                box-shadow: none !important;
                border: 1px solid #cbd5e1;
                break-inside: avoid;
            }
        }
    </style>

    <div class="flex px-6 pb-6 gap-6">
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
                    <a href="{{ route('admin.history') }}" class="block hover:bg-sky-600 px-4 py-3 rounded-lg">
                        🧾 Riwayat Transaksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}"
                        class="block bg-sky-100 text-sky-800 font-semibold px-4 py-3 rounded-lg">
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

        <section class="report-content flex-1 pl-64">
            <div class="no-print mb-6">
                <h2 class="text-3xl font-bold">Laporan Penjualan</h2>
                <p class="text-gray-500">Ringkasan transaksi harian dan bulanan</p>
            </div>

            <div class="report-grid grid grid-cols-1 lg:grid-cols-2 gap-6">
                <article id="daily-report" class="report-card bg-white rounded-lg shadow p-6">
                    <p class="text-sm font-semibold uppercase tracking-wide text-sky-700">Laporan Harian</p>
                    <h3 class="text-2xl font-bold mt-2 mb-6">
                        {{ $currentTime->copy()->locale('id')->translatedFormat('d F Y') }}
                    </h3>
                    <dl class="space-y-4">
                        <div class="flex justify-between border-b pb-3">
                            <dt class="text-gray-600">Total Penjualan</dt>
                            <dd class="font-bold text-sky-800">Rp {{ number_format($dailyReport->total_sales) }}</dd>
                        </div>
                        <div class="flex justify-between border-b pb-3">
                            <dt class="text-gray-600">Jumlah Transaksi</dt>
                            <dd class="font-semibold">{{ number_format($dailyReport->transaction_count) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Barang Terjual</dt>
                            <dd class="font-semibold">{{ number_format($dailyReport->total_items) }}</dd>
                        </div>
                    </dl>
                    <button type="button" onclick="printReport('daily')"
                        class="no-print mt-6 bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg">
                        Cetak Laporan Harian
                    </button>
                </article>

                <article id="monthly-report" class="report-card bg-white rounded-lg shadow p-6">
                    <p class="text-sm font-semibold uppercase tracking-wide text-sky-700">Laporan Bulanan</p>
                    <h3 class="text-2xl font-bold mt-2 mb-6">
                        {{ $currentTime->copy()->locale('id')->translatedFormat('F Y') }}
                    </h3>
                    <dl class="space-y-4">
                        <div class="flex justify-between border-b pb-3">
                            <dt class="text-gray-600">Total Penjualan</dt>
                            <dd class="font-bold text-sky-800">Rp {{ number_format($monthlyReport->total_sales) }}</dd>
                        </div>
                        <div class="flex justify-between border-b pb-3">
                            <dt class="text-gray-600">Jumlah Transaksi</dt>
                            <dd class="font-semibold">{{ number_format($monthlyReport->transaction_count) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Barang Terjual</dt>
                            <dd class="font-semibold">{{ number_format($monthlyReport->total_items) }}</dd>
                        </div>
                    </dl>
                    <button type="button" onclick="printReport('monthly')"
                        class="no-print mt-6 bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg">
                        Cetak Laporan Bulanan
                    </button>
                </article>
            </div>
        </section>
    </div>

    <script>
        function printReport(period) {
            document.body.dataset.printReport = period;
            window.addEventListener('afterprint', () => {
                delete document.body.dataset.printReport;
            }, { once: true });
            window.print();
        }
    </script>
@endsection
