<?php

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movimientos;
use App\Models\Materiales;
use App\Models\Almacen; // O el nombre de tu modelo de almacén
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class SalidasMaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos IDs existentes para asegurar integridad referencial
        $materialesIds = Materiales::pluck('id')->toArray();
        $almacenesIds = Almacen::pluck('id')->toArray(); // Asegúrate que el modelo exista
        $usuariosIds = User::pluck('id')->toArray();

        // Destinos de ejemplo para el campo "ubicacion_entrega"
        $destinos = ['Obra Santa Fe', 'Taller Central', 'Mantenimiento Planta A', 'Proyecto Hidráulico', 'Departamento de Logística', 'Sede Norte'];

        // Generar 20 salidas aleatorias
        for ($i = 0; $i < 20; $i++) {
            
            // Emulamos la lógica de fecha del formulario (hoy +/- 7 días)
            $fechaAleatoria = now()->addDays(rand(-7, 7));

            Movimientos::create([
                'id_material'      => Arr::random($materialesIds),
                'id_almacen'       => Arr::random($almacenesIds),
                'id_usuario'       => Arr::random($usuariosIds), // Quién registra
                'cantidad'         => rand(1, 50), // Cantidad aleatoria
                'tipo_movimiento'  => 2, // 2 representa "Salida" según tu lógica previa
                'fecha_operacion'  => $fechaAleatoria,
                'ubicacion_entrega'=> Arr::random($destinos), // Campo de tu formulario
                'created_at'       => $fechaAleatoria,
                'updated_at'       => $fechaAleatoria,
            ]);
        }
    }
}