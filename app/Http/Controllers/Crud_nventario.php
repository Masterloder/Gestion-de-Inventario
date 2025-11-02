<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostMovimientos;
use App\Models\Provedores;
use Illuminate\Http\Request;

class Crud_nventario extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $posts = Provedores::all()
        ->select('id', 'codigo', 'nombre', 'contacto', 'direccion');
        return $posts;
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:proveedores,correo',
            'telefono' => 'nullable|numeric',
            'direccion' => 'required',
        ]);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(string $id)
    {
        //
    }
}

