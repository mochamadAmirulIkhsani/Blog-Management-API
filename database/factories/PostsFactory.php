<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\categories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->text(500),
            'user_id' => User::factory(),
            'category_id' => categories::factory(),
            'thumbnail' => fake()->imageUrl(),
            'status' => 'publish',
            'meta_title' => fake()->sentence(4),
            'meta_description' => fake()->sentence(15),
        ];
    }
}
