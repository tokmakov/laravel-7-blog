@extends('layout.admin', ['title' => 'Все посты блога'])

@section('content')
    <h1>Все посты блога</h1>
    @if ($roots->count())
        <ul>
        @foreach ($roots as $root)
            <li>
                <a href="{{ route('admin.post.category', ['category' => $root->id]) }}">
                    {{ $root->name }}
                </a>
            </li>
        @endforeach
        </ul>
    @endif
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
                        @perm('manage-posts')
                            <a href="{{ route('admin.post.show', ['post' => $post->id]) }}"
                               title="Предварительный просмотр">
                                <i class="far fa-eye"></i>
                            </a>
                        @endperm
                    </td>
                    <td>
                        @perm('publish-post')
                            @if ($post->isVisible())
                                <a href="{{ route('admin.post.disable', ['post' => $post->id]) }}"
                                   title="Запретить публикацию">
                                    <i class="far fa-toggle-on"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.post.enable', ['post' => $post->id]) }}"
                                   title="Разрешить публикацию">
                                    <i class="far fa-toggle-off"></i>
                                </a>
                            @endif
                        @endperm
                    </td>
                    <td>
                        @perm('edit-post')
                            <a href="{{ route('admin.post.edit', ['post' => $post->id]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                        @endperm
                    </td>
                    <td>
                        @perm('delete-post')
                            <form action="{{ route('admin.post.destroy', ['post' => $post->id]) }}"
                                  method="post" onsubmit="return confirm('Удалить этот пост?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </button>
                            </form>
                        @endperm
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $posts->links() }}
    @endif
@endsection
