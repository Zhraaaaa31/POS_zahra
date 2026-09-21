@extends('layouts.app')
@section('title', 'Jenis Produk')
@section('content')


<style>
  /* Mengubah tabel menjadi bentuk kartu di layar HP (maksimal lebar 767px) */
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
      margin-bottom: 1rem;
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
    
    <!-- Header Page & Tombol Tambah Ringkas Bersebelahan -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-0">Daftar Jenis</h1>
        </div>
        <div>
            @can('create', App\Models\Jenis::class)
            <a href="{{ route('jenis.create') }}" class="btn btn-primary btn-sm btn-md-md d-inline-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Jenis</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <form action="{{ route('jenis.index') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="form-control" 
                   placeholder="Cari berdasarkan nama jenis...">
            <button class="btn btn-primary px-3 px-md-4" type="submit">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary px-3">Reset</a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Jenis -->
    <div class="card border-0 bg-transparent bg-md-white shadow-none shadow-md-sm overflow-hidden">
        <div class="table-responsive-md">
            <table class="table table-hover align-middle mb-0 responsive-table">
                <thead class="table-light text-secondary">
                    <tr>
                        <th scope="col" class="ps-4" style="width: 10%;">No</th>
                        <th scope="col" style="width: 70%;">Nama Jenis</th>
                        <th scope="col" class="text-center pe-4" style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenis as $item)
                    <tr>
                        <td data-label="No" class="ps-md-4 text-muted fw-medium">
                            {{ method_exists($jenis, 'firstItem') ? $jenis->firstItem() + $loop->index : $loop->iteration }}
                        </td>
                        <td data-label="Nama Jenis" class="fw-semibold text-dark">
                            {{ $item->nama_jenis }}
                        </td>
                        <td data-label="Aksi" class="text-center pe-md-4">
                            <!-- Tombol Aksi Simetris dan Presisi -->
                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                @can('update', $item)
                                <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $item)
                                <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline-flex align-items-center m-0">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger d-inline-flex align-items-center" onclick="return confirm('Apakah anda yakin ingin menghapus jenis ini?')">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <p class="mb-0 fs-5 fw-semibold text-secondary">Data jenis tidak tersedia.</p>
                            <small>Belum ada jenis produk yang ditambahkan atau tidak sesuai dengan pencarian.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Render Link Pagination -->
        @if(method_exists($jenis, 'hasPages') && $jenis->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $jenis->links() }}
        </div>
        @endif
    </div>



@endsection