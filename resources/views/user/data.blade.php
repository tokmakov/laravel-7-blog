@extends('layout.user', ['title' => 'Личные данные'])

@section('content')
    <h1 class="mb-4">Личные данные</h1>
    <form method="post" action="{{ route('user.update', ['user' => $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Имя, Фамилия"
                   required maxlength="255" value="{{ old('name') ?? $user->name }}">
        </div>
        <div class="form-group">
            @php
                $timezone = old('timezone') ?? $user->timezone ?? null;
            @endphp
            <select name="timezone" class="form-control" title="Часовой пояс">
                <option value="">Выберите</option>
                @foreach($timezones as $key => $value)
                    <option value="{{ $key }}" @if ($key === $timezone) selected @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
@endsection
