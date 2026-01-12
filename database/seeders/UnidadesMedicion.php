<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadMedida; // Importa tu modelo aquí

class UnidadesMedicion extends Seeder
{
    public function run(): void
    {
        $unidades = [
            ['nombre_unidad' => 'Kilogramo', 'simbolo' => 'kg'],
            ['nombre_unidad' => 'Litro', 'simbolo' => 'L'],
            ['nombre_unidad' => 'Metro', 'simbolo' => 'm'],
            ['nombre_unidad' => 'Metro cuadrado', 'simbolo' => 'm2'],
            ['nombre_unidad' => 'Metro cúbico', 'simbolo' => 'm3'],
            ['nombre_unidad' => 'Unidad', 'simbolo' => 'un'],
            ['nombre_unidad' => 'Rollo', 'simbolo' => 'rollo'],
            ['nombre_unidad' => 'Caja', 'simbolo' => 'cja'],
            ['nombre_unidad' => 'Paquete', 'simbolo' => 'paq'],
            ['nombre_unidad' => 'Gramo', 'simbolo' => 'g'],
            ['nombre_unidad' => 'Mililitro', 'simbolo' => 'ml'],
            ['nombre_unidad' => 'Centimetro', 'simbolo' => 'cm'],
            ['nombre_unidad' => 'Cartucho', 'simbolo' => 'ctj']
        ];


        foreach ($unidades as $unidad) {
            $m = new UnidadMedida();
            $m->nombre_unidad = $unidad['nombre_unidad'];
            $m->simbolo = $unidad['simbolo'];
            $m->save();
        }
    }
}