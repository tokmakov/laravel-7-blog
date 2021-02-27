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
                    @perm('publish-post')
                        @if ($comment->isVisible())
                            <a href="{{ route('admin.comment.disable', ['comment' => $comment->id]) }}"
                               class="btn btn-outline-success btn-sm" title="Запретить публикацию">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                        @else
                            <a href="{{ route('admin.comment.enable', ['comment' => $comment->id]) }}"
                               class="btn btn-outline-dark btn-sm" title="Разрешить публикацию">
                                        <i class="fas fa-toggle-off"></i>
                                    </a>
                        @endif
                    @endperm
                    @perm('edit-comment')
                        <a href="{{ route('admin.comment.edit', ['comment' => $comment->id]) }}"
                           class="btn btn-outline-primary btn-sm" title="Редактировать комментарий">
                            <i class="far fa-edit"></i>
                        </a>
                    @endperm
                    @perm('delete-comment')
                        <form action="{{ route('admin.comment.destroy', ['comment' => $comment->id]) }}"
                              method="post" class="d-inline"
                              onsubmit="return confirm('Удалить этот комментарий?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Удалить комментарий">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    @endperm
                </span>
            </div>
        </div>
    @endforeach
    {{ $comments->fragment('comment-list')->links() }}
@else
    <p>К этому посту еще нет комментариев</p>
@endif
