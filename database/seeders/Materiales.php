<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Materiales;
use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materiales = [
            ['codigo'=> 'MAT001','nombre' => 'Madera', 'descripcion' => 'Material natural utilizado en construcción y fabricación de muebles.','unidad_medida' => 'metros_cubicos', 'categoria'=> 'Materiales Orgánicos', 'categoria_especifica' => 'Estructural'],
            ['codigo'=> 'MAT002','nombre' => 'Acero', 'descripcion' => 'Material metálico resistente y duradero, comúnmente usado en estructuras.','unidad_medida' => 'kilogramos', 'categoria'=> 'Materiales Metálicos', 'categoria_especifica' => 'Estructural'],
            ['codigo'=> 'MAT003','nombre' => 'Lona', 'descripcion' => 'Material utilizado para cubrir o proteger objetos.','unidad_medida' => 'metros_cubicos', 'categoria'=> 'Materiales Orgánicos', 'categoria_especifica' => 'Cerramiento'],
            ['codigo'=> 'MAT004','nombre' => 'Vidrio', 'descripcion' => 'Material transparente utilizado en ventanas, botellas y otros productos.','unidad_medida' => 'metros_cubicos', 'categoria'=> 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Cerramiento'],
            ['codigo'=> 'MAT005','nombre' => 'Hormigón', 'descripcion' => 'Material compuesto utilizado en construcción, hecho de cemento, agua y agregados.','unidad_medida' => 'metros_cubicos', 'categoria'=> 'Materiales Compuestos', 'categoria_especifica' => 'Estructural'],
        ];
        foreach ($materiales as $material) {
            Materiales::table('materiales')->insert([
                'codigo' => $material['codigo'],
                'nombre' => $material['nombre'],
                'descripcion' => $material['descripcion'],
                'unidad_medida' => $material['unidad_medida'],
                'categoria' => $material['categoria'],
                'categoria_especifica' => $material['categoria_especifica'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
