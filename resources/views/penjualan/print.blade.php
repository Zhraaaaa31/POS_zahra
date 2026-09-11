<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan #{{ $sale->id }}</title>
    <style>
        body { font-family: monospace; width: 300px; margin: auto; padding: 10px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 0; }
    </style>
</head>
<body onload="setTimeout(() => window.print(), 300)">
    <div class="text-center">
        <h2>STRUK PENJUALAN</h2>
        <p>No. Transaksi: {{ $sale->id }}</p>
        <p>Tanggal: {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="line"></div>

    <table>
        @foreach($sale->itemPenjualan as $item)
        <tr>
            <td colspan="2"><strong>{{ $item->produk->nama }}</strong></td>
        </tr>
        <tr>
            <td>{{ $item->kuantitas }} x Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td><strong>Total:</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Metode Bayar:</td>
            <td class="text-right">{{ $sale->metode_pembayaran ?? '-' }}</td>
        </tr>

        @if($sale->metode_pembayaran === 'CASH' && !is_null($sale->uang_dibayar))
        <tr>
            <td>Uang Diberikan:</td>
            <td class="text-right">Rp {{ number_format($sale->uang_dibayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Kembalian:</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($sale->kembalian, 0, ',', '.') }}</strong></td>
        </tr>
        @endif

        @if($sale->metode_pembayaran === 'QRIS')
        <tr>
            <td>Dibayar via:</td>
            <td class="text-right"><strong>QRIS</strong></td>
        </tr>
        <tr>
            <td>Total yang Dibayar:</td>
            <td class="text-right"><strong>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</strong></td>
        </tr>
        @endif
    </table>

    <div class="line"></div>

   @if($sale->metode_pembayaran === 'QRIS')
<div class="text-center" style="margin: 10px 0;">
    <div id="qrcode_struk" style="display: inline-block;"></div>
</div>
<style>
    #qrcode_struk table {
        width: auto !important;
        margin: 0 auto !important;
    }
    #qrcode_struk td, #qrcode_struk th {
        padding: 0 !important;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById('qrcode_struk'), {
        text: `QRIS-DEMO|Transaksi:{{ $sale->id }}|Total:Rp{{ $sale->total_pembayaran }}`,
        width: 90,
        height: 90
    });
</script>
@endif
    <p class="text-center">Terima Kasih!</p>
</body>
</html>