@extends('layout.site', ['title' => 'Страница не найдена'])

@section('content')
    <h1>Страница не найдена</h1>
    <img src="{{ asset('img/404.jpg') }}" alt="" class="img-fluid">
    <p>Запрошенная страница не найдена.</p>
@endsection
