<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller {

    public function __construct() {
        $this->middleware('perm:manage-pages')->only('index');
        $this->middleware('perm:create-page')->only(['create', 'store']);
        $this->middleware('perm:edit-page')->only(['edit', 'update']);
        $this->middleware('perm:delete-page')->only('destroy');
    }

    /**
     * Показывает список всех страниц
     */
    public function index() {
        $roots = Page::whereNull('parent_id')->with('children')->get();
        return view('admin.page.index', compact('roots'));
    }

    /**
     * Показывает форму для создания страницы
     */
    public function create() {
        $parents = Page::whereNull('parent_id')->get();
        return view('admin.page.create', compact('parents'));
    }

    /**
     * Сохраняет новую страницу в базу данных
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'numeric|nullable',
            'slug' => 'required|max:100|unique:pages|regex:~^[-_a-z0-9]+$~i',
            'content' => 'required',
        ]);
        Page::create($request->all());
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Новая страница успешно создана');
    }

    /**
     * Показывает форму для редактирования страницы
     */
    public function edit(Page $page) {
        $parents = Page::whereNull('parent_id')->where('id', '<>', $page->id)->get();
        return view('admin.page.edit', compact('page', 'parents'));
    }

    /**
     * Обновляет страницу (запись в таблице БД)
     */
    public function update(Request $request, Page $page) {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'numeric|not_in:'.$page->id.'|nullable',
            // обязательное, не больше 100 символов, уникальное (без учета slug этой
            // записи таблицы pages) и содержать буквы, цифры, дефис и подчеркивание
            'slug' => 'required|max:100|unique:pages,slug,'.$page->id.',id|regex:~^[-_a-z0-9]+$~i',
            'content' => 'required',
        ]);
        $page->update($request->all());
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Страница была успешно отредактирована');
    }

    /**
     * Удаляет страницу (запись в таблице БД)
     */
    public function destroy(Page $page, ImageUploader $imageUploader) {
        if ($page->children->count()) {
            return back()->withErrors('Нельзя удалить страницу, у которой есть дочерние');
        }
        $imageUploader->destroy($page->content);
        $page->delete();
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Страница сайта успешно удалена');
    }
}
