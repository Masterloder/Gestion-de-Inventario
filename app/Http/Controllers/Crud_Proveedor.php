<?php

namespace App\Http\Controllers;

use App\Models\Provedores;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Crud_Proveedor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Provedores::all()->select('id','nombre','correo','telefono','direccion');
        return $post;
    }

    public function PostProveedor(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'=> 'required',
            'correo'=> 'required',
            'telefono'=> 'required',
            'direccion'=> 'required'
        ]);
            $data = $request->all();
            $this->create($data);
            return redirect("/panel_de_control/Logistica")->withSuccess('');

    }


    public function create(array $data)
    {
        return Provedores::create([
                "nombre" => $data["nombre"],
                "correo" => $data["correo"],
                "telefono" => $data["telefono"],
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
