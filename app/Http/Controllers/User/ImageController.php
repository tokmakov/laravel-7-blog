<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;

class ImageController extends Controller {

    /**
     * Загружает изображение, которое было добавлено в wysiwyg-редакторе и
     * возвращает ссылку на него, чтобы в редакторе вставить <img src="…"/>
     */
    public function upload(ImageUploader $imageUploader) {
        return $imageUploader->upload();
    }

    /**
     * Удаляет изображение, которое было удалено в wysiwyg-редакторе
     */
    public function remove(ImageUploader $imageUploader) {
        $imageUploader->remove();
    }
}
