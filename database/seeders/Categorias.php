<?php

namespace Database\Seeders;

use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Categorias extends Seeder
{
    
    public function run(): void
    {
        $Categorias=[
            ['nombre_categoria' => 'Materiales Petreos'],
            ['nombre_categoria' => 'Ceramicos y Porcelanas'],
            ['nombre_categoria' => 'Materiales Compuestos'],
            ['nombre_categoria' => 'Materiales Metalicos'],
            ['nombre_categoria' => 'Materiales Organicos'],
            ['nombre_categoria' => 'Materiales Aislantes'],
            ['nombre_categoria' => 'Materiales Quimicos'],
            ['nombre_categoria' => 'Materiales Refractarios'],
            ['nombre_categoria' => 'Materiales Sinteticos'],
        ];
        $CategoriasEspecificas=[
            // Materiales Petreos
            ['categoria_id' => 1, 'nombre_especifico' => 'Naturales'],
            ['categoria_id' => 1, 'nombre_especifico' => 'Procesados/artificiales '],
            // Ceramicos y Porcelanas
            ['categoria_id' => 2, 'nombre_especifico' => 'Cerámicas Gruesas'],
            ['categoria_id' => 2, 'nombre_especifico' => 'Cerámicas Finas:'],
            ['categoria_id' => 2, 'nombre_especifico' => 'Porcelanas'],
            ['categoria_id' => 2, 'nombre_especifico' => 'Esmaltadas'],
            ['categoria_id' => 2, 'nombre_especifico' => 'Doble Cargado'],
            // Materiales Compuestos
            ['categoria_id' => 3, 'nombre_especifico' => 'Compuestos de Matriz Polimérica (PMC)'],
            ['categoria_id' => 3, 'nombre_especifico' => 'Compuestos de Matriz Metálica (MMC)'],
            ['categoria_id' => 3, 'nombre_especifico' => 'Compuestos de Matriz de Carbono (CMC)'],
            ['categoria_id' => 3, 'nombre_especifico' => 'Reforzados con Fibra'],
            ['categoria_id' => 3, 'nombre_especifico' => 'Reforzados con Partículas'],
            ['categoria_id' => 3, 'nombre_especifico' => 'Laminados'],
            // Materiales Metalicos
            ['categoria_id' => 4, 'nombre_especifico' => 'Metales Ferrosos'],
            ['categoria_id' => 4, 'nombre_especifico' => 'Metales No Ferrosos'],
            ['categoria_id' => 4, 'nombre_especifico' => 'Aleaciones'],
            ['categoria_id' => 4, 'nombre_especifico' => 'Metales Preciosos'],
            ['categoria_id' => 4, 'nombre_especifico' => 'Metales Pesados'],
            ['categoria_id' => 4, 'nombre_especifico' => 'Metales Ligeros'],
            // Materiales Organicos
            ['categoria_id' => 5, 'nombre_especifico' => 'Madera y Derivados'],
            ['categoria_id' => 5, 'nombre_especifico' => 'Biomateriales y Fibras Naturales'],
            ['categoria_id' => 5, 'nombre_especifico' => 'Materiales Basados en Celulosa'],
            ['categoria_id' => 5, 'nombre_especifico' => 'Materiales Biodegradables'],
            ['categoria_id' => 5, 'nombre_especifico' => 'Materiales de Origen Animal'],
            ['categoria_id' => 5, 'nombre_especifico' => 'Recubrimientos y Acabados Orgánicos'],
            // Materiales Aislantes
            ['categoria_id' => 6, 'nombre_especifico' => 'Aislantes de Origen Mineral'],
            ['categoria_id' => 6, 'nombre_especifico' => 'Aislantes de Origen Sintético'],
            ['categoria_id' => 6, 'nombre_especifico' => 'Aislantes Naturales'],
            ['categoria_id' => 6, 'nombre_especifico' => 'Aislantes Reflexivos'],
            ['categoria_id' => 6, 'nombre_especifico' => 'Aislantes Acústicos'],
            // Materiales Quimicos
            ['categoria_id' => 7, 'nombre_especifico' => 'Ácidos'],
            ['categoria_id' => 7, 'nombre_especifico' => 'Bases'],
            ['categoria_id' => 7, 'nombre_especifico' => 'Solventes'],
            ['categoria_id' => 7, 'nombre_especifico' => 'Sales'],
            ['categoria_id' => 7, 'nombre_especifico' => 'Oxidantes y Reductores'],
            ['categoria_id' => 7, 'nombre_especifico' => 'Polímeros Químicos'],
            // Materiales Refractarios
            ['categoria_id' => 8, 'nombre_especifico' => 'Refractarios Ácidos'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Refractarios Básicos'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Refractarios Neutros'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Refractarios Especiales/Mixtos:'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Pesados'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Ligeros/Aislantes'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Conformados (Piezas Moldeadas)'],
            ['categoria_id' => 8, 'nombre_especifico' => 'No Conformados (A granel)'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Temperatura Normales(~1500-1800 °C )'],
            ['categoria_id' => 8, 'nombre_especifico' => 'Alta Temperatura(>1800 °C)'],
            // Materiales Sinteticos
            ['categoria_id' => 9, 'nombre_especifico' => 'Fontanería y Saneamiento:'],
            ['categoria_id' => 9, 'nombre_especifico' => 'Revestimientos y Pinturas'],
            ['categoria_id' => 9, 'nombre_especifico' => 'Refuerzos Estructurales'],
            ['categoria_id' => 9, 'nombre_especifico' => 'Membranas Impermeabilizantes'],
            ['categoria_id' => 9, 'nombre_especifico' => 'Selladores y Adhesivos'],
        ];

        foreach ($Categorias as $categoria) {
            $c = new CategoriaMaterial();
            $c->nombre_categoria = $categoria['nombre_categoria'];
            $c->save();
        }
        foreach ($CategoriasEspecificas as $categoria_especifica) {
            $ce = new CategoriaEspecifica();
            $ce->categoria_id = $categoria_especifica['categoria_id'];
            $ce->nombre_especifico = $categoria_especifica['nombre_especifico'];
            $ce->save();
        }
    }
}
