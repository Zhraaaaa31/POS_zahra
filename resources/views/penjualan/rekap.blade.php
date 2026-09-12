<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penjualan Mingguan</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receipt-container {
            width: 350px;
            background-color: #ffffff;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .action-buttons {
            width: 380px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff;
                padding: 0;
                display: block;
            }
            .receipt-container {
                box-shadow: none;
                padding: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Navigasi (Hanya Muncul di Monitor) -->
    <div class="action-buttons no-print">
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Cetak Rekap Mingguan
        </button>
    </div>

    <!-- Tampilan Struk Rekap Mingguan -->
    <div class="receipt-container">
        <div style="text-align: center;">
            <strong>TOKO FASHION</strong><br>
            REKAP PENJUALAN MINGGUAN<br>
            <small style="font-size: 10px;">
                PERIODE: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
            </small>
        </div>
        <br>
        TANGGAL CETAK : {{ date('d M Y H:i') }}<br>
        TOTAL TRANSAKSI: {{ $totalTransaksi }} Transaksi<br>
        ========================================<br>

        <!-- Daftar Ringkas Transaksi -->
        <strong>DETAIL TRANSAKSI MINGGU INI</strong><br>
        ----------------------------------------<br>
        @forelse($penjualan as $p)
            <div style="display: flex; justify-content: space-between;">
                <span>#{{ $p->id }} | {{ $p->created_at->format('d/m H:i') }} ({{ $p->metode_pembayaran }})</span>
                <span>Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</span>
            </div>
        @empty
            <div style="text-align: center; color: #6c757d;">Belum ada transaksi minggu ini</div>
        @endforelse

        ========================================<br>
        <strong>RINGKASAN PEMBAYARAN</strong><br>
        ----------------------------------------<br>
        <div style="display: flex; justify-content: space-between;">
            <span>TOTAL CASH</span>
            <span>RP {{ number_format($totalCash, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>TOTAL QRIS</span>
            <span>RP {{ number_format($totalQris, 0, ',', '.') }}</span>
        </div>
        ----------------------------------------<br>
        <div style="display: flex; justify-content: space-between; font-weight: bold;">
            <span>TOTAL OMSET</span>
            <span>RP {{ number_format($totalOmset, 0, ',', '.') }}</span>
        </div>
        ========================================<br><br>

        <div style="text-align: center;">
            *** LAPORAN REKAP MINGGUAN ***<br>
            POWERED BY POS SYSTEM
        </div>
    </div>

</body>
</html>