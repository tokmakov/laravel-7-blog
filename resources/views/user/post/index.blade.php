@extends('layout.user', ['title' => 'Ваши публикации'])

@section('content')
    <h1>Ваши публикации</h1>
    @perm('create-post')
        <a href="{{ route('user.post.create') }}" class="btn btn-success mb-4">
            Новая публикация
        </a>
    @endperm
    @if ($posts->count())
        <table class="table table-bordered">
            <tr>
                <th width="10%">Дата</th>
                <th width="40%">Наименование</th>
                <th width="20%">Автор публикации</th>
                <th width="20%">Разрешил публикацию</th>
                <th><i class="fas fa-eye"></i></th>
                <th><i class="fas fa-toggle-on"></i></th>
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>
                        @if ($post->editor)
                            {{ $post->editor->name }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.post.show', ['post' => $post->id]) }}"
                           title="Предварительный просмотр">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        @if ($post->isVisible())
                            <i class="far fa-toggle-on text-black-50"></i>
                        @else
                            <i class="far fa-toggle-off text-black-50"></i>
                        @endif
                    </td>
                    <td>
                        @if ( ! $post->isVisible())
                            <a href="{{ route('user.post.edit', ['post' => $post->id]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                        @else
                            <i class="far fa-edit text-black-50"></i>
                        @endif
                    </td>
                    <td>
                        @if ( ! $post->isVisible())
                            <form action="{{ route('user.post.destroy', ['post' => $post->id]) }}"
                                  method="post" onsubmit="return confirm('Удалить этот пост?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </button>
                            </form>
                        @else
                            <i class="far fa-trash-alt text-black-50"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $posts->links() }}
    @endif
@endsection
