<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Notifications\AlmacenNotification;
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
        auth()->user()->notify(new AlmacenNotification('create', $data['nombre']));
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

}
