<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\Movimientos;
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
        $post = Movimientos::all()->select('id','id_material','id_almacen','cantidad_actual','unidad_medida','ubicacion_fisica');
        return $post;
    }

    public function PostMovimientoIngreso(Request $request):RedirectResponse
    {
        $request->validate([
            'id_almacen'=>'required',
            'id_proveedor'=>'required',
            'fecha_hora'=>'required',
            'materiales'=>'Required',
            'cantidad'=>'required'
        ]);
         $data=$request->all();
         $this->create($data);

            return redirect("/panel_de_control/Logistica")->withSuccess("");
    }

    public function create($data)
    {
            $faker = faker::create();
        return Movimientos::create([
            'tipo_movimiento'   => 'Entrada',
            'fecha_hora'        => $data['fecha_hora'],
            'cantidad'          => $data['cantidad'],
            'numero_referencia' => $faker->bothify('Mov-####-Ingr-####'),
            'id_material'       => $data['materiales'],
            'id_almacen'        => $data['id_almacen'],
            'id_usuario'        => auth()->id(),
        ]);
    }

    /**
     * Store a newly createmateriales resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
