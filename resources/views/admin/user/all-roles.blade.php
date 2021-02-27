<h5>Роли</h5>
<div class="form-group d-flex flex-wrap">
    @php
        /*
         * Тут возможны такие варианты:
         * 1. Форма редактирования еще не отправлена, привязанные роли берем
         *    из связи модели User с моделью Role через сводную таблицу
         * 2. Форма редактирования была отправлена, но были ошибки формы,
         *    поэтому отмеченные админом checkbox-ы берем из old()
         */
        $roles = $user->roles->keyBy('id')->keys()->toArray();
        if (old('roles')) $roles = old('roles');
    @endphp
    @foreach ($allroles as $item)
        @php $checked = in_array($item->id, $roles) @endphp
        <div class="form-check-inline w-25 mr-0">
            <input class="form-check-input" type="checkbox"
                   name="roles[]" id="role-id-{{ $item->id }}"
                   value="{{ $item->id }}" @if($checked) checked @endif>
            <label class="form-check-label" for="role-id-{{ $item->id }}">
                {{ $item->name }}
            </label>
        </div>
    @endforeach
</div>
