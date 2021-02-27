@extends('layout.site', ['title' => $page->name])

@section('content')
    <h1>{{ $page->name }}</h1>
    {!! $page->content !!}
@endsection
