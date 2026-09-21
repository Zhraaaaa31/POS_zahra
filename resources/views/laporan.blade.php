@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@push('styles')
<style>
    .report-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .filter-section {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .form-group-inline {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    /* Summary Cards Grid */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .summary-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid #0d6efd;
    }

    .summary-box.cash { border-left-color: #198754; }
    .summary-box.qris { border-left-color: #ffc107; }
    .summary-box.total { border-left-color: #0d6efd; }

    .summary-title {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 18px;
        font-weight: bold;
        color: #212529;
    }

    /* Table Customizations */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .report-table th, 
    .report-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    .report-table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-cash { background-color: #d1e7dd; color: #0f5132; }
    .badge-qris { background-color: #fff3cd; color: #664d03; }

    .report-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }

    .report-header h2 { margin: 0 0 5px 0; color: #212529; }
    .report-header p { margin: 0; color: #6c757d; font-size: 13px; }

    @media print {
        .no-print { display: none !important; }
        body { background-color: #ffffff; }
        .card { box-shadow: none !important; border: none !important; padding: 0 !important; }
    }
</style>
@endpush

@section('content')

    <!-- Action Header & Filter (Hanya Muncul di Monitor) -->
    <div class="header-actions no-print">
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            &larr; Kembali
        </a>

        <div class="filter-section">
            <form action="{{ route('laporan') }}" method="GET" class="form-group-inline">
                <label for="tanggal" style="font-weight: bold;">Tanggal Rekap:</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal', $startDate->format('Y-m-d')) }}" class="form-control">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <button onclick="window.print()" class="btn btn-success">
                🖨️ Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Main Card Output -->
    <div class="card">
        
        <!-- Judul Laporan -->
        <div class="report-header">
            <h2>TOKO FASHION</h2>
            <h4 style="margin: 5px 0; color: #495057;">LAPORAN REKAP PENJUALAN HARIAN</h4>
            <p>Periode Tanggal: <strong>{{ $startDate->format('d/m/Y') }}</strong> | Dicetak pada: {{ date('d M Y H:i') }}</p>
        </div>

        <!-- Ringkasan/Summary Box -->
        <div class="summary-grid">
            <div class="summary-box total">
                <div class="summary-title">Total Transaksi</div>
                <div class="summary-value">{{ $totalTransaksi }} Transaksi</div>
            </div>
            <div class="summary-box cash">
                <div class="summary-title">Total Cash</div>
                <div class="summary-value">Rp {{ number_format($totalCash, 0, ',', '.') }}</div>
            </div>
            <div class="summary-box qris">
                <div class="summary-title">Total QRIS</div>
                <div class="summary-value">Rp {{ number_format($totalQris, 0, ',', '.') }}</div>
            </div>
            <div class="summary-box total">
                <div class="summary-title">Total Omset</div>
                <div class="summary-value">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Tabel Detail Transaksi -->
        <h3 style="margin-bottom: 10px; color: #333;">Detail Transaksi</h3>
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">No. ID</th>
                        <th style="width: 120px;">Waktu</th>
                        <th style="width: 150px;" class="text-center">Metode Pembayaran</th>
                        <th class="text-right">Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualan as $p)
                        <tr>
                            <td>#{{ $p->id }}</td>
                            <td>{{ $p->created_at->format('H:i') }} WIB</td>
                            <td class="text-center">
                                @if(strtolower($p->metode_pembayaran) == 'cash')
                                    <span class="badge badge-cash">CASH</span>
                                @else
                                    <span class="badge badge-qris">QRIS</span>
                                @endif
                            </td>
                            <td class="text-right">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center" style="color: #6c757d; padding: 20px;">
                                Belum ada transaksi pada tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection