@extends('layout.admin', ['title' => 'Роли и права'])

@section('content')
    <h1 class="mb-4">Роли и права</h1>
    <p>Пользователь: {{ $user->name }}</p>

    <h2>Роли</h2>
    <table class="table table-bordered">
        <tr>
            <th width="10%">id</th>
            <th width="30%">Slug</th>
            <th width="30%">Name</th>
            <th width="30%">Assign/Unassign</th>
        </tr>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->slug }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    @php $params = ['user' => $user->id, 'role' => $role->id]; @endphp
                    @if ($user->hasRole($role->slug))
                        <a href="{{ route('admin.user.unassign.role', $params) }}"
                           class="text-danger">Отнять эту роль</a>
                    @else
                        <a href="{{ route('admin.user.assign.role', $params) }}"
                           class="text-success">Назначить эту роль</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <h2>Права</h2>
    <table class="table table-bordered">
        <tr>
            <th width="10%">id</th>
            <th width="30%">Slug</th>
            <th width="30%">Name</th>
            <th width="30%">Assign/Unassign</th>
        </tr>
        @foreach($perms as $perm)
            <tr>
                <td>{{ $perm->id }}</td>
                <td>{{ $perm->slug }}</td>
                <td>{{ $perm->name }}</td>
                <td>
                    @php $params = ['user' => $user->id, 'perm' => $perm->id]; @endphp
                    @if ($user->hasPerm($perm->slug))
                        <a href="{{ route('admin.user.unassign.perm', $params) }}"
                           class="text-danger">Отнять это право</a>
                    @else
                        <a href="{{ route('admin.user.assign.perm', $params) }}"
                           class="text-success">Назначить это право</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
