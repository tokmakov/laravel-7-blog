@extends('layout.admin', ['title' => 'Все страницы'])

@section('content')
    <h1 class="mb-3">Все страницы</h1>
    @perm('create-page')
        <a href="{{ route('admin.page.create') }}" class="btn btn-success mb-4">
            Создать страницу
        </a>
    @endperm
    @if ($roots->count())
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th width="45%">Наименование</th>
                <th width="45%">ЧПУ (англ.)</th>
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($roots as $root)
                <tr>
                    <td>{{ $root->id }}</td>
                    <td><strong>{{ $root->name }}</strong></td>
                    <td>{{ $root->slug }}</td>
                    <td>
                        @perm('edit-page')
                            <a href="{{ route('admin.page.edit', ['page' => $root->id]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                        @endperm
                    </td>
                    <td>
                        @perm('delete-page')
                            <form action="{{ route('admin.page.destroy', ['page' => $root->id]) }}"
                                  method="post" onsubmit="return confirm('Удалить эту страницу?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </button>
                            </form>
                        @endperm
                    </td>
                </tr>
                @foreach ($root->children as $child)
                    <tr>
                        <td>{{ $child->id }}</td>
                        <td>— {{ $child->name }}</td>
                        <td>{{ $child->slug }}</td>
                        <td>
                        @perm('edit-page')
                            <a href="{{ route('admin.page.edit', ['page' => $child->id]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                        @endperm
                        </td>
                        <td>
                            @perm('delete-page')
                                <form action="{{ route('admin.page.destroy', ['page' => $child->id]) }}"
                                      method="post" onsubmit="return confirm('Удалить эту страницу?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </form>
                            @endperm
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    @endif
@endsection
