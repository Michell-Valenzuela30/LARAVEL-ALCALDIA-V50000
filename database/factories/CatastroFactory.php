<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catastro>
 */
class CatastroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'num_expe' => $this->faker->numberBetween(1000, 9999),
            'nom_ape' => Str::limit($this->faker->name(), 50),
            'ced' => $this->faker->unique()->numerify('########'),
            'direccion' => Str::limit($this->faker->streetAddress(), 50),
            'tipo' => $this->faker->randomElement(['Residencial', 'Comercial', 'Familiar']),
            'descripcion' => Str::limit($this->faker->streetAddress(), 50),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo', 'Pendiente']),
        ];
    }
}
