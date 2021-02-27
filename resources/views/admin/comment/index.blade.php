@extends('layout.admin', ['title' => 'Все комментарии'])

@section('content')
    <h1>Все комментарии</h1>
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th width="12%">Дата и время</th>
            <th width="47%">Текст комментария</th>
            <th width="17%">Автор комментария</th>
            <th width="20%">Разрешил публикацию</th>
            <th><i class="fas fa-eye"></i></th>
            <th><i class="fas fa-toggle-on"></i></th>
            <th><i class="fas fa-edit"></i></th>
            <th><i class="fas fa-trash-alt"></i></th>
        </tr>
        @foreach ($comments as $comment)
        <tr>
            <td>{{ $comment->id }}</td>
            <td>{{ $comment->created_at }}</td>
            <td>{{ iconv_substr($comment->content, 0, 100) }}…</td>
            <td>{{ $comment->user->name }}</td>
            <td>
                @if ($comment->editor)
                    {{ $comment->editor->name }}
                @endif
            </td>
            <td>
                @php
                    $params = ['comment' => $comment->id, 'page' => $comment->adminPageNumber()];
                @endphp
                <a href="{{ route('admin.comment.show', $params) }}#comment-list"
                   title="Предварительный просмотр">
                    <i class="far fa-eye"></i>
                </a>
            </td>
            <td>
                @perm('publish-comment')
                    @if ($comment->isVisible())
                        <a href="{{ route('admin.comment.disable', ['comment' => $comment->id]) }}"
                           title="Запретить комментарий">
                            <i class="far fa-toggle-on"></i>
                        </a>
                    @else
                        <a href="{{ route('admin.comment.enable', ['comment' => $comment->id]) }}"
                           title="Разрешить комментарий">
                            <i class="far fa-toggle-off"></i>
                        </a>
                    @endif
                @endperm
            </td>
            <td>
                @perm('edit-comment')
                    <a href="{{ route('admin.comment.edit', ['comment' => $comment->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                @endperm
            </td>
            <td>
                @perm('delete-comment')
                    <form action="{{ route('admin.comment.destroy', ['comment' => $comment->id]) }}"
                          method="post" onsubmit="return confirm('Удалить этот комментарий?')">
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
    {{ $comments->links() }}
@endsection
