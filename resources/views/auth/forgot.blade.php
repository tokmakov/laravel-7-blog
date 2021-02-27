@extends('layout.site', ['title' => 'Восстановление пароля'])

@section('content')
    <h1>Восстановление пароля</h1>
    <form method="post" action="{{ route('auth.forgot-mail') }}">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? '' }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info text-white">Восстановить</button>
        </div>
    </form>
@endsection

