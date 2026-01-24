<?php

namespace Database\Factories;

use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use App\Models\UnidadMedida;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materiales>
 */
class MaterialesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'nombre' => $this->faker->word(),
        'unidad_medida_id' => UnidadMedida::factory(), // Crea una unidad automáticamente
        'categoria_id' => CategoriaMaterial::factory(), // Crea una categoría automáticamente
        'categoria_especifica_id' => CategoriaEspecifica::factory(),
    ];
}
}
