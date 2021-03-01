<?php

namespace App\Http\Controllers\User;

class PageImageController extends ImageController {
    public function __construct() {
        $this->middleware(['perm:create-page,edit-page']);
    }
}
