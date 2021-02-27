<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // создать 5 страниц
        factory(App\Page::class, 5)->create();
    }
}
