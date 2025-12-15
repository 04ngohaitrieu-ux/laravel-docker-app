<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@blog.test',
        ]);

        // Create categories
        Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Latest tech news and updates',
        ]);
        Category::create([
            'name' => 'Programming',
            'slug' => 'programming',
            'description' => 'Tips and tricks for programming',
        ]);
        Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Everything about web development',
        ]);
        Category::create([
            'name' => 'Design',
            'slug' => 'design',
            'description' => 'Design principles and inspiration',
        ]);

        // Create 10 sample posts
        Post::factory(10)->create();
    }
}
