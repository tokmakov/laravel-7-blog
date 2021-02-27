@if ($items->where('parent_id', $parent)->count())
    @php($level++)
    @foreach ($items->where('parent_id', $parent) as $item)
        <tr>
            <td>
                @if ($level)
                    {{ str_repeat('—', $level) }}
                @endif
                @if($level)
                    <span>{{ $item->name }}</span>
                @else
                    <strong>{{ $item->name }}</strong>
                @endif
            </td>
            <td>{{ $item->slug }}</td>
            <td>
                @perm('edit-category')
                    <a href="{{ route('admin.category.edit', ['category' => $item->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                @endperm
            </td>
            <td>
                @perm('delete-category')
                    <form action="{{ route('admin.category.destroy', ['category' => $item->id]) }}"
                          method="post" onsubmit="return confirm('Удалить эту категорию?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                    </form>
                @endperm
            </td>
        </tr>
        @include('admin.part.all-ctgs', ['level' => $level, 'parent' => $item->id])
    @endforeach
@endif

