<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catastro;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConfigurationSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // Insertar datos por defecto
        DB::table('alcaldia_info')->insert([
            'nombre' => 'Alcaldía Municipal',
            'rif' => 'G-00000000-0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
