@extends('layout.admin', ['title' => 'Редактирование роли'])

@section('content')
    <h1>Редактирование роли</h1>
    <form method="post" action="{{ route('admin.role.update', ['role' => $role->id]) }}">
        @csrf
        @method('PUT')
        @include('admin.role.form')
    </form>
@endsection
