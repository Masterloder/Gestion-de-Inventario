<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Crud_Almacen extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Post = Almacenes::all()->select("id", "codigo", "nombre", "direccion");
        return $Post;
    }

    public function PostAlmacen(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'nombre' => 'required',
                'direccion' => 'required'
            ]
        );
        $data = $request->all();
        $this->create($data);
        return redirect("/panel_de_control/Logistica")->withSuccess('');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($data)
    {
        return Almacenes::create([
            "nombre" => $data["nombre"],
            "direccion" => $data["direccion"]
        ]);
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
