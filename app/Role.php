<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Связь модели Role с моделью Permission, позволяет получить
     * все права для этой роли
     */
    public function permissions() {
        return $this
            ->belongsToMany(Permission::class,'role_permission')
            ->withTimestamps();
    }
    /**
     * Связь модели Role с моделью Usrer, позволяет получить
     * всех пользователей с этой ролью
     */
    public function users() {
        return $this
            ->belongsToMany(User::class,'user_role')
            ->withTimestamps();
    }
}
