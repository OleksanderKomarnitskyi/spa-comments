<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => fake()->realText(10),
                'content' => fake()->realText()

            ],
            [
                'title' => fake()->realText(10),
                'content' => fake()->realText()
            ]
        ];

        $user = User::create([
            'name' => fake()->name(),
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make('abracadabra'),
            'remember_token' => Str::random(10),
        ]);

        $user->posts()->createMany($data);

    }
}
