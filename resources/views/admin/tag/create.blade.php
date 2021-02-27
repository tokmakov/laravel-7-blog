@extends('layout.admin', ['title' => 'Создание тега'])

@section('content')
    <h1>Создание тега</h1>
    <form method="post" action="{{ route('admin.tag.store') }}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Наименование"
                   required maxlength="50" value="{{ old('name') ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
                   required maxlength="50" value="{{ old('slug') ?? '' }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
