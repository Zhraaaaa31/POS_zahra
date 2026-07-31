<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Users')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<div class="container">
    <div class="d-felx justify-content-betweenn align-items-canter mb-4 pb-2 border-button">
                <!-- <h1>Halaman Users</h1>
        <a href="{{route('admin.users.create')}}" class="btn btn-primary mb-3">Create</a>

        <form action="{{route('admin.users')}}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search')}}" class="form-control" placeholder="Search username or email">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div> -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h1 class="h3 fw-bold mb-1">Halaman Users</h1>
            <a href="{{route('admin.users.create')}}" class="btn btn-primary mb-3">Create</a>
            </div>
                <form action="{{route('admin.users')}}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search')}}" class="form-control" placeholder="Search username or email">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
</div>
<table class="table border shadow-sm table-hover align-middle">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $users->firstItem() + $loop->index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge bg-primary">{{ $user->role->name ?? '-' }}

                </span>
            </td>
            <td class="text-center">
                <a href="{{ route('admin.users.edit', $user)}}" class="btn btn-sm btn-warning">
                    Edit Akun
                </a>
                ||
               <form action="{{route('admin.users.destroy', $user)}}" method="POST" class="d-inline">
                    @csrf 
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
                        Hapus
                    </button>
                </form>
                </form>
            </td>
        </tr>
        @endforeach 
    </tbody>
</table>
</div>


@endsection


