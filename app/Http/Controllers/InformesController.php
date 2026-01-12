<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimientos;
use App\Models\Materiales;
use App\Models\Provedores;
use App\Models\Proveedor;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\DB;

class InformesController extends Controller

{

    public function index()
    {
        return $this->generarDataInforme(new Request(), 'mes');
    }

    public function guardarInforme(Request $request)
    {
        // 1. Datos
        $data = $this->generarDataInforme($request, 'mes');

        // 2. HTML
        $html = view('Informes.Informes', compact('data'))->render();

        // 3. Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        // 4. Guardado Físico
        $pdfContenido = $dompdf->output();
        $nombreArchivo = 'reporte_' . time() . '.pdf';

        // Esto lo guarda en storage/app/public/pdf/
        file_put_contents(public_path("uploads/$nombreArchivo"), $pdfContenido);

        return response()->json([
            'mensaje' => 'PDF guardado con éxito',
            'ruta' => "/storage/pdf/$nombreArchivo"
        ]);
    }
    public function InformeDiario(Request $request)
    {
        return $this->generarDataInforme($request, 'dia');
    }
    public function InformeSemanal(Request $request)
    {
        return $this->generarDataInforme($request, 'semana');
    }
    public function InformeMensual(Request $request)
    {
        return $this->generarDataInforme($request, 'mes');
    }
    public function InformeTrimestral(Request $request)
    {
        return $this->generarDataInforme($request, 'trimestre');
    }
    public function InformeAnual(Request $request)
    {
        return $this->generarDataInforme($request, 'año');
    }

    private function generarDataInforme(Request $request, $periodo)
    {
        list($startDate, $endDate) = $this->getFechasPorPeriodo($periodo);

        // 1. PRODUCTOS DE MAYOR INGRESO
        $productos = Materiales::with(['categoria', 'categoriaEspecifica'])
            // 1. Suma de Entradas
            ->withSum(['movimientos as total_ingresados' => function ($query) use ($startDate, $endDate) {
                $query->where('tipo_movimiento', 1)
                    ->whereBetween('fecha_operacion', [$startDate, $endDate]);
            }], 'cantidad')

            // 2. Suma de Salidas
            ->withSum(['movimientos as total_despachados' => function ($query) use ($startDate, $endDate) {
                $query->where('tipo_movimiento', 2)
                    ->whereBetween('fecha_operacion', [$startDate, $endDate]);
            }], 'cantidad')

            // 3. Filtrar para que solo aparezcan materiales con movimientos en este periodo
            ->havingRaw('total_ingresados > 0 OR total_despachados > 0')

            // 4. ORDENAR por la cantidad mayor (Entradas por defecto)
            // Nota: Si prefieres ordenar por Salidas, cambia a 'total_despachados'
            ->orderByDesc('total_ingresados')

            ->limit(7)
            ->get();

        // 2. NUEVO: MAYOR MOVIMIENTOS
        // Obtenemos los movimientos individuales más grandes del periodo
        $movimientos = Movimientos::with(['materiales.categoria'])
            ->whereBetween('fecha_operacion', [$startDate, $endDate])
            ->whereHas('materiales') // Asegura que el movimiento tenga materiales asociados
            ->orderBy('fecha_operacion', 'DESC') // Ordenar por fecha ayuda a ver si el filtro falla
            ->orderBy('cantidad', 'DESC')
            ->limit(5)
            ->get();
        // Consulta personalizada para obtener más detalles
        $reporte = DB::table('movimientos_inventario as m')
            ->join('materiales as mat', 'm.id_material', '=', 'mat.id')
            // El error indica que aquí usaste 'ce.categorias_especifica'
            ->join('categorias_especificas as ce', 'mat.categoria_especifica_id', '=', 'ce.id')
            ->join('categorias_materiales as cm', 'ce.categoria_id', '=', 'cm.id')
            ->select(
                'mat.nombre as material', // Verificado en el error
                'cm.nombre_categoria as categoria_general', // Verificado en
                'ce.nombre_especifico as subcategoria', // CAMBIO AQUÍ: Usar nombre_especifico
                'm.tipo_movimiento',
                'm.numero_referencia',
                'm.cantidad',
                'm.fecha_operacion'
            )
            ->orderBy('m.cantidad', 'desc')
            ->limit(5)
            ->get();

        // 3. PROVEEDORES (Corregido para usar el modelo Provedores correctamente)
        // Consultamos desde el modelo Provedores para obtener sus datos (Nombre, Correo, etc.)
        $proveedores = Provedores::withCount(['movimientos1 as total_ingresos' => function ($q) use ($startDate, $endDate) {
            $q->where('tipo_movimiento', 1) // 1 = Entrada/Ingreso
                ->whereBetween('fecha_operacion', [$startDate, $endDate]);
        }])
            // Ordenamos por el conteo que acabamos de generar
            ->orderByDesc('total_ingresos')
            // Opcional: solo traer los que tienen al menos 1 ingreso
            ->having('total_ingresos', '>', 0)
            ->limit(5)
            ->get();

        // 4. TRABAJADORES
        $trabajadores = User::withCount(['movimientos as ingresos_totales' => function ($q) use ($startDate, $endDate) {
            $q->where('tipo_movimiento', 1)->whereBetween('fecha_operacion', [$startDate, $endDate]);
        }])
            ->withCount(['movimientos as despachos_totales' => function ($q) use ($startDate, $endDate) {
                $q->where('tipo_movimiento', 2)->whereBetween('fecha_operacion', [$startDate, $endDate]);
            }])
            ->limit(5)
            ->get()
            ->map(function ($user) use ($startDate, $endDate) {
                // Buscar el nombre del material con más ingresos para este usuario
                $user->material_con_mayor_ingreso = Movimientos::where('id_usuario', $user->id)
                    ->where('tipo_movimiento', 1)
                    ->whereBetween('fecha_operacion', [$startDate, $endDate])
                    ->join('materiales', 'movimientos_inventario.id_material', '=', 'materiales.id')
                    ->select('materiales.nombre', DB::raw('COUNT(*) as total'))
                    ->groupBy('materiales.nombre')
                    ->orderBy('total', 'desc')
                    ->first()->nombre ?? 'N/A';

                // Buscar el nombre del material con más despachos para este usuario
                $user->material_con_mayor_despacho = Movimientos::where('id_usuario', $user->id)
                    ->where('tipo_movimiento', 2)
                    ->whereBetween('fecha_operacion', [$startDate, $endDate])
                    ->join('materiales', 'movimientos_inventario.id_material', '=', 'materiales.id')
                    ->select('materiales.nombre', DB::raw('COUNT(*) as total'))
                    ->groupBy('materiales.nombre')
                    ->orderBy('total', 'desc')
                    ->first()->nombre ?? 'N/A';

                return $user;
            });

        $topMateriales = Materiales::select('id', 'nombre')
            ->withSum(['movimientos as total_movido' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('fecha_operacion', [$startDate, $endDate]);
            }], 'cantidad')
            ->orderByDesc('total_movido')
            ->limit(5)
            ->get();

        // Asegúrate de incluir 'movimientos' en el compact
        $data = compact('productos', 'proveedores', 'movimientos', 'reporte', 'trabajadores', 'periodo', 'topMateriales');

        $html = view('Informes.Informes', compact('productos', 'proveedores', 'movimientos', 'reporte', 'trabajadores', 'periodo', 'topMateriales'))->render();

        // 3. Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        // 4. Guardado Físico
        $pdfContenido = $dompdf->output();
        $nombreArchivo = 'reporte_' . $periodo . time() . '.pdf';

        // Esto lo guarda en storage/app/public/pdf/
        file_put_contents(public_path("uploads/$nombreArchivo"), $pdfContenido);
        return view('Informes.Informes', $data);
    }

    private function getFechasPorPeriodo(string $periodo): array
    {
        // Usamos immutable para no preocuparnos por mutaciones accidentales
        $now = \Carbon\CarbonImmutable::now();

        $startDate = match ($periodo) {
            'dia'       => $now->startOfDay(),
            'semana'    => $now->startOfWeek(),
            'mes'       => $now->startOfMonth(),
            'trimestre' => $now->startOfQuarter(),
            'año', 'year' => $now->startOfYear(),
            default     => $now->startOfMonth(),
        };

        // Retornamos el rango: desde el inicio del periodo hasta el final de hoy
        return [$startDate, $now->endOfDay()];
    }
}
