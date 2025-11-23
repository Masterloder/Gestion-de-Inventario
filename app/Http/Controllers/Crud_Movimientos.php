<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\Movimientos;
use App\Models\Almacenes;
use App\Models\User;
use faker\Factory as faker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class Crud_Movimientos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Movimientos::all()->select('id', 'id_material', 'id_almacen', 'cantidad_actual', 'unidad_medida', 'ubicacion_fisica');
        return $post;
    }

    public function PostMovimientoIngreso(Request $request): RedirectResponse
    {
        $request->validate([
            'id_almacen' => 'required',
            'fecha_hora' => 'required',
            'materiales' => 'Required',
            'cantidad' => 'required'
        ]);
        $data = $request->all();
        $data1 = $request->all();
        $this->create($data);
        $this->createinventario($data1);

        return redirect("/panel_de_control/Logistica")->withSuccess("");
    }

    public function create($data)
    {
        $faker = faker::create();
        return Movimientos::create([
            'tipo_movimiento'   => 'Salida',
            'fecha_hora'        => $data['fecha_hora'],
            'cantidad'          => $data['cantidad'],
            'numero_referencia' => $faker->bothify('Mov-####-Retir-####'),
            'id_material'       => $data['materiales'],
            'id_almacen'        => $data['id_almacen'],
            'id_usuario'        => auth()->id(),
        ]);
    }
    public function createinventario($data1)
    {

        // buscar fila existente por almacen + material
        $inventario = Inventario::where('id_almacen', $data1['id_almacen'])
            ->where('id_material', $data1['materiales'])
            ->first();
        $material = Materiales::find($data1['materiales'])->first();

        if ($inventario) {
            // sumar cantidad a la columna cantidad_actual
            $inventario->increment('cantidad_actual', $data1['cantidad']);
            return $inventario;
        }

        // si no existe, crear nueva fila
        return Inventario::create([
            'id_material'     => $data1['materiales'],
            'id_almacen'      => $data1['id_almacen'],
            'cantidad_actual' => $data1['cantidad'],
            'unidad_medida'   => $material['unidad_medida'],
            'punto_reorden' => '0'
        ]);
    }

    public function MovimientoSalida(Request $request): RedirectResponse
    {

        $request->validate([
            'id_almacen' => 'required',
            'fecha_hora' => 'required',
            'materiales' => 'Required',
            'cantidad' => 'required'
        ]);
        $data = $request->all();
        $data1 = $request->all();
        $this->create($data);
        $this->SalidaInventario($data1);

        return redirect("/Movimientos/tabla")->withSuccess("");
    }
    public function SalidaInventario($data1)
    {

        // buscar fila existente por almacen + material
        $inventario = Inventario::where('id_almacen', $data1['id_almacen'])
            ->where('id_material', $data1['materiales'])
            ->first();
        $material = Materiales::find($data1['materiales'])->first();

        if ($inventario) {
            // resta cantidad a la columna cantidad_actual
            $inventario->decrement('cantidad_actual', $data1['cantidad']);
            return $inventario;
        }

        // si no existe, crear nueva fila
        return Inventario::create([
            'id_material'     => $data1['materiales'],
            'id_almacen'      => $data1['id_almacen'],
            'cantidad_actual' => $data1['cantidad'],
            'unidad_medida'   => $material['unidad_medida'],
            'punto_reorden' => '0'
        ]);
    }

    public function vistaAlmacen() 
{
    // 1. Traer Almacenes
    $almacenes = Almacenes::all();

    // 2. Traer Inventario con Materiales (Eager Loading)
    $inventario = Inventario::with('material')->get();

    // 3. Preparar mapa para JavaScript
    $mapaInventario = $inventario->mapWithKeys(function ($item) {
        return [
            $item->id_material => [ // La clave será el ID del material
                'cantidad_actual' => $item->cantidad_actual,
                'unidad_medida'   => $item->material->unidad_medida ?? ''
            ]
        ];
    });

    // 4. Enviar a la vista
    return view('/movimientos', compact('almacenes', 'inventario', 'mapaInventario'));
}

public function Movimientos(){
        // 1. traer movimientos de materiales
        $almacenes = Almacenes::select('id','nombre','direccion');
        // 2. traer los datos de los materiales
        $materiales = Materiales::select('id','nombre','descripcion','unidad_medida')->get();
        // 3. traer datos del los usuarios
        $usuarios = User::select('id','name','rol')->get();

        //4 traer datos de movimientos relacionados en Movimiento_inventario
        $movimientos = Movimientos::with('almacenes','materiales','usuarios')->get();

        return view('/prueba', compact('almacenes','materiales','usuarios','movimientos'));
}
}
