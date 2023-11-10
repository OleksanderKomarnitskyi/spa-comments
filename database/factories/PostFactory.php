<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    /**
     * @extends Factory<Post>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(20),
            'content' => fake()->realText(1000),
        ];
    }

}
