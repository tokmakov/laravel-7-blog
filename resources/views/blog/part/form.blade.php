<h3 id="comment-form">Ваш комментарий</h3>
<form method="post" action="{{ route('blog.comment', ['post' => $post->id]) }}">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <div class="form-group">
        <textarea class="form-control" name="content" placeholder="Текст комментария"
                  maxlength="500" rows="4">{{ old('content') ?? '' }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

