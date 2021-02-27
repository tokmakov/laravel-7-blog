<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageUploader {

    public function upload() {
        request()->validate(['image' => [
            'mimes:jpeg,jpg,png',
            'max:5000' // 5 Мбайт
        ]]);
        $path = request()->file('image')->store('upload', 'public');
        $url = Storage::disk('public')->url($path);
        return response()->json(['image' => $url]);
    }

    public function remove() {
        $path = parse_url(request()->remove, PHP_URL_PATH);
        $path = str_replace('/storage/', '', $path);
        Storage::disk('public')->delete($path);
    }

    public function destroy($content) {
        $pattern = '~/storage/upload/([0-9a-z]+\.(jpeg|jpg|png))~i';
        preg_match_all($pattern, $content, $matches);
        foreach ($matches[1] as $name) {
            Storage::disk('public')->delete('upload/' . $name);
        }
    }
}
