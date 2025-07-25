<?php

namespace Database\Factories;

use App\Models\posts;
use App\Models\tags;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => posts::factory(),
            'tag_id' => tags::factory(),
        ];
    }
}
