@extends('layouts.app')

@section('title', 'Penjualan')

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

    <!-- Header Page & Tombol Tambah -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Daftar Penjualan</h1>
        </div>
        <div>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Penjualan</span>
            </a>
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('penjualan.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           class="form-control border-end-0" 
                           placeholder="Cari transaksi penjualan...">
                    <button class="btn btn-primary px-4" type="submit">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Penjualan -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th scope="col" class="ps-4" style="width: 5%;">No</th>
                        <th scope="col" style="width: 18%;">Tanggal Transaksi</th>
                        <th scope="col" style="width: 15%;">Kasir</th>
                        <th scope="col" style="width: 18%;">Total Pembayaran</th>
                        <th scope="col" style="width: 15%;">Metode Pembayaran</th>
                        <th scope="col" class="text-center" style="width: 12%;">Status</th>
                        <th scope="col" class="text-center pe-4" style="width: 17%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td class="ps-4 text-muted fw-medium">
                            {{ $sales->firstItem() + $loop->index }}
                        </td>
                        <td class="text-dark small">
                            {{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}
                        </td>
                        <td class="fw-semibold text-dark">
                            {{ $sale->user->name ?? '-' }}
                        </td>
                        <td class="fw-semibold text-success">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-normal">
                                {{ $sale->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if(strtolower($sale->status) == 'lunas' || strtolower($sale->status) == 'completed' || strtolower($sale->status) == 'selesai')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill fw-medium">
                                    {{ $sale->status }}
                                </span>
                            @elseif(strtolower($sale->status) == 'pending' || strtolower($sale->status) == 'proses')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 rounded-pill fw-medium">
                                    {{ $sale->status }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded-pill fw-medium">
                                    {{ $sale->status }}
                                </span>
                            @endif
                        </td>
                                                <td class="text-center pe-4">
                            <div class="d-inline-flex align-items-center gap-1">
                               <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>

                                @can('update', $sale)
                                <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $sale)
                                <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <p class="mb-0 fs-5 fw-semibold text-secondary">Data penjualan tidak ditemukan.</p>
                            <small>Belum ada transaksi penjualan atau tidak sesuai dengan pencarian.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($sales, 'hasPages') && $sales->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>

@endsection