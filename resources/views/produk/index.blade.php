@extends('layouts.app')

@section('title', 'Produk')

<style>
  /* Menjaga rasio gambar tetap konsisten di layar HP */
  .product-img-wrapper {
    height: 130px;
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  
  .product-img-wrapper img {
    height: 100%;
    width: 100%;
    object-fit: cover;
  }

  @media (min-width: 768px) {
    .product-img-wrapper {
      height: 180px;
    }
  }
</style>

@section('content')

@include('layouts.navbar')

<div class="container my-3 my-md-4 px-3">
    
    <!-- Notifikasi Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Page & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 h3-md fw-bold text-dark mb-0">Daftar Produk</h1>
        @can('create', App\Models\Produk::class)
        <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm px-2 px-md-3">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Produk</span>
        </a>
        @endcan
    </div>

    <!-- Form Pencarian (Placeholder Ringkas) -->
    <form action="{{ route('produk.index') }}" method="GET" class="mb-3">
        <div class="input-group shadow-sm">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="form-control form-control-sm form-control-md" 
                   placeholder="Cari produk atau jenis...">
            <button class="btn btn-primary btn-sm px-3" type="submit">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-sm px-2">Reset</a>
            @endif
        </div>
    </form>

    <!-- Cards Grid Produk -->
    <div class="row g-2 g-md-3">
        @forelse ($products as $product)                        
            <div class="col-6 col-md-4 col-lg-3 mb-2">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                    
                    {{-- Container Gambar --}}
                    <div class="product-img-wrapper border-bottom">
                        @if($product->foto)
                            <img src="{{ asset('storage/'.$product->foto) }}" alt="{{ $product->nama }}">
                        @else
                            <span class="text-muted small">No Image</span>
                        @endif
                    </div>

                    <div class="card-body p-2 p-md-3 d-flex flex-column">
                        {{-- Nama & Jenis --}}
                        <h6 class="card-title fw-bold text-dark text-truncate mb-0" title="{{ $product->nama }}" style="font-size: 0.9rem;">
                            {{ $product->nama }}
                        </h6>
                        <p class="text-muted mb-2" style="font-size: 0.75rem;">
                            Jenis: {{ $product->jenis->nama_jenis ?? '-' }}
                        </p>

                        {{-- Status Stok --}}
                        <div class="mb-2">
                            @if($product->stok > 10)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.65rem;">
                                    Stok: {{ $product->stok }}
                                </span>
                            @elseif($product->stok > 0)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill" style="font-size: 0.65rem;">
                                    Stok: {{ $product->stok }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="font-size: 0.65rem;">
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        {{-- Harga --}}
                        <div class="mb-2">
                            <span class="d-block text-success fw-bold lh-1" style="font-size: 0.875rem;">
                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                            </span>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                Beli: Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                            </small>
                        </div>

                        {{-- Footer Kartu & Tombol Aksi --}}
                        <div class="mt-auto pt-2 border-top">
                            <p class="text-secondary small mb-2 text-truncate" style="font-size: 0.7rem;">
                                Oleh: {{ $product->user->name ?? '-' }}
                            </p>

                            <div class="row g-1">
                                @can('update', $product)
                                <div class="col-6">
                                    <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-outline-warning w-100 p-1" style="font-size: 0.75rem;">
                                        Edit
                                    </a>
                                </div>
                                @endcan

                                @can('delete', $product)
                                <div class="col-6">
                                    <form action="{{ route('produk.destroy', $product) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger w-100 p-1" style="font-size: 0.75rem;" onclick="return confirm('Yakin hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <p class="mb-0 fs-6 fw-semibold text-secondary">Data produk tidak tersedia.</p>
                <small>Belum ada produk atau hasil pencarian kosong.</small>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'hasPages') && $products->hasPages())
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-footer bg-white border-top py-2 px-3">
            {{ $products->links() }}
        </div>
    </div>
    @endif

</div>

@endsection