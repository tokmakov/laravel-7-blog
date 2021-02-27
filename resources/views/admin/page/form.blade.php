@csrf
<div class="form-group">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $page->name ?? '' }}">
</div>
<div class="form-group">
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $page->slug ?? '' }}">
</div>
<div class="form-group">
    @php
        $parent_id = old('parent_id') ?? $page->parent_id ?? null;
    @endphp
    <select name="parent_id" class="form-control" title="Родитель">
        <option value="">Без родителя</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}" @if ($parent->id === $parent_id) selected @endif>
                {{ $parent->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <textarea class="form-control" name="content" id="editor" placeholder="Контент (html)"
              required rows="10">{{ old('content') ?? $page->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
