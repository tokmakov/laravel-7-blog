<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest {
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
        $rules = [
            'content' => [
                'required',
                'string',
                'max:500',
            ],
        ];
        // при добавлении нового комментария есть скрытое поле post_id
        if ($this->route()->getName() == 'blog.comment') {
            $rules['post_id'] = [
                'required',
                'numeric',
                'min:1',
                'exists:posts,id'
            ];
        }
        return $rules;
    }

    /**
     * Возвращает массив сообщений об ошибках для заданных правил
     *
     * @return array
     */
    public function messages() {
        return [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'max' => 'Поле «:attribute» должно быть не больше :max символов',
            'numeric' => 'Идентификатор публикации должен быть числом',
            'min' => 'Идентификатор публикации должен быть :min или больше',
            'exists' => 'Публикации с таким идентификатором не существует',
        ];
    }

    /**
     * Возвращает массив дружественных пользователю названий полей
     *
     * @return array
     */
    public function attributes() {
        return [
            'content' => 'Текст комментария'
        ];
    }
}
