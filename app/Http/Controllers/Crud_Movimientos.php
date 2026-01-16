<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Models\Inventario;
use App\Models\Materiales;
use App\Models\Movimientos;
use App\Models\Almacenes;
use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use App\Models\Provedores;
use App\Models\UnidadMedida;
use App\Models\User;
use App\Notifications\inventarioNotification;
use faker\Factory as faker;
use Illuminate\Support\Facades\DB;
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
            'id_almacen'        => 'required',
            'fecha_operacion'   => 'required',
            'id_material'       => 'required',
            'cantidad'          => 'required|integer|min:1',
            'id_proveedor'      => 'required|exists:proveedores,id',
            'fecha_caducidad'   => 'nullable|date|after:today' // Validación de la nueva fecha
        ]);

        $data1 = $request->all();
        $referencia = $this->generateUniqueReference('Ingreso');

        // 1. Registrar el movimiento de Ingreso
        Movimientos::create([
            'tipo_movimiento'   => 'Entrada',
            'fecha_operacion'   => $data1['fecha_operacion'],
            'fecha_caducidad'   => $data1['fecha_caducidad'] ?? null, // Guardamos la fecha
            'cantidad'          => $data1['cantidad'],
            'numero_referencia' => $referencia,
            'id_material'       => $data1['id_material'],
            'id_proveedor'      => $data1['id_proveedor'],
            'id_almacen'        => $data1['id_almacen'],
            'ubicacion_entrega' => '0',
            'id_usuario'        => auth()->id()
        ]);

        $material = Materiales::find($request['id_material']);

        // Notificación inmediata de ingreso
        // 2. Actualizar/Crear en el Inventario
        $this->updateOrCreateInventario($data1);

        return redirect("/panel_de_control/Logistica")->withSuccess("Ingreso de material registrado correctamente.");
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

        auth()->user()->notify(new inventarioNotification('update', $material->nombre, $data1['cantidad']));
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
        auth()->user()->notify(new inventarioNotification('Salida', '', $data['cantidad']));
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
            'id_material'       => 'required|exists:materiales,id',
            'id_usuario'        => 'required|exists:users,id',
            'cantidad'          => 'required|integer|min:1',
            'numero_referencia' => 'nullable|string|max:50',
        ]);

        // Usamos una transacción para asegurar que el movimiento y el inventario se actualicen juntos
        DB::beginTransaction();

        try {
            $inventario = Inventario::where('id_material', $movimiento->id_material)
                ->where('id_almacen', $movimiento->id_almacen)
                ->first();

            if (!$inventario) {
                return back()->withInput()->with('error', 'No existe un registro de inventario para este material en este almacén.');
            }

            $cantidadAnterior = $movimiento->cantidad;
            $cantidadNueva = $request->cantidad;
            $diferencia = $cantidadNueva - $cantidadAnterior;

            // Lógica según el TIPO de movimiento (Entrada o Salida)
            // Asumiendo que tienes un campo 'tipo' o 'tipo_movimiento'
            if ($movimiento->tipo == 'Entrada') {
                // Si es ENTRADA y la diferencia es positiva, sumamos al inventario.
                // Si es negativa, estamos reduciendo la entrada, por lo tanto restamos.
                $nuevoStockSimulado = $inventario->cantidad_actual + $diferencia;
            } else {
                // Si es SALIDA y la diferencia es positiva, estamos sacando MÁS (restamos al inventario).
                // Si es negativa, estamos sacando MENOS (devolvemos al inventario).
                $nuevoStockSimulado = $inventario->cantidad_actual - $diferencia;
            }

            // VALIDACIÓN DE STOCK: No podemos dejar el inventario en negativo
            if ($nuevoStockSimulado < 0) {
                return back()->withInput()->with('error', 'Error: No hay suficiente stock para realizar este ajuste. El inventario quedaría en: ' . $nuevoStockSimulado);
            }

            // Aplicamos el cambio al inventario
            $inventario->cantidad_actual = $nuevoStockSimulado;
            $inventario->save();

            // Actualizamos el movimiento
            $movimiento->update([
                'id_material'       => $request->id_material,
                'id_usuario'        => $request->id_usuario,
                'cantidad'          => $request->cantidad,
                'numero_referencia' => $request->numero_referencia,
            ]);

            DB::commit();

            // Notificación
            $material = Materiales::find($request->id_material);
            auth()->user()->notify(new inventarioNotification('update', $material->nombre, $request->cantidad));

            return redirect()->to('/Movimientos/tabla')
                ->with('success', 'El movimiento y el inventario se han actualizado correctamente.');
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Ocurrió un error: ' . $ex->getMessage());
        }
    }



    public function destroy($id)
    {
        // Buscar el movimiento por ID
        $movimiento = Movimientos::findOrFail($id);

        // Soft delete: establece la columna 'deleted_at'
        $movimiento->delete();
        auth()->user()->notify(new inventarioNotification('Eliminación', '', $movimiento->cantidad));
        return redirect()->to('/Movimientos/tabla')->with('success', 'Movimiento eliminado (Soft Delete) correctamente.');
    }



    public function Movimientos()
    {
        // 1. Paginación y Carga Anticipada (Eager Loading)
        // Usamos paginate para no cargar miles de registros de golpe
        $movimientos = Movimientos::with([
            'tipoMovimiento',
            'materiales',
            'almacenes',
            'trabajador',
            'destino'
        ])
            ->orderBy('fecha_operacion', 'desc')
            ->paginate(15);

        // 2. Datos para selects (Traemos solo ID y Nombre para ligereza)
        $almacenes = Almacenes::select('id', 'nombre', 'direccion')->get();
        $proveedores = Provedores::select('id', 'nombre', 'correo', 'telefono')->get();
        $materiales = Materiales::with(['categoria', 'categoriaEspecifica', 'unidadMedida'])
            ->select('id', 'nombre', 'unidad_medida_id', 'categoria_id', 'categoria_especifica_id')
            ->get();
        $trabajadores = User::select('id', 'name')->get();

        // 3. Inventario y Mapa (Fuente de verdad para validaciones en el frontend)
        $inventario = Inventario::with(['material:id,unidad_medida_id', 'almacen:id,nombre'])
            ->where('cantidad_actual', '>', 0)
            ->get();

        $mapaInventario = $inventario->mapWithKeys(function ($item) {
            return ["{$item->id_material}-{$item->id_almacen}" => [
                'cantidad_actual' => $item->cantidad_actual,
                'unidad_medida'   => $item->material->unidad_medida ?? 'N/A',
            ]];
        });



        // 4. Retorno a la vista
        return view('Movimientos', compact(
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
