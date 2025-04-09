<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catastro;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Catastro::factory()->count(50)->create();
        $this->call([
            //ConfigurationSeeder::class,
            //RoleSeeder::class,
            //UserSeeder::class,
        ]);
    }
}
