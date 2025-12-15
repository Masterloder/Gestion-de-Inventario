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
        $post = Proveedores::select('id','nombre','correo','telefono','direccion')->get();
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

    public function VistaProveedores()
    {
        // Obtener todos los proveedores
        $proveedores = Provedores::with(['materiales', 'materiales.movimientos'])->get();

        
        return view('proveedores.index', compact('proveedores'));
    }

    public function Delete(Request $request)
    {
        $id = $request->query('id');

        // Buscar el proveedor por su ID
        $proveedor = Provedores::find($id);

        if ($proveedor) {
            // Realizar soft delete
            $proveedor->delete();

            return redirect('/Proveedores')->with('success', 'Proveedor eliminado correctamente (soft delete).');
        } else {
            return redirect('/Proveedores')->with('error', 'Proveedor no encontrado.');
        }
    }
}
