<ul>
@foreach($items as $item)
    <li>
        <a href="{{ route('blog.tag', ['tag' => $item->slug]) }}">{{ $item->name }}</a>
        <span class="badge badge-dark float-right">{{ $item->posts_count }}</span>
    </li>
@endforeach
</ul>
