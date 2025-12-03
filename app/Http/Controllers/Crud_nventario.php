<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Inventario;
use App\Models\Provedores;
use App\Models\Materiales;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Crud_nventario extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $posts = Inventario::all()
            ->select('id', 'id_material', 'id_almacen', 'cantidad_actual', 'unidad_medida', 'ubicacion_fisica');
        return $posts;
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function PostInventario(Request $request): RedirectResponse
    {
        $request->validate([
            'id_material' => 'required',
            'id_almacen' => 'required',
            'cantidad_actual' => 'cantidad_actual',
            'unidad_medida' => 'required',
            'ubicacion_fisica' => 'required'
        ]);
        $data = $request->all();
        $this->create($data);
        return redirect("/panel_de_control/Logistica")->withSuccess('');

        /**
         * Almacena un recurso recién creado en el almacenamiento.
         */
    }
    public function create(array $data)
    {

        return Materiales::create([
            'id_material' => $data['id_material'],
            'id_almacen' => $data['id_almacen'],
            'unidad_medida' => $data['unidad_medida'],
            'ubicacion_fisica' => $data['ubicacion_fisica']
        ]);
    }

    public function VistaInventario()
    {

        $almacenes = Almacenes::all(['id', 'nombre', 'direccion']);
        $materiales = Materiales::all(['id', 'nombre', 'descripcion', 'unidad_medida', 'categoria', 'categoria_especifica']);
        $trabajadores = User::all(['id', 'name']);
        
        $inventario = Inventario::with('material')->get();

        //Obtener el inventario completo, con Eager Loading, que es la fuente de verdad.
        // Solo incluimos items con cantidad_actual > 0
        // En tu controlador
        $mapaInventario = $inventario->mapWithKeys(function ($item) {
            // La clave debe coincidir con data-inventario-key: material_id-almacen_id
            return ["{$item->id_material}-{$item->id_almacen}" => [
                'cantidad_actual' => $item->cantidad_actual,
                'unidad_medida' => $item->material->unidad_medida ?? '',
            ]];
        });

        return view('/logistica', [
            'inventario' => $inventario,
            'almacenes' => $almacenes,
            'mapaInventario' => $mapaInventario,
            'materiales' => $materiales,
            'trabajadores' => $trabajadores,
        ]);
    }
}
