<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\ImageSaver;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;

class PostController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->middleware('perm:manage-posts')->only(['index', 'category', 'show']);
        $this->middleware('perm:edit-post')->only(['edit', 'update']);
        $this->middleware('perm:publish-post')->only(['enable', 'disable']);
        $this->middleware('perm:delete-post')->only('destroy');
    }

    /**
     * Список всех постов блога
     */
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate();
        return view('admin.post.index', compact('roots', 'posts'));
    }

    /**
     * Список постов категории блога
     */
    public function category(Category $category) {
        $posts = $category->posts()->paginate();
        return view('admin.post.category', compact('category', 'posts'));
    }

    /**
     * Страница просмотра поста блога
     */
    public function show(Post $post) {
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        return view('admin.post.show', compact('post'));
    }

    /**
     * Разрешить публикацию поста блога
     */
    public function enable(Post $post) {
        $post->enable();
        return back()->with('success', 'Пост блога был опубликован');
    }

    /**
     * Запретить публикацию поста блога
     */
    public function disable(Post $post) {
        $post->disable();
        return back()->with('success', 'Пост блога снят с публикации');
    }

    /**
     * Показывает форму редактирования поста
     */
    public function edit(Post $post) {
        session()->keep('preview');
        return view('admin.post.edit', compact('post' ));
    }

    /**
     * Обновляет пост блога в базе данных
     */
    public function update(PostRequest $request, Post $post) {
        $data = $request->except(['image', 'tags']);
        $data['image'] = $this->imageSaver->upload($post);
        $post->update($data);
        $post->tags()->sync($request->tags);
        // кнопка редактирования может быть нажата в режиме пред.просмотра
        // или в панели управления блогом, так что и редирект будет разный
        $route = 'admin.post.index';
        $param = [];
        if (session('preview')) {
            $route = 'admin.post.show';
            $param = ['post' => $post->id];
        }
        return redirect()
            ->route($route, $param)
            ->with('success', 'Пост был успешно обновлен');
    }

    /**
     * Удаляет пост блога из базы данных
     */
    public function destroy(Post $post) {
        // удаляем сам пост блога из базы данных
        $post->delete();
        // пост может быть удален в режиме пред.просмотра или из панели
        // управления, так что и редирект после удаления будет разным
        $route = 'admin.post.index';
        if (session('preview')) {
            $route = 'blog.index';
        }
        return redirect()
            ->route($route)
            ->with('success', 'Пост блога успешно удален');
    }
}
