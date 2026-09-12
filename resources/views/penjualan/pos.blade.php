@extends('layouts.app')

@section('title', 'POS')

@section('content')

@include('layouts.navbar')

<div class="container my-4">

    <!-- Notifikasi Error -->
    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                {{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
            </h1>
        </div>
        <div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 shadow-sm px-3">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- =================== PRODUK =================== --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3" style="max-height:70vh; overflow:auto">

                    <!-- Form Pencarian Produk -->
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <div class="input-group">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Cari produk..."
                                    onkeyup="this.form.submit()">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Produk -->
                    @foreach($products as $product)
                    <form method="POST" action="{{ route('itempenjualan.store') }}" class="row g-2 mb-2 align-items-center">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="col-7">
                            <button type="button" class="btn btn-outline-primary w-100 text-start p-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                <div class="d-flex align-items-center gap-2">

                                    {{-- Gambar produk --}}
                                    @if($product->foto)
                                        <img src="{{ asset('storage/'.$product->foto) }}"
                                            alt="Gambar"
                                            class="rounded-3 border object-fit-cover flex-shrink-0"
                                            style="width:45px; height:45px;">
                                    @else
                                        <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center text-muted flex-shrink-0" style="width:45px; height:45px;">
                                            <small class="fs-7">No Image</small>
                                        </div>
                                    @endif

                                    {{-- Nama & Harga --}}
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-dark text-truncate">{{ $product->nama }}</div>
                                        <small class="text-muted">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="col-3">
                            <input
                                type="number"
                                name="quantity"
                                value="1"
                                min="1"
                                class="form-control text-center {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}">
                        </div>

                        <div class="col-2">
                            <button class="btn btn-primary w-100 fw-bold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                +
                            </button>
                        </div>
                    </form>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- =================== KERANJANG =================== --}}
        <div class="col-md-6">
            <div class="card border shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-secondary" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th scope="col" class="ps-3 border-end">Produk</th>
                                <th scope="col" class="border-end">Harga</th>
                                <th scope="col" class="border-end text-center" style="width: 18%;">Qty</th>
                                <th scope="col" class="border-end">Subtotal</th>
                                <th scope="col" class="text-center pe-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sale->itemPenjualan as $item)
                            <tr>
                                <td class="ps-3 fw-semibold text-dark border-end">{{ $item->produk->nama }}</td>
                                <td class="text-muted border-end">Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center fw-semibold border-end">
                                    {{ $item->kuantitas }}
                                </td>
                                <td class="fw-semibold text-success border-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="text-center pe-3">
                                    @can('delete', $item)
                                    <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <p class="mb-0 fs-6 fw-semibold text-secondary">Keranjang kosong</p>
                                    <small>Belum ada produk yang ditambahkan ke keranjang.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Keranjang & Checkout -->
                <div class="card-footer bg-light border-top p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold text-muted">Total Pembayaran:</span>
                        <strong class="fs-4 text-success">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</strong>
                    </div>

                    <form method="POST"
                          action="{{ route('penjualan.update', $sale->id) }}"
                          onsubmit="return confirm('Yakin ingin checkout?')"
                          id="checkout_form"
                          data-total-pembayaran="{{ $sale->itemPenjualan->sum('subtotal') }}"
                          data-sale-id="{{ $sale->id }}">
                        @csrf
                        @method('PUT')

                        <select name="payment_method" id="payment_method" class="form-select mb-3" onchange="togglePaymentInput()">
                            <option value="">Pilih Pembayaran</option>
                            <option value="CASH" {{ old('payment_method') === 'CASH' ? 'selected' : '' }}>Cash</option>
                            <option value="QRIS" {{ old('payment_method') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>

                        <!-- Input Cash -->
                        <div id="cash_input_wrapper" class="mb-3 d-none">
                            <label class="form-label small text-muted mb-1">Uang Diterima</label>
                            <input type="number" name="uang_dibayar" id="uang_dibayar" min="0" class="form-control"
                                   placeholder="Masukkan jumlah uang tunai" value="{{ old('uang_dibayar') }}"
                                   oninput="hitungKembalian()">
                            <div class="d-flex justify-content-between mt-2 small">
                                <span class="text-muted">Kembalian</span>
                                <span id="kembalian_preview" class="fw-bold text-success">Rp 0</span>
                            </div>
                        </div>

          <div id="qris_wrapper" class="mb-3 text-center p-3 border rounded bg-white d-none">
                <p class="small text-muted mb-2 fw-semibold">Scan QR DANA untuk Pembayaran</p>
                
                <img src="{{ asset('asset/img/barcode.jpeg') }}" 
                    alt="QR DANA" 
                    class="img-fluid rounded mb-2 border p-1" 
                    style="max-width: 120px;">

                <div class="text-center small text-secondary">
                    Total Pembayaran: <br>
                    <span class="fw-bold text-dark fs-6">Rp {{ number_format($sale->itemPenjualan->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
            </div>
                        <button class="btn btn-success w-100 fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const checkoutForm = document.getElementById('checkout_form');
    const totalPembayaran = parseInt(checkoutForm.dataset.totalPembayaran);
    const saleId = parseInt(checkoutForm.dataset.saleId);
    let qrGenerated = false;

    function togglePaymentInput() {
        const method = document.getElementById('payment_method').value;
        const cashWrapper = document.getElementById('cash_input_wrapper');
        const qrisWrapper = document.getElementById('qris_wrapper');

        // Toggle Cash Input
        cashWrapper.classList.toggle('d-none', method !== 'CASH');
        if (method !== 'CASH') document.getElementById('uang_dibayar').value = '';

        // Toggle QRIS Display
        qrisWrapper.classList.toggle('d-none', method !== 'QRIS');

        if (method === 'QRIS' && !qrGenerated) {
            generateBarcode();
            qrGenerated = true;
        }

        hitungKembalian();
    }

    function generateBarcode() {
        const isiQR = `QRIS-DEMO|Transaksi:${saleId}|Total:Rp${totalPembayaran}`;

        new QRCode(document.getElementById('qrcode_barcode'), {
            text: isiQR,
            width: 140,
            height: 140,
            colorDark: '#000000',
            colorLight: '#ffffff'
        });
    }

    function hitungKembalian() {
        const bayar = parseInt(document.getElementById('uang_dibayar').value) || 0;
        const kembalian = bayar - totalPembayaran;
        const el = document.getElementById('kembalian_preview');
        el.textContent = 'Rp ' + Math.max(kembalian, 0).toLocaleString('id-ID');
        el.classList.toggle('text-danger', kembalian < 0);
        el.classList.toggle('text-success', kembalian >= 0);
    }

    document.addEventListener('DOMContentLoaded', togglePaymentInput);
</script>

@endsection