@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<div class="container my-4">
    
    <!-- Header Page & Tombol Tambah -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Daftar Produk</h1>
          </div>
        <div>
            @can('create', App\Models\Produk::class)
            <a href="{{ route('produk.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Produk</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('produk.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           class="form-control border-end-0" 
                           placeholder="Cari berdasarkan nama produk...">
                    <button class="btn btn-primary px-4" type="submit">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Produk -->
  <div class="row d-flex justify-content-center">
    @forelse ($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden" style="width: 100%; max-width: 420px;">
                
                {{-- Gambar Produk / Fallback --}}
                @if($product->foto)
                    <img src="{{ asset('storage/'.$product->foto) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $product->nama }}">
                @else
                    <div class="bg-light border-bottom d-flex align-items-center justify-content-center text-muted" style="height: 180px;">
                        <span class="fs-7">No Image</span>
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    {{-- Nama Produk & Jenis --}}
                    <h5 class="card-title fw-bold text-dark text-truncate mb-1" title="{{ $product->nama }}">{{ $product->nama }}</h5>
                    <p class="text-muted small mb-2">Jenis: {{ $product->jenis->nama_jenis ?? '-' }}</p>

                    {{-- Status Stok --}}
                    <div class="mb-2">
                        @if($product->stok > 10)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fw-medium">
                                Stok: {{ $product->stok }}
                            </span>
                        @elseif($product->stok > 0)
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-medium">
                                Stok: {{ $product->stok }}
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fw-medium">
                                Stok Habis
                            </span>
                        @endif
                    </div>

                    {{-- Harga Jual & Harga Beli --}}
                    <h6 class="card-text text-success fw-bold mb-0">
                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                    </h6>
                    <p class="text-muted small mb-3">
                        <small>Beli: Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</small>
                    </p>

                    {{-- Ditambahkan Oleh & Action Button --}}
                    <div class="mt-auto pt-2 border-top">
                        <p class="text-secondary small mb-2" style="font-size: 0.8rem;">
                            Oleh: {{ $product->user->name ?? '-' }}
                        </p>

                        <div class="d-flex gap-2">
                            @can('update', $product)
                            <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-outline-warning flex-grow-1">
                                Edit
                            </a>
                            @endcan

                            @can('delete', $product)
                            <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <p class="mb-0 fs-5 fw-semibold text-secondary">Data produk tidak tersedia.</p>
            <small>Belum ada produk yang ditambahkan atau tidak sesuai dengan pencarian.</small>
        </div>
    @endforelse
</div>

        <!-- Render Link Pagination jika ada -->
        @if(method_exists($products, 'hasPages') && $products->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@endsection