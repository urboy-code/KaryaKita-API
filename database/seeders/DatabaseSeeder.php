<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder kategori
        $this->call(CategorySeeder::class);

        // User::factory(10)->create();
        User::factory(10)->create([
            'role' => 'client',
        ]);
        $talents = User::factory(5)->create([
            'role' => 'talent',
        ]);

        // Buat 20 jasa acak, pemiliknya adalah salah satu dari 5 talent
        Service::factory(20)->create();

        // profil kosong untuk setiap talent
        foreach ($talents as $talent) {
            $talent->profile()->create();
        }
    }
}
