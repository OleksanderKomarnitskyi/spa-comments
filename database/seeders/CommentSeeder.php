<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::select(['id'])->get();

        foreach ($posts as $post) {
            $inputComment1 = [
                'user_name' => fake()->firstName . ' ' . fake()->lastName,
                'user_email' => fake()->email(),
                'url' => fake()->url,
                'body' => fake()->realText(100)
            ];
            $inputComment2 = [
                'user_name' => fake()->firstName . ' ' . fake()->lastName,
                'user_email' => fake()->email(),
                'url' => fake()->url,
                'body' => fake()->realText(100)
            ];

            $comment1 = $post->comments()->create($inputComment1);
            $comment2 = $comment1->replies()->create($inputComment2);
            $comment1->save();
            $comment2->save();
        }


    }
}
