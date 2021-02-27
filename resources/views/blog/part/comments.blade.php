@perm('create-comment')
    @include('blog.part.form')
@endperm

<h3 id="comment-list">Все комментарии</h3>
@if ($comments->count())
    @foreach ($comments as $comment)
        <div class="card mb-3" id="comment-{{ $comment->id }}">
            <div class="card-header p-2">
                {{ $comment->user->name }}
            </div>
            <div class="card-body p-2">
                {{ $comment->content }}
            </div>
            <div class="card-footer p-2">
                {{ $comment->created_at }}
            </div>
        </div>
    @endforeach
    {{ $comments->fragment('comment-list')->links() }}
@else
    <p>К этому посту еще нет комментариев</p>
@endif
