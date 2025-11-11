<?php

namespace App\Http\Controllers;
use App\Models\Provedores;
use App\Models\Materiales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Crud_Materiales extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $posts = Materiales::all()
        ->select('id', 'nombre', 'descripcion', 'unidad_medida','categoria','categoria_especifica');
        return $posts;
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function PostMaterial( Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'categoria' => 'required',
            'categoria_especifica'=> 'required'
        ]);
        $data = $request->all();
        $this->create($data);
        return redirect("/panel_de_control/Logistica")->withSuccess('');

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    }
    public function create(array $data){

        return Materiales::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'unidad_medida' =>$data['unidad_medida'],
            'categoria' => $data['categoria'],
            'categoria_especifica'=> $data['categoria_especifica']
        ]);

    }
}

