<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));
        return [
            // Pilih user acak yang rolenya 'talent'
            'user_id' => User::where('role', 'talent')->inRandomOrder()->first()->id,
            // pilih kategori acak
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(rand(10, 20)),
            'price' => $this->faker->numberBetween(10, 500) * 10000,
        ];
    }
}
