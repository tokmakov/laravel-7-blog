@extends('layout.admin', ['title' => 'Все роли'])

@section('content')
    <h1>Все роли</h1>
    @perm('create-role')
    <a href="{{ route('admin.role.create') }}" class="btn btn-success mb-4">
        Создать роль
    </a>
    @endperm
    @if ($roles->count())
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th width="45%">Идентификатор</th>
                <th width="45%">Наименование</th>
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->slug }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @perm('edit-role')
                            <a href="{{ route('admin.role.edit', ['role' => $role->id]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                        @endperm
                    </td>
                    <td>
                        @perm('delete-role')
                        <form action="{{ route('admin.role.destroy', ['role' => $role->id]) }}"
                              method="post" onsubmit="return confirm('Удалить эту роль?')">
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
        </table>
        {{ $roles->links() }}
    @endif
@endsection

