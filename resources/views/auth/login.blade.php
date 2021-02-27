@extends('layout.site', ['title' => 'Вход в личный кабинет'])

@section('content')
    <h1>Вход в личный кабинет</h1>
    <form method="post" action="{{ route('auth.auth') }}">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="password" placeholder="Ваш пароль"
                   required maxlength="255" value="">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">
                Запомнить меня
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info text-white">Войти</button>
        </div>
        <a href="{{ route('auth.forgot-form') }}">Забыли пароль?</a>
    </form>
@endsection

