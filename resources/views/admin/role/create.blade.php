@extends('layout.admin', ['title' => 'Создание роли'])

@section('content')
    <h1>Создание роли</h1>
    <form method="post" action="{{ route('admin.role.store') }}">
        @csrf
        @include('admin.role.form')
    </form>
@endsection
