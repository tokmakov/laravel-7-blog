<h3 id="comment-list">Все комментарии</h3>
@if ($comments->count())
    @foreach ($comments as $comment)
    <div class="card mb-3" id="comment-{{ $comment->id }}">
        <div class="card-header p-2">
            @if ( ! $comment->isVisible())
                <i class="far fa-eye-slash text-danger" title="Предварительный просмотр"></i>
            @else
                <i class="far fa-eye text-success" title="Комментарий опубликован"></i>
            @endif
            {{ $comment->user->name }}
        </div>
        <div class="card-body p-2">
            {{ $comment->content }}
        </div>
        <div class="card-footer p-2 d-flex justify-content-between">
            <span>{{ $comment->created_at }}</span>
            <span>
                @if ( ! $comment->isVisible())
                    <a href="{{ route('user.comment.edit', ['comment' => $comment->id]) }}"
                       class="btn btn-outline-primary btn-sm" title="Редактировать комментарий">
                        <i class="far fa-edit"></i>
                    </a>
                    <form action="{{ route('user.comment.destroy', ['comment' => $comment->id]) }}"
                          method="post" class="d-inline"
                          onsubmit="return confirm('Удалить этот комментарий?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Удалить комментарий">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                @endif
            </span>
        </div>
    </div>
    @endforeach
    {{ $comments->fragment('comment-list')->links() }}
@else
    <p>К этому посту еще нет комментариев</p>
@endif

