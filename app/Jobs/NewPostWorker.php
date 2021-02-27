<?php

namespace App\Jobs;

use App\Post;
use \App\Mail\NewPostMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewPostWorker implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function handle() {
        Mail::send(new NewPostMailer($this->post));
    }
}
