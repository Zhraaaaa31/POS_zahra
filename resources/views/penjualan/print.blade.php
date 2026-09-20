<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan #{{ $penjualan->id }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background-color: #f8f9fa;
            margin: 0;
            padding: 15px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Navigasi Tombol di Atas */
        .action-buttons {
            width: 100%;
            max-width: 320px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            transition: background-color 0.2s ease;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
        }

        /* Container Struk Kasir */
        .receipt-container {
            width: 100%;
            max-width: 320px;
            background-color: #ffffff;
            padding: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 6px;
            word-wrap: break-word;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        /* CSS Khusus Saat Cetak ke Kertas (Thermal Printer) */
        @media print {
            @page {
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
                display: block;
            }
            .receipt-container {
                box-shadow: none;
                padding: 5px;
                width: 100%;
                max-width: 100%;
                border-radius: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Navigasi di Atas Struk -->
    <div class="action-buttons no-print">
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Cetak
        </button>
    </div>

    <!-- Tampilan Struk -->
    <div class="receipt-container">
        <div class="text-center">
            <strong>TOKO FASHION</strong><br>
            JL. JALAN-JALAN<br>
            TASIKMALAYA
        </div>
        
        <div class="divider"></div>

        <div>
            WAKTU : {{ $penjualan->created_at->format('d M Y H:i') }}<br>
            KASIR : {{ strtoupper($penjualan->user->name ?? 'ADMIN') }}<br>
            NO.   : #{{ $penjualan->id }}
        </div>

        <div class="divider"></div>

        @foreach($penjualan->itemPenjualan as $item)
            <div style="margin-bottom: 4px;">
                <div class="text-uppercase"><strong>{{ $item->produk->nama ?? 'PRODUK' }}</strong></div>
                <div class="item-row">
                    <span>{{ number_format($item->harga_satuan, 0, ',', '.') }} x{{ $item->kuantitas }}</span>
                    <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="divider"></div>

        <div class="item-row">
            <span>TOTAL</span>
            <strong>RP {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</strong>
        </div>
        <div class="item-row">
            <span>{{ strtoupper($penjualan->metode_pembayaran) }}</span>
            <span>RP {{ number_format($penjualan->uang_dibayar ?? $penjualan->total_pembayaran, 0, ',', '.') }}</span>
        </div>
        
        @if($penjualan->metode_pembayaran === 'CASH')
        <div class="item-row">
            <span>KEMBALIAN</span>
            <span>RP {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="divider"></div>

        <div>JUMLAH ITEM: {{ $penjualan->itemPenjualan->sum('kuantitas') }}</div>

        <br>

        <div class="text-center">
            TERIMAKASIH ATAS KUNJUNGAN NYA<br>
            BARANG YANG SUDAH DIBELI TIDAK<br>
            DAPAT DIKEMBALIKAN<br><br>
            POWERED BY POS SYSTEM
        </div>
    </div>

</body>
</html>