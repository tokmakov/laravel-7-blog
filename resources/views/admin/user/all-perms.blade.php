<h5>Права</h5>
<div class="form-group d-flex flex-wrap">
    @php
        /*
         * Тут возможны такие варианты:
         * 1. Форма редактирования еще не отправлена, привязанные права берем
         *    из связи модели User с моделью Permission через сводную таблицу
         * 2. Форма редактирования была отправлена, но были ошибки формы,
         *    поэтому отмеченные админом checkbox-ы берем из old()
         */
        $perms = $user->permissions->keyBy('id')->keys()->toArray();
        if (old('perms')) $perms = old('perms');
    @endphp
    @foreach ($allperms as $item)
        @php $checked = in_array($item->id, $perms) @endphp
        <div class="form-check-inline w-25 mr-0">
            <input class="form-check-input" type="checkbox"
                   name="perms[]" id="perm-id-{{ $item->id }}"
                   value="{{ $item->id }}" @if($checked) checked @endif>
            <label class="form-check-label" for="perm-id-{{ $item->id }}">
                {{ $item->name }}
            </label>
        </div>
    @endforeach
</div>
