<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stem\LinguaStemRu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Post extends Model {

    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['comments'];

    /**
     * Атрибуты, которые должны быть преобразованы в дату
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'excerpt',
        'content',
        'image',
    ];

    /**
     * Количество постов на странице при пагинации
     */
    protected $perPage = 5;

    /**
     * Связь модели Post с моделью Tag, позволяет получить
     * все теги поста
     */
    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Связь модели Post с моделью Category, позволяет получить
     * родительскую категорию поста
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь модели Post с моделью Auth, позволяет получить
     * автора поста
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь модели Post с моделью Auth, позволяет получить
     * администратора, который разрешил публикацию поста
     */
    public function editor() {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Связь модели Post с моделью Comment, позволяет получить
     * все комментарии к посту
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Разрешить публикацию поста блога
     */
    public function enable() {
        $this->published_by = auth()->user()->id;
        $this->update();
    }

    /**
     * Запретить публикацию поста блога
     */
    public function disable() {
        $this->published_by = null;
        $this->update();
    }

    /**
     * Возвращает true, если публикация разрешена
     */
    public function isVisible() {
        return ! is_null($this->published_by);
    }

    /**
     * Возвращает true, если пользователь является автором
     */
    public function isAuthor() {
        return $this->user->id === auth()->user()->id;
    }

    /**
     * Выбирать из БД только опубликовынные посты
     */
    public function scopePublished($builder) {
        return $builder->whereNotNull('published_by');
    }

    /**
     * Поиск постов блога по заданным словам
     */
    public function scopeSearch($builder, $search) {
        // http://www.host12.ru/blog/item/592
        // обрезаем поисковый запрос
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $search);
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        if (empty($search)) {
            return $builder->whereNull('id'); // возвращаем пустой результат
        }
        // разбиваем поисковый запрос на отдельные слова
        $temp = explode(' ', $search);
        $words = [];
        $stemmer = new LinguaStemRu();
        foreach ($temp as $item) {
            if (iconv_strlen($item) > 3) {
                // получаем корень слова
                $words[] = $stemmer->stem_word($item);
            } else {
                $words[] = $item;
            }
        }
        $relevance = "IF (`posts`.`name` LIKE '%" . $words[0] . "%', 4, 0)";
        $relevance .= " + IF (`posts`.`content` LIKE '%" . $words[0] . "%', 2, 0)";
        $relevance .= " + IF (`users`.`name` LIKE '%" . $words[0] . "%', 1, 0)";
        $relevance .= " + IF (`tags`.`name` LIKE '%" . $words[0] . "%', 3, 0)";
        for ($i = 1; $i < count($words); $i++) {
            $relevance .= " + IF (`posts`.`name` LIKE '%" . $words[$i] . "%', 4, 0)";
            $relevance .= " + IF (`posts`.`content` LIKE '%" . $words[$i] . "%', 2, 0)";
            $relevance .= " + IF (`users`.`name` LIKE '%" . $words[$i] . "%', 1, 0)";
            $relevance .= " + IF (`tags`.`name` LIKE '%" . $words[$i] . "%', 3, 0)";
        }

        $builder->distinct()->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('post_tag', 'post_tag.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->select('posts.*', DB::raw($relevance . ' as relevance'))
            ->where('posts.name', 'like', '%' . $words[0] . '%')
            ->orWhere('posts.content', 'like', '%' . $words[0] . '%')
            ->orWhere('users.name', 'like', '%' . $words[0] . '%')
            ->orWhere('tags.name', 'like', '%' . $words[0] . '%');
        for ($i = 1; $i < count($words); $i++) {
            $builder = $builder->orWhere('posts.name', 'like', '%' . $words[$i] . '%');
            $builder = $builder->orWhere('posts.content', 'like', '%' . $words[$i] . '%');
            $builder = $builder->orWhere('users.name', 'like', '%' . $words[$i] . '%');
            $builder = $builder->orWhere('tags.name', 'like', '%' . $words[$i] . '%');
        }
        $builder->orderBy('relevance', 'desc');
        return $builder;
    }

    /**
     * Преобразует дату и время создания поста из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value) {
        $timezone = 'Europe/Moscow';
        if (auth()->check() && auth()->user()->timezone) {
            $timezone = auth()->user()->timezone;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->timezone($timezone)->format('d.m.Y H:i');
    }

    /**
     * Преобразует дату и время обновления поста из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value) {
        $timezone = 'Europe/Moscow';
        if (auth()->check() && auth()->user()->timezone) {
            $timezone = auth()->user()->timezone;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->timezone($timezone)->format('d.m.Y H:i');
    }

    /**
     * Преобразует дату и время удаления поста из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getDeletedAtAttribute($value) {
        $timezone = 'Europe/Moscow';
        if (auth()->check() && auth()->user()->timezone) {
            $timezone = auth()->user()->timezone;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->timezone($timezone)->format('d.m.Y H:i');
    }
}
