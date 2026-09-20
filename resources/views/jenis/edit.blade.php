@extends('layouts.app')

@section('title', 'Jenis Edit')

@section('content')

<form action="{{ route('jenis.update', $jenis) }}" 
method="POST">
    @method('PUT')
    @include('Jenis._form')
</form>
@endsection