@extends('layouts.app')

@section('title', 'Penjualan')

<style>
  /* Mengubah tabel menjadi tampilan kartu di layar HP (maksimal lebar 767px) */
  @media (max-width: 767.98px) {
    .responsive-table thead {
      display: none;
    }

    .responsive-table, 
    .responsive-table tbody, 
    .responsive-table tr, 
    .responsive-table td {
      display: block;
      width: 100%;
    }

    .responsive-table tr {
      margin-bottom: 0.75rem;
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      background-color: #fff;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      padding: 0.5rem;
    }

    .responsive-table td {
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-align: right;
      padding: 0.5rem 0.75rem !important;
      border-bottom: 1px dashed #e9ecef;
      word-break: break-word;
      font-size: 0.85rem;
    }

    .responsive-table td:last-child {
      border-bottom: none;
    }

    .responsive-table td::before {
      content: attr(data-label);
      font-weight: 700;
      color: #6c757d;
      text-align: left;
      padding-right: 1rem;
    }
  }
</style>

@section('content') 

@include('layouts.navbar') 

<div class="container my-3 my-md-4 px-3">

    <!-- Notifikasi Error -->
    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Page & Tombol Aksi Ringkas -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 pb-2 border-bottom">
        <h1 class="h4 h3-md fw-bold text-dark mb-0">Daftar Penjualan</h1>
        
        <div class="d-flex align-items-center gap-2">
            <!-- Tombol Cetak Rekap Mingguan -->
            <a href="{{ route('penjualan.rekap') }}" class="btn btn-outline-success btn-sm d-inline-flex align-items-center gap-1 shadow-sm px-2 px-md-3" target="_blank">
                <i class="bi bi-printer"></i>
                <span>Cetak Rekap</span>
            </a>

            <!-- Tombol Tambah Penjualan -->
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm px-2 px-md-3">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Penjualan</span>
            </a>
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
        <div class="input-group shadow-sm">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="form-control form-control-sm form-control-md" 
                   placeholder="Cari transaksi penjualan...">
            <button class="btn btn-primary btn-sm px-3" type="submit">
                <i class="bi bi-search d-sm-none"></i>
                <span class="d-none d-sm-inline">Cari</span>
            </button>
            @if(request('search'))
                <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary btn-sm px-2">Reset</a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Penjualan -->
    <div class="card border-0 bg-transparent bg-md-white shadow-none shadow-md-sm overflow-hidden">
        <div class="table-responsive-md">
            <table class="table table-hover align-middle mb-0 responsive-table">
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
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td data-label="No" class="ps-md-4 text-muted fw-medium">
                            {{ $sales->firstItem() + $loop->index }}
                        </td>
                        <td data-label="Tanggal" class="text-dark">
                            {{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}
                        </td>
                        <td data-label="Kasir" class="fw-semibold text-dark">
                            {{ $sale->user->name ?? '-' }}
                        </td>
                        <td data-label="Total Pembayaran" class="fw-semibold text-success">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </td>
                        <td data-label="Metode">
                            <span class="badge bg-light text-dark border px-2 py-1 fw-normal">
                                {{ $sale->metode_pembayaran }}
                            </span>
                        </td>
                        <td data-label="Status" class="text-center">
                            @if(strtolower($sale->status) == 'lunas' || strtolower($sale->status) == 'completed' || strtolower($sale->status) == 'selesai')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-medium" style="font-size: 0.7rem;">
                                    {{ $sale->status }}
                                </span>
                            @elseif(strtolower($sale->status) == 'pending' || strtolower($sale->status) == 'proses')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill fw-medium" style="font-size: 0.7rem;">
                                    {{ $sale->status }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill fw-medium" style="font-size: 0.7rem;">
                                    {{ $sale->status }}
                                </span>
                            @endif
                        </td>
                        <td data-label="Aksi" class="text-center pe-md-4">
                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center px-2 py-1">
                                    Detail
                                </a>

                                @can('update', $sale)
                                <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center px-2 py-1">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $sale)
                                <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline-flex align-items-center m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger d-inline-flex align-items-center px-2 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">
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
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-footer bg-white border-top py-2 px-3">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {{ $sales->links() }}
                </div>
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