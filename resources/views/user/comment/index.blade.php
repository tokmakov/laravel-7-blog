@extends('layout.user', ['title' => 'Ваши комментарии'])

@section('content')
    <h1>Ваши комментарии</h1>
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
                    @php($params = ['comment' => $comment->id, 'page' => $comment->userPageNumber()])
                    <a href="{{ route('user.comment.show', $params) }}#comment-list"
                       title="Предварительный просмотр">
                        <i class="far fa-eye"></i>
                    </a>

                </td>
                <td>
                    @if ($comment->isVisible())
                        <i class="far fa-toggle-on text-success"></i>
                    @else
                        <i class="far fa-toggle-off text-black-50"></i>
                    @endif
                </td>
                <td>
                    @if ( ! $comment->isVisible())
                        <a href="{{ route('user.comment.edit', ['comment' => $comment->id]) }}">
                            <i class="far fa-edit"></i>
                        </a>
                    @else
                        <i class="far fa-edit text-black-50"></i>
                    @endif
                </td>
                <td>
                    @if ( ! $comment->isVisible())
                        <form action="{{ route('user.comment.destroy', ['comment' => $comment->id]) }}"
                              method="post" onsubmit="return confirm('Удалить этот комментарий?')">
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
    {{ $comments->links() }}
@endsection
