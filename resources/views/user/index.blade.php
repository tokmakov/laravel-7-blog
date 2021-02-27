@extends('layout.user', ['title' => 'Личный кабинет'])

@section('content')
    <h1>Личный кабинет</h1>

    <p>Добрый день {{ auth()->user()->name }}!</p>

    @perm('create-post')
        <a href="{{ route('user.post.create') }}" class="btn btn-success">
            Новая публикация
        </a>
    @endperm
    <a href="{{ route('user.post.index') }}" class="btn btn-primary">
        Ваши публикации
    </a>
    <a href="{{ route('user.comment.index') }}" class="btn btn-primary">
        Ваши комментарии
    </a>
    @if ($admin)
        <a href="{{ route('admin.index') }}" class="btn btn-danger">
            Панель управления
        </a>
    @endif
    <a href="{{ route('user.edit', ['user' => auth()->user()->id]) }}" class="btn btn-primary">
        Личные данные
    </a>
@endsection
