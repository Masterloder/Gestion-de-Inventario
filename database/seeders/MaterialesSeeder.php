<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Materiales;
use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    public function run(): void
    {
        {
            $material = [
                ['nombre' => 'Madera', 'descripcion' => 'Material natural utilizado en construcción y fabricación de muebles.', 'unidad_medida' => 'metros_cubicos', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Estructural'],
                ['nombre' => 'Acero', 'descripcion' => 'Material metálico resistente y duradero, comúnmente usado en estructuras.', 'unidad_medida' => 'kilogramos', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Estructural'],
                ['nombre' => 'Lona', 'descripcion' => 'Material utilizado para cubrir o proteger objetos.', 'unidad_medida' => 'metros_cubicos', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Cerramiento'],
                ['nombre' => 'Vidrio', 'descripcion' => 'Material transparente utilizado en ventanas, botellas y otros productos.', 'unidad_medida' => 'metros_cubicos', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Cerramiento'],
                ['nombre' => 'Hormigón', 'descripcion' => 'Material compuesto utilizado en construcción, hecho de cemento, agua y agregados.', 'unidad_medida' => 'metros_cubicos', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Estructural'],
            ];
            foreach ($material as $mat) {
                $m = new Materiales();
                $m->nombre = $mat['nombre'];
                $m->descripcion = $mat['descripcion'];
                $m->unidad_medida = $mat['unidad_medida'];
                $m->categoria = $mat['categoria'];
                $m->categoria_especifica = $mat['categoria_especifica'];
                $m->created_at = now();
                $m->updated_at = now();
                $m->save();
            }
        }
    }
}
