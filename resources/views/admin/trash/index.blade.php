@extends('layout.admin', ['title' => 'Все удаленные посты'])

@section('content')
    <h1>Все удаленные посты</h1>
    @if ($posts->count())
        <table class="table table-bordered">
            <tr>
                <th width="20%">Создан</th>
                <th width="20%">Удален</th>
                <th width="25%">Заголовок</th>
                <th width="25%">Автор публикации</th>
                <th><i class="fas fa-trash-restore"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->deleted_at }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>
                        @perm('delete-post')
                        <a href="{{ route('admin.trash.restore', ['id' => $post->id]) }}">
                            <i class="far fa-trash-restore"></i>
                        </a>
                        @endperm
                    </td>
                    <td>
                        @perm('delete-post')
                        <form action="{{ route('admin.trash.destroy', ['id' => $post->id]) }}"
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

