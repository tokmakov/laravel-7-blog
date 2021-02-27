@extends('layout.site', ['title' => $category->name])

@section('content')
    <h1 class="mb-3">{{ $category->name }}</h1>
    @foreach ($posts as $post)
        @include('blog.part.post', ['post' => $post])
    @endforeach
    {{ $posts->links() }}
@endsection
