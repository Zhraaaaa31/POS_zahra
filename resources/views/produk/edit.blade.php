@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')


<form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('produk._form')
</form>
@endsection