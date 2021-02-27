<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Связь модели Tag с моделью Post, позволяет получить посты,
     * связанные с тегом через сводную таблицу post_tag
     */
    public function posts() {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    /**
     * Возвращает 10 самых популярных тегов, то есть тегов, которые
     * связаны с наибольшим количеством постов
     */
    public static function popular() {
        return self::withCount('posts')->orderByDesc('posts_count')->limit(10)->get();
    }
}
