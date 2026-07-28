<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Tambah User')

<!-- batas awal isi konten -->
@section('content')

<form action="{{ route('admin.users.store')}}" method="POST">
    @include('users._form')
</form>
@endsection