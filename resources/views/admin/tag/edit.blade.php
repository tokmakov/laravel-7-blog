@extends('layout.admin', ['title' => 'Редактирование тега'])

@section('content')
    <h1>Редактирование тега</h1>
    <form method="post" action="{{ route('admin.tag.update', ['tag' => $tag->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Наименование"
                   required maxlength="50" value="{{ old('name') ?? $tag->name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
                   required maxlength="50" value="{{ old('slug') ?? $tag->slug ?? '' }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
