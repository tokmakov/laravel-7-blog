<?php

use Illuminate\Database\Seeder;

class UserPermissionTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // создать связи между пользователями и правами
        foreach(App\User::all() as $user) {
            foreach(App\Permission::all() as $perm) {
                if (rand(1, 20) == 10) {
                    // $user->permissions()->attach($perm->id);
                }
            }
        }
    }
}
