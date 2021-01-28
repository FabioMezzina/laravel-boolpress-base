<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->title = $faker->sentence(5);
            $article->body = $faker->paragraphs(3, true);
            $article->author = $faker->sentence(2);
            $article->slug = Str::slug($article->title, '-');

            $article->save();
        }
    }
}
