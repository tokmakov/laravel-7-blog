<?php

namespace App\Http\Controllers\User;

class PostImageController extends ImageController {
    public function __construct() {
        $this->middleware(['perm:create-post,edit-post']);
    }
}
