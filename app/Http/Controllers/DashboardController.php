<?php

namespace App\Http\Controllers;

use App\Models\Movimientos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
{
    // 1. Obtener los datos de las gráficas
    $movimientosPorPeriodo = $this->getMovimientosPorPeriodo($request);
    $topMateriales = $this->getTopMateriales();
    $topTrabajadores = $this->getTopTrabajadores();

    $chartData = [
        'movimientosPorPeriodo' => $movimientosPorPeriodo,
        'topMateriales' => $topMateriales,
        'topTrabajadores' => $topTrabajadores,
    ];


    return view('panel_de_control', compact('chartData'));
}

    public function getMovimientosPorPeriodo(Request $request)
{
    $periodo = $request->get('periodo', 'año'); // Cambiado a 'año' por defecto para la carga inicial
    list($startDate, $endDate) = $this->getFechasPorPeriodo($periodo);

    // 1. Determinar el formato de agrupación y el array de referencia
    $dateSelect = 'fecha_operacion'; // Columna de fecha
    $labelsReferencia = [];
    $groupByRaw = '';

    switch ($periodo) {
        case 'dia':
            // Agrupar por hora (00, 01, ..., 23)
            $groupByRaw = 'HOUR(' . $dateSelect . ')';
            $labelsReferencia = range(0, 23); // Etiquetas de 0 a 23 horas
            break;
        case 'semana':
        case 'mes':
            // Agrupar por día (1, 2, ..., 31)
            $groupByRaw = 'DAY(' . $dateSelect . ')';
            // Crear etiquetas para cada día en el rango
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $labelsReferencia[] = $currentDate->format('d');
                $currentDate->addDay();
            }
            break;
        case 'trimestre':
        case 'año':
        default:
            // Agrupar por mes (1, 2, ..., 12)
            $groupByRaw = 'MONTH(' . $dateSelect . ')';
            $labelsReferencia = range(1, 12); // Etiquetas de 1 a 12 (Enero a Diciembre)
            break;
    }

    // 2. Ejecutar la Consulta
    $movimientos = Movimientos::select(
        DB::raw($groupByRaw . ' as periodo'), // Agrupamos por la unidad de tiempo
        DB::raw('SUM(CASE WHEN tipo_movimiento = 1 THEN cantidad ELSE 0 END) as entradas'),
        DB::raw('SUM(CASE WHEN tipo_movimiento = 2 THEN cantidad ELSE 0 END) as salidas')
    )
    ->whereBetween($dateSelect, [$startDate, $endDate])
    ->groupBy('periodo')
    ->orderBy('periodo', 'ASC')
    ->get();

    // 3. Rellenar con Ceros y Formatear
    
    // Inicializar arrays de datos con ceros (para los períodos que no tienen datos)
    $datosEntradas = array_fill_keys($labelsReferencia, 0.0);
    $datosSalidas = array_fill_keys($labelsReferencia, 0.0);

    foreach ($movimientos as $mov) {
        $periodoKey = (int) $mov->periodo;
        // Asignar el valor asegurando que sea un float
        if (isset($datosEntradas[$periodoKey])) {
             $datosEntradas[$periodoKey] = (float) $mov->entradas;
             $datosSalidas[$periodoKey] = (float) $mov->salidas;
        }
    }
    
    // Si el período es 'año', convertimos los números (1-12) a nombres (ENE-DIC) para la visualización.
    if ($periodo === 'año' || $periodo === 'trimestre') {
         $labelsFinal = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
         // Si es anual, usamos solo 12 meses
         $datosEntradas = array_values($datosEntradas);
         $datosSalidas = array_values($datosSalidas);
    } else {
        // Para día, semana o mes, usamos las claves numéricas (horas o días) como etiquetas.
        $labelsFinal = array_keys($datosEntradas);
        $datosEntradas = array_values($datosEntradas);
        $datosSalidas = array_values($datosSalidas);
    }

    // 4. Devolver la respuesta en formato JSON (necesario para la llamada fetch/AJAX)
    return response()->json([
        'labels' => $labelsFinal,
        'entradas' => $datosEntradas,
        'salidas' => $datosSalidas,
    ]);
}


// Función auxiliar para calcular el rango de fechas
private function getFechasPorPeriodo($periodo)
{
    $now = Carbon::now();
    $startDate = match ($periodo) {
        'dia' => $now->copy()->startOfDay(),
        'semana' => $now->copy()->startOfWeek(),
        'mes' => $now->copy()->startOfMonth(),
        'trimestre' => $now->copy()->startOfQuarter(),
        'año' => $now->copy()->startOfYear(),
        default => $now->copy()->startOfMonth(),
    };
    return [$startDate, $now->copy()->endOfDay()];
}
public function getTopMateriales()
{
    $topMateriales = Movimientos::select(
            'id_material',
            DB::raw('SUM(CASE WHEN tipo_movimiento = "Entrada" THEN cantidad ELSE 0 END) as total_entradas'),
            DB::raw('SUM(CASE WHEN tipo_movimiento = "Salida" THEN cantidad ELSE 0 END) as total_salidas')
        )
        ->groupBy('id_material')
        // Elige el Top 5 basado en la suma total de movimientos (entradas + salidas)
        ->orderByRaw('(SUM(CASE WHEN tipo_movimiento = "Entrada" THEN cantidad ELSE 0 END) + SUM(CASE WHEN tipo_movimiento = "Salida" THEN cantidad ELSE 0 END)) DESC')
        ->limit(5)
        ->with('materiales') // Carga la relación para obtener el nombre
        ->get();

    // Formatear los datos para la gráfica
    $labels = $topMateriales->map(fn($item) => $item->materiales->nombre ?? 'Material Desconocido')->toArray();
    $entradas = $topMateriales->pluck('total_entradas')->toArray();
    $salidas = $topMateriales->pluck('total_salidas')->toArray();

    return [
        'labels' => $labels,
        'entradas' => $entradas,
        'salidas' => $salidas,
    ];
}
public function getTopTrabajadores()
{
    $topTrabajadores = Movimientos::select(
            'id_usuario',
            DB::raw('COUNT(*) as total_movimientos') // Cuenta todos los movimientos realizados
        )
        ->groupBy('id_usuario')
        ->orderBy('total_movimientos', 'DESC')
        ->limit(5)
        ->with('trabajador') // Carga la relación con el modelo User
        ->get();

    // Formatear los datos para la gráfica
    $labels = $topTrabajadores->map(fn($item) => $item->trabajador->name ?? 'Usuario Desconocido')->toArray();
    $data = $topTrabajadores->pluck('total_movimientos')->toArray();

    return [
        'labels' => $labels,
        'data' => $data,
    ];
}
}