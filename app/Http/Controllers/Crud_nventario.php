<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use App\Models\Inventario;
use App\Models\Provedores;
use App\Models\Materiales;
use App\Models\UnidadMedida;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Salida;
use App\Models\MaterialAlmacen;
use App\Notifications\inventarioNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $material = Materiales::find($data['id_material']);
        auth()->user()->notify(new inventarioNotification('Ingreso', Materiales::find($material->nombre_material, $data['cantidad_actual'], auth()->user()->name)));
        return redirect()->back()->with('success', 'El material ha sido agregado al inventario correctamente.');

        /**
         * Almacena un recurso  creado en el almacenamiento.
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


        // Realizamos la consulta con todas las relaciones necesarias
        $materialesArray = Materiales::with([
            'unidadMedida:id,nombre_unidad,simbolo',
            'categoria:id,nombre_categoria',
            'categoriaEspecifica:id,nombre_especifico'
        ])
            ->get()
            ->toArray(); // Convierte la colección y sus relaciones en un solo array

        $materiales = collect($materialesArray);

        $unidades = UnidadMedida::all(['id', 'nombre_unidad', 'simbolo']);
        $categorias = CategoriaMaterial::with('categoriasEspecificas')->get();
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
            'unidades' => $unidades,
            'categorias' => $categorias,
        ]);
    }

    public function destroy($id) // Recibimos el ID de la ruta
{
    try {
        // 1. Buscamos el registro
        $inventario = Inventario::findOrFail($id);

        // 2. Ejecutamos el delete (Laravel detectará automáticamente el SoftDelete si el modelo lo tiene)
        $inventario->delete();

        // 3. Redirección usando el NOMBRE de la ruta (logistica.index)
        return redirect()->route('logistica.index')
            ->with('warning', 'El registro #' . $id . ' ha sido marcado como baja.');

    } catch (\Exception $e) {
        return back()->with('error', 'No se pudo eliminar: ' . $e->getMessage());
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'cantidad_actual' => 'required|numeric|min:0',
        'id_almacen' => 'required|exists:almacenes,id',
        'ubicacion_fisica' => 'nullable|string|max:255',
    ]);

    $inventario = Inventario::findOrFail($id);

    $inventario->cantidad_actual = $request->input('cantidad_actual');
    $inventario->id_almacen = $request->input('id_almacen');
    $inventario->ubicacion_fisica = $request->input('ubicacion_fisica');
    $inventario->save();

    return redirect()->to('/panel_de_control/Logistica')
        ->with('success', 'El registro de inventario ha sido actualizado correctamente.');
}
}
