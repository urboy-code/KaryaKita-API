<?php

namespace Database\Seeders;

use App\Models\Category;
use illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Graphic Design',
            'Digital Marketing',
            'Content Writing',
            'SEO Services',
            'Mobile App Development',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
