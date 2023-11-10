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
        $inputComment = [
            'user_name' => fake()->firstName . ' ' . fake()->lastName,
            'user_email' => fake()->email(),
            'url' => fake()->url ,
            'body' => fake()->realText(100)
        ];
        $post = Post::first();

       $parentComment1 = $post->comments()->create($inputComment);
       $parentComment2 = $post->comments()->create($inputComment);

       $i = 0;
       while ($i < 2) {
           $inputSubComment = [
               'user_name' => fake()->firstName . ' ' . fake()->lastName,
               'user_email' => fake()->email(),
               'url' => fake()->url ,
               'body' => fake()->realText(100)
           ];

         $subComment1 = $parentComment1->replies()->create($inputSubComment);
         $subComment1->post()->associate($post->id);
         $subComment1->save();
           $i++;
       }

        $subComment4 = $subComment1->replies()->create([
            'user_name' => fake()->firstName . ' ' . fake()->lastName,
            'user_email' => fake()->email(),
            'url' => fake()->url ,
            'body' => fake()->realText(100)
        ]);
        $subComment4->post()->associate($post->id);
        $subComment4->save();

        $j = 0;
        while ($j < 2) {
            $inputSubComment = [
                'user_name' => fake()->firstName . ' ' . fake()->lastName,
                'user_email' => fake()->email(),
                'url' => fake()->url ,
                'body' => fake()->realText(100)
            ];
             $subComment3 = $parentComment2->replies()->create($inputSubComment);
             $subComment3->post()->associate($post->id);
             $subComment3->save();
            $j++;
        }

    }
}
