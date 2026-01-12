<?php

namespace App\Http\Controllers;

use App\Models\Materiales;
use App\Models\Movimientos;
use App\Models\Provedores;
use App\Models\Proveedores;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Crud_Proveedor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Proveedores::select('id', 'nombre', 'correo', 'telefono', 'direccion')->get();
        return $post;
    }

    public function PostProveedor(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'
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

    public function VistaProveedores()
    {
        // Carga los proveedores con sus suministros agrupados y las relaciones de los materiales
        $proveedores = Provedores::with('suministrosAgrupados.materiales.categoria', 'suministrosAgrupados.materiales.categoriaEspecifica')->get();

        return view('proveedores.index', compact('proveedores'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255'
        ]);

        $proveedor = Provedores::find($id);

        if ($proveedor) {
            $proveedor->update([
                'nombre' => $request->input('nombre'),
                'correo' => $request->input('correo'),
                'telefono' => $request->input('telefono'),
                'direccion' => $request->input('direccion')
            ]);
            return redirect()->to('/Proveedores')->with('success', 'Proveedor actualizado correctamente.');
        } else {
            return redirect()->to('/Proveedores')->with('error', 'Proveedor no encontrado.');
        }
    }

    public function Delete($id) // Recibe el $id directamente aquí
{
    // Buscar el proveedor por el ID recibido en la ruta
    $proveedor = Provedores::find($id);

    if ($proveedor) {
        $proveedor->delete(); // Ejecuta el Soft Delete
        return redirect()->to('/Proveedores')->with('success', 'Proveedor eliminado correctamente (soft delete).');
    } else {
        return redirect()->to('/Proveedores')->with('error', 'Proveedor no encontrado.');
    }
}
}
