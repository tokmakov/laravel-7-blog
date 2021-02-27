<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // создать связи между пользователями и ролями
        foreach(App\User::all() as $user) {
            foreach(App\Role::all() as $role) {
                if ($user->id == 1 && $role->slug == 'root') { // один супер-админ
                    $user->roles()->attach($role->id);
                }
                if (in_array($user->id, [2,3]) && $role->slug == 'admin') { // два админа
                    $user->roles()->attach($role->id);
                }
                if ($user->id > 3 && $role->slug == 'user') { // обычные пользователи
                    $user->roles()->attach($role->id);
                }
            }
        }
    }
}
