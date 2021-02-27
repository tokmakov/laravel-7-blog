<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    /**
     * Связь модели Permission с моделью Role, позволяет получить
     * все роли, куда входит это право
     */
    public function roles() {
        return $this
            ->belongsToMany(Role::class,'role_permission')
            ->withTimestamps();
    }
    /**
     * Связь модели Permission с моделью Auth, позволяет получить
     * всех пользователей с этим правом
     */
    public function users() {
        return $this
            ->belongsToMany(User::class,'user_permission')
            ->withTimestamps();
    }
}
