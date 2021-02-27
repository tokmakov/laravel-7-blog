@extends('layout.admin', ['title' => 'Создание категории'])

@section('content')
    <h1>Создание категории</h1>
    <form method="post" action="{{ route('admin.category.store') }}"
          enctype="multipart/form-data">
        @csrf
        @include('admin.category.part.form')
    </form>
@endsection
