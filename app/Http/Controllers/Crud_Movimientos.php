<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\Movimientos;
use Illuminate\Http\Request;

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



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
