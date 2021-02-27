@extends('layout.site', ['title' => 'Посты с тегом: ' . $tag->name])

@section('content')
    <h1 class="mb-3">Посты с тегом: {{ $tag->name }}</h1>
    @foreach ($posts as $post)
        @include('blog.part.post', ['post' => $post])
    @endforeach
    {{ $posts->links() }}
@endsection
