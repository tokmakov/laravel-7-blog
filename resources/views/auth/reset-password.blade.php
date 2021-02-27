@extends('layout.site', ['title' => 'Сбросить пароль'])

@section('content')
    <h1>Сбросить пароль</h1>
    <form method="post" action="{{ route('auth.reset-password') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="email" value="{{ $token }}">
        <div class="form-group">
            <input type="text" class="form-control" name="password"
                   placeholder="Придумайте пароль" required maxlength="255" value="">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="password_confirmation"
                   placeholder="Пароль еще раз" required maxlength="255" value="">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info text-white">Сбросить</button>
        </div>
    </form>
@endsection

