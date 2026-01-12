<?php

namespace App\Http\Controllers;
use App\Models\Provedores;
use App\Models\Materiales;
use App\Notifications\MaterialNotification;
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
            'categoria_id' => 'required',
            'categoria_especifica_id' => 'required'
        ]);
        $data = $request->all();
        $material = $this->create($data);
        auth()->user()->notify(new MaterialNotification('create', $material->nombre));
        return redirect()->back()->with('success', 'Material creado exitosamente.');

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    }
    public function create(array $data){

        return Materiales::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'unidad_medida_id' =>$data['unidad_medida'],
            'categoria_id' => $data['categoria_id'],
            'categoria_especifica_id'=> $data['categoria_especifica_id']
        ]);

    }
}

