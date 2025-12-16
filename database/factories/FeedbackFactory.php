<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'resolved', 'closed'];
        
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'subject' => fake()->sentence(),
            'message' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement($statuses),
            'rating' => fake()->optional(0.7)->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}