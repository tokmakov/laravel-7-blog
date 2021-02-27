@csrf
<div class="form-group">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $post->name ?? '' }}">
</div>
<div class="form-group">
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $post->slug ?? '' }}">
</div>
<div class="form-group">
    @php
        $category_id = old('category_id') ?? $post->category_id ?? 0;
    @endphp
    <select name="category_id" class="form-control" title="Категория">
        <option value="0">Выберите</option>
        @include('admin.part.categories', ['level' => -1, 'parent' => 0])
    </select>
</div>
<div class="form-group">
    <textarea class="form-control" name="excerpt" placeholder="Анонс поста"
              required maxlength="500">{{ old('excerpt') ?? $post->excerpt ?? '' }}</textarea>
</div>
<div class="form-group">
    <textarea class="form-control" name="content" id="editor" placeholder="Текст поста"
              required rows="4">{{ old('content') ?? $post->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
</div>

@isset($post->image)
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">
            Удалить загруженное изображение
        </label>
    </div>
@endisset

@include('admin.part.all-tags')

<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
