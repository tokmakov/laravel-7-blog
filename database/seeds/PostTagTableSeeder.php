<?php

use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // создать связи между постами и тегами
        foreach(App\Post::all() as $post) {
            foreach(App\Tag::all() as $tag) {
                if (rand(1, 20) == 10) {
                    $post->tags()->attach($tag->id);
                }
            }
        }
    }
}
