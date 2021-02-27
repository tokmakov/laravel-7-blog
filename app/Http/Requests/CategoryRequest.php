<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest {
    /**
     * Определяет, есть ли права у пользователя на этот запрос
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Возвращает массив правил для проверки полей формы
     *
     * @return array
     */
    public function rules() {
        $unique = 'unique:categories,slug';
        if ('admin.category.update' == $this->route()->getName()) {
            // получаем модель Category через маршрут admin/category/{category}
            $model = $this->route('category');
            /*
             * Проверка на уникальность slug, исключая этот пост по идентифкатору:
             * 1. categories — таблица базы данных, где проверяется уникальность
             * 2. slug — имя колонки, уникальность значения которой проверяется
             * 3. значение, по которому из проверки исключается запись таблицы БД
             * 4. поле, по которому из проверки исключается запись таблицы БД
             * Для проверки будет использован такой SQL-запрос к базе данныхЖ
             * SELECT COUNT(*) FROM `categories` WHERE `slug` = '...' AND `id` <> 17
             */
            $unique = 'unique:categories,slug,'.$model->id.',id';
        }
        return [
            'name' => [
                'required',
                'min:3',
                'max:100',
            ],
            'slug' => [
                'required',
                'max:100',
                $unique,
                'regex:~^[-_a-z0-9]+$~i',
            ],
            'content' => [
                'max:500',
            ],
            'image' => [
                'mimes:jpeg,jpg,png',
                'max:5000'
            ],
        ];
    }

    /**
     * Возвращает массив сообщений об ошибках для заданных правил
     *
     * @return array
     */
    public function messages() {
        return [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'unique' => 'Такое значение поля «:attribute» уже используется',
            'min' => [
                'string' => 'Поле «:attribute» должно быть не меньше :min символов',
                'file' => 'Файл «:attribute» должен быть не меньше :min Кбайт'
            ],
            'max' => [
                'string' => 'Поле «:attribute» должно быть не больше :max символов',
                'file' => 'Файл «:attribute» должен быть не больше :max Кбайт'
            ],
            'mimes' => 'Файл «:attribute» должен иметь формат :values',
        ];
    }

    /**
     * Возвращает массив дружественных пользователю названий полей
     *
     * @return array
     */
    public function attributes() {
        return [
            'name' => 'Наименование',
            'slug' => 'ЧПУ (англ.)',
            'content' => 'Краткое описание',
            'image' => 'Изображение',
        ];
    }
}
