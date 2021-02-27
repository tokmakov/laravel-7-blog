@extends('layout.site', ['title' => 'Посты автора: ' . $user->name])

@section('content')
    <h1 class="mb-3">Посты автора: {{ $user->name }}</h1>
    @foreach ($posts as $post)
        @include('blog.part.post', ['post' => $post])
    @endforeach
    {{ $posts->links() }}
@endsection
