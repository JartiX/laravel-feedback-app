<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'content' => fake()->paragraph(),
            'is_approved' => fake()->boolean(80),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}