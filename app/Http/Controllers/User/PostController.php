<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageSaver;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->middleware('perm:create-post')->only(['create', 'store']);
    }

    /**
     * Список всех постов пользователя
     */
    public function index() {
        $posts = Post::whereUserId(auth()->user()->id)->orderByDesc('created_at')->paginate();
        return view('user.post.index', compact('posts'));
    }

    /**
     * Показывает форму создания поста
     */
    public function create() {
        return view('user.post.create');
    }

    /**
     * Сохраняет новый пост в базу данных
     */
    public function store(PostRequest $request) {
        // уникальный идентификатор автора поста
        $request->merge(['user_id' => auth()->user()->id]);
        // сохраняем новый пост в базе данных
        $post = new Post();
        $post->fill($request->except(['image', 'tags']));
        $post->image = $this->imageSaver->upload($post);
        $post->save();
        // привязываем теги к новому посту
        $post->tags()->attach($request->tags);

        return redirect()
            ->route('user.post.show', ['post' => $post->id])
            ->with('success', 'Новый пост успешно создан');
    }

    /**
     * Страница пред.просмотра поста блога
     */
    public function show(Post $post) {
        // можно просматривать только свои посты
        if ( ! $post->isAuthor()) {
            abort(404);
        }
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        // все опубликованные комментарии других пользователей
        $others = $post->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->paginate();
        return view('user.post.show', compact('post', 'comments'));
    }

    /**
     * Показывает форму редактирования поста
     */
    public function edit(Post $post) {
        // проверяем права пользователя на это действие
        if ( ! $this->can($post)) {
            abort(404);
        }
        // нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');
        return view('user.post.edit', compact('post' ));
    }

    /**
     * Обновляет пост блога в базе данных
     */
    public function update(PostRequest $request, Post $post) {
        // проверяем права пользователя на это действие
        if ( ! $this->can($post)) {
            abort(404);
        }
        // обновляем сам пост и привязку тегов к посту
        $data = $request->except(['image', 'tags']);
        $data['image'] = $this->imageSaver->upload($post);
        $post->update($data);
        $post->tags()->sync($request->tags);
        // кнопка редактирования может быть нажата в режиме пред.просмотра
        // или в личном кабинете пользователя, поэтому и редирект разный
        $route = 'user.post.index';
        $param = [];
        if (session('preview')) {
            $route = 'user.post.show';
            $param = ['post' => $post->id];
        }
        return redirect()
            ->route($route, $param)
            ->with('success', 'Пост был успешно обновлен');
    }

    /**
     * Удаляет пост блога из базы данных
     */
    public function destroy(Post $post, ImageUploader $imageUploader) {
        // проверяем права пользователя на это действие
        if ( ! $this->can($post)) {
            abort(404);
        }
        // удаляем основное изображение поста
        $this->imageSaver->remove($post);
        // удаляем изображения из контента поста
        $imageUploader->destroy($post->content);
        // удаляем сам пост блога из базы данных
        $post->delete();
        return redirect()
            ->route('user.post.index')
            ->with('success', 'Пост блога успешно удален');
    }

    /**
     * Проверяет, что пользователь может редактировать
     * или удалять пост блога
     */
    private function can(Post $post) {
        return $post->isAuthor() && !$post->isVisible();
    }

    /**
     * Отправляет письмо админу о создании нового поста
     */
    private function notify(Post $post) {
        $users = User::whereNotNull('email_verified_at')->get();
        $editors = [];
        foreach ($users as $user) {
            if ($user->hasPermAnyWay('publish-post')) {
                $editors[] = $user->email;
            }
            if (count($editors) > 1) break;
        }
        if (count($editors)) {
            Mail::send(
                'email.new-post',
                ['post' => $post],
                function ($message) use ($editors) {
                    $message->to($editors[0]);
                    if (isset($editors[1])) {
                        $message->cc($editors[1]);
                    }
                    $message->subject('Новый пост блога');
                }
            );
        }
    }
}
