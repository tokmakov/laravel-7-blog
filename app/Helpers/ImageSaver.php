<?php

namespace App\Helpers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageSaver {
    /**
     * Сохраняет изображение при создании или редактировании категории,
     * или поста блога + создает уменьшеное изображение 1000x300 px.
     *
     * @param App\Item $item — модель категории блога или поста блога
     * @return string|null — имя файла изображения для сохранения в БД
     */
    public function upload($item = null) {
        $dir = 'post';
        if ($item instanceof Category) {
            $dir = 'category';
        }
        $name = $item->image;
        if ($name && request()->remove) { // если надо удалить изображение
            $this->remove($item);
            $name = null;
        }
        $source = request()->file('image');
        if ($source) { // если было загружено изображение
            // перед загрузкой нового изображения удаляем старое
            if ($item->image) {
                $this->remove($item);
                $name = null;
            }
            // сохраняем загруженное изображение на диск; $src будет
            // содержать путь относительно хранилища вместе с именем
            $src = $source->store($dir . '/source', 'public');
            $name = basename($src); // имя загруженного файла
            // создаем уменьшенное изображение 1000x300px, качество 100%
            $dst = str_replace('source', 'image', $src);
            $this->resize($src, $dst, 1000, 300);
        }
        return $name;
    }

    /**
     * Создает уменьшенную копию изображения
     *
     * @param string $src — путь к исходному изображению
     * @param string $dst — путь к уменьшенному изображению
     * @param integer $width — ширина в пикселях
     * @param integer $height — высота в пикселях
     */
    private function resize($src, $dst, $width, $height) {
        // абсолютный путь к исходному изображению
        $path = Storage::disk('public')->path($src);
        $image = Image::make($path)
            ->heighten($height)
            ->resizeCanvas($width, $height, 'center', false, 'eeeeee')
            ->encode(pathinfo($path, PATHINFO_EXTENSION), 100);
        Storage::disk('public')->put($dst, $image);
        $image->destroy();
    }

    /**
     * Удаляет изображение при удалении категории или поста блога
     *
     * @param App\Item $item — модель категории или поста блога
     */
    public function remove($item) {
        $dir = 'post';
        if ($item instanceof Category) {
            $dir = 'category';
        }
        $image = $item->image;
        if ($image) {
            Storage::disk('public')->delete($dir . '/source/' . $image);
            Storage::disk('public')->delete($dir . '/image/' . $image);
        }
    }
}
