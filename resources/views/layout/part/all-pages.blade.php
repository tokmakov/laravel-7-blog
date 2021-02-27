<ul>
@foreach($pages as $page)
    <li>
        <a href="{{ route('page', ['page' => $page->slug]) }}">{{ $page->name }}</a>
        @if ($page->children->count())
            <ul>
            @foreach($page->children as $child)
                <li>
                    <a href="{{ route('page', ['page' => $child->slug]) }}">{{ $child->name }}</a>
                </li>
            @endforeach
            </ul>
        @endif
    </li>
@endforeach
</ul>
