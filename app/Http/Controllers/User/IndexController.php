<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class IndexController extends Controller {
    public function __invoke() {
        $perms = [
            'manage-posts', 'manage-comments', 'manage-tags',
            'manage-users', 'manage-roles', 'manage-pages'
        ];
        $admin = auth()->user()->hasAnyPerms(...$perms);
        return view('user.index', compact('admin'));
    }
}
