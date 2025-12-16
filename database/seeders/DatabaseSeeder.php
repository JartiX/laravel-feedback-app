<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создание пользователей
        $users = User::factory(10)->create();

        // Создание категорий
        $categories = [
            ['name' => 'Предложение', 'description' => 'Предложения по улучшению'],
            ['name' => 'Жалоба', 'description' => 'Жалобы и проблемы'],
            ['name' => 'Вопрос', 'description' => 'Общие вопросы'],
            ['name' => 'Благодарность', 'description' => 'Слова благодарности'],
            ['name' => 'Баг', 'description' => 'Сообщения об ошибках'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active' => true,
            ]);
        }

        // Создание тегов
        $tagNames = ['срочно', 'важно', 'ui', 'backend', 'frontend', 'дизайн', 'производительность', 'безопасность'];
        foreach ($tagNames as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        $tags = Tag::all();

        // Создание отзывов
        Feedback::factory(50)->create()->each(function ($feedback) use ($tags, $users) {
            // Привязка тегов
            $feedback->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Создание комментариев
            Comment::factory(rand(0, 5))->create([
                'commentable_id' => $feedback->id,
                'commentable_type' => Feedback::class,
                'user_id' => $users->random()->id,
            ]);
        });

        $this->command->info('Database seeded successfully!');
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Tags: ' . Tag::count());
        $this->command->info('Users: ' . User::count());
        $this->command->info('Feedbacks: ' . Feedback::count());
        $this->command->info('Comments: ' . Comment::count());
    }
}