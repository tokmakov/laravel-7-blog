<?php
namespace App\Observers;

use App\Mail\NewPostMailer;
use App\Post;
use Illuminate\Support\Facades\Mail;

class PostObserver {
    /*
     * Срабатывает после создания нового поста
     */
    public function created(Post $post) {
        Mail::send(new NewPostMailer($post));
    }
}
