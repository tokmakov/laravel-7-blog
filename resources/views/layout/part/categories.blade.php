@if ($items->where('parent_id', $parent)->count())
    <ul>
    @foreach ($items->where('parent_id', $parent) as $item)
        <li>
            <a href="{{ route('blog.category', ['category' => $item->slug]) }}">{{ $item->name }}</a>
            @include('layout.part.categories', ['parent' => $item->id])
        </li>
    @endforeach
    </ul>
@endif
