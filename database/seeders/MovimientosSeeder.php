<?php

namespace Database\Seeders;

use App\Models\Movimientos;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

class MovimientosSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $almacenId = Fake()->numberBetween(1,2);
        // En lugar de un ID aleatorio, definimos uno fijo para esta prueba o traemos uno real
        $material = Fake()->numberBetween(1,54);

        if (!$material) {
            $this->command->error("No hay materiales en la base de datos.");
            return;
        }

        // 1. SIMULAR INGRESO (Entrada)
        $cantidadEntrada = fake()->numberBetween(1, 500);

        Movimientos::create([
            'tipo_movimiento'   => 'Entrada',
            'fecha_operacion'   => fake()->dateTimeThisMonth(),
            'cantidad'          => $cantidadEntrada,
            'numero_referencia' => 'MOV-0001-ING-' . strtoupper(Str::random(4)),
            'id_material'       => $material, // USAR EL MISMO ID
            'id_proveedor'      => fake()->numberBetween(1,2),
            'id_almacen'        => $almacenId,
            'id_usuario'        => $user->id
        ]);

        // Usamos updateOrCreate para asegurar que si no existe el registro en inventario, se cree
        $inventario = Inventario::updateOrCreate(
            ['id_material' => $material, 'id_almacen' => $almacenId],
            ['punto_reorden' => 10, 'ubicacion_fisica' => 'Estante A1'] // Valores por defecto
        );

        $inventario->increment('cantidad_actual', $cantidadEntrada);

        // 2. SIMULAR SALIDA (Misma lógica)
        $cantidadSalida = fake()->numberBetween(1, $cantidadEntrada); // Evitar stock negativo

        Movimientos::create([
            'tipo_movimiento'   => 'Salida',
            'fecha_operacion'   => fake()->dateTimeThisMonth(),
            'cantidad'          => $cantidadSalida,
            'numero_referencia' => 'MOV-0002-SAL-' . strtoupper(Str::random(4)),
            'id_material'       => $material, // USAR EL MISMO ID
            'id_almacen'        => $almacenId,
            'destino'           => 'Obra Sector Sur',
            'id_usuario'        => $user->id
        ]);

        $inventario->decrement('cantidad_actual', $cantidadSalida);
    }
}
