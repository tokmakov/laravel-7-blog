@if ($items->where('parent_id', $parent)->count())
    @php($level++)
    @foreach ($items->where('parent_id', $parent) as $item)
        <option value="{{ $item->id }}" @if ($item->id == $parent_id) selected @endif>
            @if ($level) {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}  @endif
            {{ $item->name }}
        </option>
        @include('admin.part.parents', ['level' => $level, 'parent' => $item->id])
    @endforeach
@endif
