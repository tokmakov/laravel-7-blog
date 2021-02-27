<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller {
    public function __invoke(Page $page) {
        return view('page.show', compact('page'));
    }
}
