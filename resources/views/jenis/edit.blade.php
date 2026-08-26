@extends('layouts.app')

@section('title', 'Jenis Edit')

@section('content')
<h4>Edit Jenis</h4>

<form action="{{ route('jenis.update', $jenis) }}" 
method="POST">
    @method('PUT')
    @include('Jenis._form')
</form>
@endsection