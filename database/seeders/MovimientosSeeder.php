<?php

namespace Database\Seeders;

use App\Models\Movimientos;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MovimientosSeeder extends Seeder
{
    public function run()
    {
        $material = Materiales::first();
        $user = User::first();
        $almacenId = 1;

        // 1. SIMULAR INGRESO (Entrada)
        $cantidadEntrada = 100;
        Movimientos::create([
            'tipo_movimiento'   => 'Entrada',
            // Genera una fecha aleatoria entre el día 1 y el último día del mes actual
            'fecha_operacion'   => fake()->dateTimeThisMonth(), 
            'cantidad'          => $cantidadEntrada,
            'numero_referencia' => 'MOV-0001-ING-' . strtoupper(Str::random(4)),
            'id_material'       => $material->id,
            'id_proveedor'      => 1,
            'id_almacen'        => $almacenId,
            'id_usuario'        => $user->id
        ]);

        Inventario::where('id_material', $material->id)
                  ->where('id_almacen', $almacenId)
                  ->increment('cantidad_actual', $cantidadEntrada);

        // 2. SIMULAR SALIDA
        $cantidadSalida = 20;
        Movimientos::create([
            'tipo_movimiento'   => 'Salida',
            // También aleatoria dentro de este mes
            'fecha_operacion'   => fake()->dateTimeThisMonth(),
            'cantidad'          => $cantidadSalida,
            'numero_referencia' => 'MOV-0002-SAL-' . strtoupper(Str::random(4)),
            'id_material'       => $material->id,
            'id_almacen'        => $almacenId,
            'destino'           => 'Obra Sector Sur',
            'id_usuario'        => $user->id
        ]);

        Inventario::where('id_material', $material->id)
                  ->where('id_almacen', $almacenId)
                  ->decrement('cantidad_actual', $cantidadSalida);
    }
}