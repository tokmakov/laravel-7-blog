<?php

namespace App\Mail;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostMailer extends Mailable {

    use Queueable, SerializesModels;

    public $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function build() {
        $users = User::inRandomOrder()->get();
        $editors = [];
        // ищем тех, кто может опубликовать пост
        foreach ($users as $user) {
            if ($user->hasPermAnyWay('publish-post')) {
                $editors[] = ['name' => $user->name, 'mail' => $user->email];
            }
            if (count($editors) > 1) break;
        }
        if (count($editors)) {
            $this->to($editors[0]['mail'], $editors[0]['name']);
            if (isset($editors[1])) {
                $this->cc($editors[1]['mail'], $editors[1]['name']);
            }
        } else {
            // если письмо некому отправлять
            $this->to(config('mail.from.address'), config('mail.from.name'));
        }
        $this->subject('Новый пост блога');
        return $this->view('email.new-post');
    }
}
