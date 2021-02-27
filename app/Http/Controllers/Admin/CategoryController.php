<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->middleware('perm:manage-categories')->only('index');
        $this->middleware('perm:create-category')->only(['create', 'store']);
        $this->middleware('perm:edit-category')->only(['edit', 'update']);
        $this->middleware('perm:delete-category')->only('destroy');
    }

    /**
     * Показывает список всех категорий
     */
    public function index() {
        $items = Category::all();
        return view('admin.category.index', compact('items'));
    }

    /**
     * Показывает форму для создания категории
     */
    public function create() {
        return view('admin.category.create');
    }

    /**
     * Сохраняет новую категорию в базу данных
     */
    public function store(CategoryRequest $request) {
        $category = new Category();
        $category->fill($request->except('image'));
        $category->image = $this->imageSaver->upload($category);
        $category->save();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Новая категория успешно создана');
    }

    /**
     * Показывает форму для редактирования категории
     */
    public function edit(Category $category) {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Обновляет категорию блога в базе данных
     */
    public function update(CategoryRequest $request, Category $category) {
        $data = $request->except('image');
        $data['image'] = $this->imageSaver->upload($category);
        $category->update($data);
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Категория была успешно исправлена');
    }

    /**
     * Удаляет категорию блога
     */
    public function destroy(Category $category) {
        if ($category->children->count()) {
            $errors[] = 'Нельзя удалить категорию с дочерними категориями';
        }
        if ($category->posts->count()) {
            $errors[] = 'Нельзя удалить категорию, которая содержит посты';
        }
        if (!empty($errors)) {
            return back()->withErrors($errors);
        }
        // удаляем файл изображения
        $this->imageSaver->remove($category);
        // удаляем категорию блога
        $category->delete();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Категория блога успешно удалена');
    }
}
