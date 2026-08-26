<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Users')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<div class="container my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Users</h1>
           
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm px-3">
                <span> + Create User</span>
            </a>
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body ">
            <form action="{{ route('admin.users') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           class="form-control border-end-0" 
                           placeholder="Cari berdasarkan nama atau email...">
                    <button class="btn btn-primary px-4" type="submit">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Users -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
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
                        <td class="ps-4 text-muted fw-medium">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td class="fw-semibold text-dark">
                            {{ $user->name }}
                        </td>
                        <td class="text-secondary">
                            {{ $user->email }}
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                {{ $user->role->name ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-inline-flex align-items-center gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus user ini?')">
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