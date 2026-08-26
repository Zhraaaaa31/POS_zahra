@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h4 class="d-flex justify-content-center fw-bold mt-4">Edit User</h4>

<form action="{{route('admin.users.update', $user)}}" method="POST">
    @include('users._form')
</form>
@endsection