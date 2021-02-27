@extends('layout.admin')

@section('content')
    <h1>Панель управления</h1>

    @perm('manage-posts')
        <h3>Новые публикации</h3>
        @if ($posts->count())
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th width="25%">Дата и время</th>
                    <th width="40%">Наименование</th>
                    <th width="25%">Автор публикации</th>
                    <th><i class="fas fa-eye"></i></th>
                    <th><i class="fas fa-toggle-on"></i></th>
                </tr>
                @foreach ($posts as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.post.show', ['post' => $item->id]) }}"
                           title="Предварительный просмотр">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        @perm('publish-post')
                            <a href="{{ route('admin.post.enable', ['post' => $item->id]) }}"
                               title="Разрешить публикацию">
                                <i class="far fa-toggle-off"></i>
                            </a>
                        @endperm
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>Нет новых публикаций</p>
        @endif
    @endperm

    @perm('manage-comments')
        <h3>Новые комментарии</h3>
        @if ($comments->count())
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th width="25%">Дата и время</th>
                    <th width="40%">Текст комментария</th>
                    <th width="25%">Автор комментария</th>
                    <th><i class="fas fa-eye"></i></th>
                    <th><i class="fas fa-toggle-on"></i></th>
                </tr>
                @foreach ($comments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ iconv_substr($item->content, 0, 50) }}…</td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        @php
                        $params = ['comment' => $item->id, 'page' => $item->adminPageNumber()];
                        @endphp
                        <a href="{{ route('admin.comment.show', $params) }}#comment-list"
                           title="Предварительный просмотр">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        @perm('publish-comment')
                            <a href="{{ route('admin.comment.enable', ['comment' => $item->id]) }}"
                               title="Разрешить комментарий">
                                <i class="far fa-toggle-off"></i>
                            </a>
                        @endperm
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>Нет новых комментариев</p>
        @endif
    @endperm
@endsection
