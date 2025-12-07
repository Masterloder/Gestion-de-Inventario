<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\Movimientos;
use App\Models\Almacenes;
use App\Models\Provedores;
use App\Models\User;
use faker\Factory as faker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class Crud_Movimientos extends Controller
{
    public function index()
    {
        // Si solo necesitas columnas de la tabla 'movimientos':
        $movimientos = Movimientos::select('id', 'id_material', 'id_almacen', 'cantidad', 'fecha_operacion')
            ->get();

        return $movimientos;
    }

    /**
     * Maneja la creación de un nuevo movimiento de INGRESO y actualiza el inventario.
     */
    public function PostMovimientoIngreso(Request $request): RedirectResponse
    {
        $request->validate([
            'id_almacen' => 'required',
            'fecha_operacion' => 'required',
            'id_material' => 'required',
            'ubicacion_entrega' => 'no',
            'cantidad' => 'required|integer|min:1',
            'id_proveedor' => 'required|exists:proveedores,id'
        ]);
        $data1 = $request->all();
        $referencia = $this->generateUniqueReference('Ingreso');
        // 1. Registrar el movimiento de Ingreso
        Movimientos::create([
            'tipo_movimiento'   => 'Entrada', //
            'fecha_operacion'   => $data1['fecha_operacion'],
            'cantidad'          => $data1['cantidad'],
            'numero_referencia' => $referencia,
            'id_material'       => $data1['id_material'],
            'id_proveedor'      => $data1['id_proveedor'],
            'id_almacen'        => $data1['id_almacen'],
            'ubicacion_entrega' => '0',
            'id_usuario'        => auth()->id()
        ]);

        // 2. Actualizar/Crear en el Inventario
        $this->updateOrCreateInventario($data1);

        return redirect("/panel_de_control/Logistica")->withSuccess("Ingreso de material registrado.");
    }

    /**
     * Lógica unificada para actualizar o crear un registro de Inventario (USADO SOLO PARA INGRESO).
     */
    public function updateOrCreateInventario($data1)
    {
        // buscar fila existente por almacen + material
        $inventario = Inventario::where('id_almacen', $data1['id_almacen'])
            ->where('id_material', $data1['id_material'])
            ->first();

        $material = Materiales::find($data1['id_material']);

        // Si no se encuentra el material, lanzamos un error o simplemente detenemos la operación
        if (!$material) {
            throw new \Exception("Material no encontrado.");
        }

        if ($inventario) {
            // sumar cantidad a la columna cantidad_actual
            $inventario->increment('cantidad_actual', $data1['cantidad']);
            return $inventario;
        }

        // si no existe, crear nueva fila
        return Inventario::create([
            'id_material'     => $data1['id_material'],
            'id_almacen'      => $data1['id_almacen'],
            'cantidad_actual' => $data1['cantidad'],
            'punto_reorden'   => '0'
        ]);
    }


    protected function generateUniqueReference(string $tipo_movimiento): string
    {
        $faker = Faker::create();

        // 1. Obtener el último ID de Movimiento para el incremento
        // Usamos el ID de la tabla como base para asegurar la unicidad del segmento ####.
        // Aunque no es un contador perfecto, garantiza un número único.
        $lastMovementId = Movimientos::max('id') ?? 0;
        $nextId = $lastMovementId + 1;

        // 2. Formatear el segmento incremental (ej: 0001, 0002)
        $incrementalSegment = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // 3. Crear el segmento aleatorio (4 caracteres alfanuméricos)
        // El bothify crea una cadena como 'aBc-123' usando '#'=dígitos y '?'=letras
        $randomSegment = $faker->bothify('####');

        // 4. Estandarizar el tipo de movimiento para la referencia
        $typeSegment = strtoupper(substr($tipo_movimiento, 0, 3)); // ING o SAL

        // 5. Construir la referencia completa: MOV-####-TIPO-$$$$
        $reference = "MOV-{$incrementalSegment}-{$typeSegment}-{$randomSegment}";

        return $reference;
    }




    /**
     * Maneja la creación de un nuevo movimiento de SALIDA y actualiza el inventario.
     */
    public function MovimientoSalida(Request $request): RedirectResponse
    {
        // validar aquí que la cantidad a sacar no exceda la cantidad en inventario.
        $request->validate([
            'id_almacen1' => 'required',
            'fecha_operacion' => 'required',
            'ubicacion_entrega' => 'required',
            'id_material1' => 'required',
            'cantidad' => 'required'
        ]);
        
        $data = $request->all();
        $referencia = $this->generateUniqueReference('Salida');
        // 1. Actualizar el Inventario (restando)
        $result = $this->decrementInventario($data);
        if (!$result) {
            return redirect("/Movimientos/tabla")->withErrors("Stock insuficiente en el almacén seleccionado.");
        }
                // 2. Registrar el movimiento de Salida
        Movimientos::create([
            'tipo_movimiento'   => 'Salida', // Correcto: Salida
            'fecha_operacion'   => $data['fecha_operacion'],
            'cantidad'          => $data['cantidad'],
            'numero_referencia' => $referencia, 
            'id_material'       => $data['id_material1'],
            'id_proveedor'      => null, // La salida no requiere proveedor
            'id_almacen'        => $data['id_almacen1'],
            'destino'           => $data['ubicacion_entrega'],
            'id_usuario'        => auth()->id()
        ]);

        return redirect("/Movimientos/tabla")->withSuccess("Salida de material registrada.");
    }
        //salida con el material seleccionado automaticamente
     public function MovimientoSalida2(Request $request): RedirectResponse
    {
        
        // validar aquí que la cantidad a sacar no exceda la cantidad en inventario.
        $request->validate([
            'id_almacen1' => 'required',
            'fecha_operacion' => 'required',
            'id_material1' => 'required',
            'cantidad' => 'required'
        ]);
        $data = $request->all();
        $referencia = $this->generateUniqueReference('Salida');
        // 1. Actualizar el Inventario (restando)
        $result = $this->decrementInventario($data);
        if (!$result) {
            return redirect("/Movimientos/tabla")->withErrors("Stock insuficiente en el almacén seleccionado.");
        }
        
                // 2. Registrar el movimiento de Salida
        Movimientos::create([
            'tipo_movimiento'   => 'Salida', // Correcto: Salida
            'fecha_operacion'   => $data['fecha_operacion'],
            'cantidad'          => $data['cantidad'],
            'numero_referencia' => $referencia, // Cambiar ref
            'id_material'       => $data['id_material1'],
            'id_proveedor'      => null, // La salida no requiere proveedor
            'id_almacen'        => $data['id_almacen1'],
            'destino'           => null,
            'id_usuario'        => auth()->id()
        ]);

        return redirect("/Movimientos/tabla")->withSuccess("Salida de material registrada.");
    }

    /**
     * Lógica para restar cantidad del Inventario (USADO SOLO PARA SALIDA).
     */
    public function decrementInventario($data)
    {
        // buscar fila existente por almacen + material
        $inventario = Inventario::where('id_almacen', $data['id_almacen1'])
            ->where('id_material', $data['id_material1'])
            ->first();

        // No se puede sacar stock si no existe la fila.
        if (!$inventario) {
            return false; // Stock insuficiente / No existe
        }

        //Validar que haya suficiente stock antes de restar
        if ($inventario->cantidad_actual < $data['cantidad']) {
            return false; // Stock insuficiente
        }

        // resta cantidad a la columna cantidad_actual
        $inventario->decrement('cantidad_actual', $data['cantidad']);
        return $inventario;
    }

    public function vistaAlmacen()
    {
        // 1. Traer Almacenes
        $almacenes = Almacenes::all();

        // 2. Traer Inventario con Materiales (Eager Loading)
        $inventario = Inventario::with('material')->get();

        // 3. Preparar mapa para JavaScript
        $mapaInventario = $inventario->mapWithKeys(function ($item) {
            return [
                $item->id_material => [ // La clave será el ID del material
                    'cantidad_actual' => $item->cantidad_actual,
                    'unidad_medida'   => $item->material->unidad_medida ?? ''
                ]
            ];
        });

        // 4. Enviar a la vista
        return view('/movimientos', compact('almacenes', 'inventario', 'mapaInventario'));
    }

    public function update(Request $request, Movimientos $movimiento)
    {
        $request->validate([
            // 'id_material' debe existir en la tabla 'materiales'
            'id_material'       => 'required|exists:materiales,id',
            // 'id_usuario' debe existir en la tabla 'users' (o la tabla de tus trabajadores)
            'id_usuario'      => 'required|exists:users,id',
            // 'cantidad' debe ser un número entero, requerido y mayor que 0
            'cantidad'          => 'required|integer|min:1',
            // 'numero_referencia' es opcional y debe ser una cadena de máximo 50 caracteres
            'numero_referencia'     => 'nullable|string|max:50',
        ], [
            // Mensajes de error personalizados para mejor UX
            'id_material.required' => 'Debes seleccionar un material.',
            'id_material.exists'   => 'El material seleccionado no es válido.',
            'id_usuario.required'  => 'Debes seleccionar un trabajador.',
            'id_usuario.exists'    => 'El trabajador seleccionado no es válido.',
            'cantidad.required'    => 'La cantidad es obligatoria.',
            'cantidad.integer'     => 'La cantidad debe ser un número entero.',
            'cantidad.min'         => 'La cantidad debe ser al menos 1.',
        ]);
        
        // 2. Actualización del Movimiento
        try {
            $movimiento->update([
                'id_material'       => $request->id_material,
                'id_usuario'        => $request->id_usuario,
                'cantidad'          => $request->cantidad,
                'numero_referencia' => $request->numero_referencia,
                // Puedes agregar otros campos aquí si son necesarios
            ]);
            
            // 3.Redirección con Mensaje de Éxito
            return redirect()->route('movimientos.index') // O la ruta que uses para la tabla principal
                             ->with('success', 'El movimiento se ha actualizado correctamente.');

        } catch (\Exception $e) {
            
            return back() // Vuelve al formulario
                ->withInput() // Mantiene los datos que el usuario ingresó
                ->with('error', 'Ocurrió un error al intentar actualizar el movimiento. Por favor, inténtalo de nuevo.');
        }
    }
    


    public function destroy(Movimientos $movimiento)
    {
        // Soft delete: establece la columna 'deleted_at'
        $movimiento->delete();

        return redirect()->route('/Movimientos/tabla')->with('success', 'Movimiento eliminado (Soft Delete) correctamente.');
    }



    public function Movimientos()
    {
        //Carga Anticipada (Eager Loading) de las 4 relaciones
        $movimientos = Movimientos::with([
            'tipoMovimiento',
            'materiales',
            'almacenes',
            'trabajador',
            'destino'
        ])->orderBy('fecha_operacion', 'desc')->get(); // Ordenar por fecha

        // Datos para el formulario (modal)
        $almacenes = Almacenes::all(['id', 'nombre', 'direccion']);
        $proveedores = Provedores::all(['id', 'nombre', 'correo', 'telefono']);
        $materiales = Materiales::all(['id', 'nombre', 'unidad_medida', 'categoria', 'categoria_especifica']);
        $trabajadores = User::all(['id', 'name']);

        //Obtener el inventario completo, con Eager Loading, que es la fuente de verdad.
        // Solo incluimos items con cantidad_actual > 0
        $inventario = Inventario::with(['material', 'almacen'])
            ->where('cantidad_actual', '>', 0)
            ->get();

        $mapaInventario = $inventario->mapWithKeys(function ($item) {
            // La clave única es la combinación del material y el almacén
            $key = "{$item->id_material}-{$item->id_almacen}";

            return [$key => [
                'cantidad_actual' => $item->cantidad_actual,
                'unidad_medida'   => $item->material->unidad_medida ?? '',
            ]];
        });

        // Pasamos la colección optimizada a la vista.
        return view('/Movimientos', compact(
            'movimientos',
            'mapaInventario',
            'almacenes',
            'proveedores',
            'materiales',
            'inventario',
            'trabajadores'
        ));
    }
}
