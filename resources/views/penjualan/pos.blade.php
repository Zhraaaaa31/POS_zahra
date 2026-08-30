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
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
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
                          onsubmit="return confirm('Yakin ingin checkout?')">
                        @csrf
                        @method('PUT')

                        <select name="payment_method" class="form-select mb-3">
                            <option value="">Pilih Pembayaran</option>
                            <option value="CASH">Cash</option>
                            <option value="QRIS">QRIS</option>
                        </select>

                        <button class="btn btn-success w-100 fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            Checkout
                        </button>
                    </form>

                    @can('delete', $sale)
                        <form action="{{ route('penjualan.destroy', $sale->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                Batalkan Transaksi
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

    </div>
</div>

@endsection