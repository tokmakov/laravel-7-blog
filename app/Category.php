<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'content',
        'image',
    ];

    /**
     * Связь модели Category с моделью Post, позволяет получить все
     * посты, размещенные в текущей категори
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * Связь модели Category с моделью Category, позволяет получить
     * родителя текущей категории
     */
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Связь модели Category с моделью Category, позволяет получить все
     * дочерние категории текущей категории
     */
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Возвращает массив идентификаторов всех потомков категории
     */
    public static function descendants($parent) {
        static $items = null;
        if (is_null($items)) {
            $items = self::all();
        }
        $ids = [];
        foreach ($items->where('parent_id', $parent) as $item) {
            $ids[] = $item->id;
            $ids = array_merge($ids, self::descendants($item->id));
        }
        return $ids;
    }
}
