@extends('layouts.app')

@section('title', 'Penjualan')

@section('content') 

@include('layouts.navbar') 

<div class="container my-3 my-md-4">

    <!-- Notifikasi Error -->
    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Page & Tombol Aksi -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h4 h3-md fw-bold text-dark mb-1">Daftar Penjualan</h1>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2 w-100 w-sm-auto">
            <!-- Tombol Cetak Rekap Mingguan -->
            <a href="{{ route('penjualan.rekap') }}" class="btn btn-outline-success flex-fill flex-sm-grow-0 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm px-3" target="_blank">
                <i class="bi bi-printer"></i>
                <span>Cetak Rekap</span>
            </a>

            <!-- Tombol Tambah Penjualan -->
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary flex-fill flex-sm-grow-0 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Penjualan</span>
            </a>
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-2 p-md-3">
            <form action="{{ route('penjualan.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           class="form-control border-end-0" 
                           placeholder="Cari transaksi penjualan...">
                    <button class="btn btn-primary px-3 px-md-4" type="submit">
                        <i class="bi bi-search d-sm-none"></i>
                        <span class="d-none d-sm-inline">Cari</span>
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
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th scope="col" class="ps-3 ps-md-4" style="width: 5%;">No</th>
                        <th scope="col" style="width: 20%;">Tanggal Transaksi</th>
                        <th scope="col" style="width: 15%;">Kasir</th>
                        <th scope="col" style="width: 18%;">Total Pembayaran</th>
                        <th scope="col" style="width: 15%;">Metode</th>
                        <th scope="col" class="text-center" style="width: 12%;">Status</th>
                        <th scope="col" class="text-center pe-3 pe-md-4" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small fs-md-6">
                    @forelse($sales as $sale)
                    <tr>
                        <td class="ps-3 ps-md-4 text-muted fw-medium">
                            {{ $sales->firstItem() + $loop->index }}
                        </td>
                        <td class="text-dark">
                            {{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}
                        </td>
                        <td class="fw-semibold text-dark">
                            {{ $sale->user->name ?? '-' }}
                        </td>
                        <td class="fw-semibold text-success">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1 fw-normal">
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
                        <td class="text-center pe-3 pe-md-4">
                            <div class="d-inline-flex align-items-center gap-1">
                               <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-sm btn-outline-primary px-2 py-1">
                                    Detail
                                </a>

                                @can('update', $sale)
                                <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-outline-warning px-2 py-1">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $sale)
                                <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger px-2 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">
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
        <div class="card-footer bg-white border-top py-3 px-3 px-md-4">
            <div class="d-flex justify-content-center justify-content-md-end">
                {{ $sales->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Script Auto Open Struk Setelah Checkout -->
@if(session('print_id'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.open("{{ route('penjualan.print', session('print_id')) }}", '_blank');
    });
</script>
@endif

@endsection