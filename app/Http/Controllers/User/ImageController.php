<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller {

    public function __construct(Request $request) {
        if ( ! $request->has('entity')) abort(404);
        if ( ! in_array($request->entity, ['post', 'page'])) abort(404);
        if ($request->entity === 'post') {
            $this->middleware(['perm:create-post,edit-post']);
        }
        if ($request->entity === 'page') {
            $this->middleware(['perm:create-page,edit-page']);
        }
    }

    /**
     * Загружает изображение, которое было добавлено в wysiwyg-редакторе и
     * возвращает ссылку на него, чтобы в редакторе вставить <img src="…"/>
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function upload(ImageUploader $imageUploader) {
        return $imageUploader->upload();
    }

    /**
     * Удаляет изображение, которое было удалено в wysiwyg-редакторе
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function remove(ImageUploader $imageUploader) {
        $imageUploader->remove();
    }
}
