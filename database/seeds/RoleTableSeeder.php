<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = [
            ['slug' => 'root', 'name' => 'Супер-админ'],
            ['slug' => 'admin', 'name' => 'Администратор'],
            ['slug' => 'user', 'name' => 'Пользователь'],
        ];
        foreach ($roles as $item) {
            $role = new App\Role();
            $role->name = $item['name'];
            $role->slug = $item['slug'];
            $role->save();
        }
    }
}
