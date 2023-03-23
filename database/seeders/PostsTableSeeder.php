<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Let's truncate our existing records to start from scratch.
        Post::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few rows in our database:
        for ($i = 0; $i < 100; $i++) {
            Post::create([
                'post_title' => $faker->sentence,
                'post_content' => $faker->paragraph,
            ]);
        }
    }
}
