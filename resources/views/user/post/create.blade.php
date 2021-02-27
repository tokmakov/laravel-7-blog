@extends('layout.user', ['title' => 'Создание поста'])

@section('content')
    <h1>Создание поста</h1>
    <form method="post" action="{{ route('user.post.store') }}" enctype="multipart/form-data">
        @include('common.form')
    </form>
@endsection
