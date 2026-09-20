@extends('layouts.app')

@section('title', 'Produk')

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

@section('content')

@include('layouts.navbar')

<div class="container my-3 my-md-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 fw-bold text-dark mb-0">Users</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm btn-md-md d-inline-flex align-items-center gap-1 shadow-sm px-3">
            <span>+ Tambah User</span>
        </a>
    </div>

    <!-- Form Pencarian -->
    <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="form-control" 
                   placeholder="Cari nama atau email...">
            <button class="btn btn-primary px-3" type="submit">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary px-3">Reset</a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Users -->
    <div class="card border-0 bg-transparent bg-md-white shadow-none shadow-md-sm overflow-hidden">
        <div class="table-responsive-md">
            <table class="table table-hover align-middle mb-0 responsive-table">
                <thead class="table-light text-secondary">
                    <tr>
                        <th scope="col" class="ps-4" style="width: 5%;">No</th>
                        <th scope="col" style="width: 25%;">Nama</th>
                        <th scope="col" style="width: 30%;">Email</th>
                        <th scope="col" style="width: 20%;">Role</th>
                        <th scope="col" class="text-center pe-4" style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td data-label="No" class="ps-md-4 text-muted fw-medium">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td data-label="Nama" class="fw-semibold text-dark">
                            {{ $user->name }}
                        </td>
                        <td data-label="Email" class="text-secondary">
                            {{ $user->email }}
                        </td>
                        <td data-label="Role">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                {{ $user->role->name ?? '-' }}
                            </span>
                        </td>
                        <td data-label="Aksi" class="text-center pe-md-4">
                            <!-- Bagian Aksi yang Dibuat Simetris Rapi -->
                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-flex align-items-center m-0">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center" onclick="return confirm('Yakin hapus user ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Data user tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection