@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')

@include('layouts.navbar')

<h4 class="container mt-4">Edit Jenis</h4>
<form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('produk._form')
</form>
@endsection