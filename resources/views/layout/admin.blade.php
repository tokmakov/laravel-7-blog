<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Панель управления' }}</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/back.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/back.js') }}"></script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
        <!-- Логотип и кнопка «Гамбургер» -->
        <a class="navbar-brand" href="{{ route('admin.index') }}">Панель управления</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbar-blog" aria-controls="navbar-blog"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Основная часть меню (может содержать ссылки, формы и прочее) -->
        <div class="collapse navbar-collapse" id="navbar-blog">
            <!-- Этот блок расположен слева -->
            <ul class="navbar-nav mr-auto">
                @perm('manage-posts')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.post.index') }}">Посты</a>
                    </li>
                @endperm
                @perm('manage-comments')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.comment.index') }}">Комментарии</a>
                    </li>
                @endperm
                @perm('manage-categories')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.category.index') }}">Категории</a>
                    </li>
                @endperm
                @perm('manage-tags')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tag.index') }}">Теги</a>
                    </li>
                @endperm
                @perm('manage-users')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.user.index') }}">Пользователи</a>
                    </li>
                @endperm
                @perm('manage-roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.role.index') }}">Роли</a>
                    </li>
                @endperm
                @perm('manage-pages')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.page.index') }}">Страницы</a>
                    </li>
                @endperm
                @perm('manage-posts')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.trash.index') }}">Корзина</a>
                    </li>
                @endperm
            </ul>
            <!-- Этот блок расположен справа -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">Личный кабинет</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <div class="col">
            @if ($message = session('success'))
            <div class="alert alert-success alert-dismissible mt-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ $message }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible mt-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
