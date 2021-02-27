<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserTableSeeder::class);
        $this->command->info('Таблица пользователей загружена данными!');

        $this->call(RoleTableSeeder::class);
        $this->command->info('Таблица ролей загружена данными!');

        $this->call(PermissionTableSeeder::class);
        $this->command->info('Таблица прав загружена данными!');

        $this->call(RolePermissionTableSeeder::class);
        $this->command->info('Таблица роль-право загружена данными!');

        $this->call(UserPermissionTableSeeder::class);
        $this->command->info('Таблица пользователь-право загружена данными!');

        $this->call(UserRoleTableSeeder::class);
        $this->command->info('Таблица пользователь-роль загружена данными!');

        $this->call(CategoryTableSeeder::class);
        $this->command->info('Таблица категорий загружена данными!');

        $this->call(TagTableSeeder::class);
        $this->command->info('Таблица тегов загружена данными!');

        $this->call(PostTableSeeder::class);
        $this->command->info('Таблица постов загружена данными!');

        $this->call(PostTagTableSeeder::class);
        $this->command->info('Таблица пост-тег загружена данными!');

        $this->call(CommentTableSeeder::class);
        $this->command->info('Таблица комментариев загружена данными!');

        $this->call(PageTableSeeder::class);
        $this->command->info('Таблица страниц загружена данными!');
    }
}
