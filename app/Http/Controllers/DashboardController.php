<?php

namespace App\Http\Controllers;

use App\Models\Movimientos;
use App\Models\Materiales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Definimos el periodo por defecto para la carga inicial
       $periodo = $request->get('periodo', 'año');

        $chartData = [
            'movimientos' => $this->procesarMovimientos($periodo),
            'topMateriales' => $this->getTopMateriales(),
            'topTrabajadores' => $this->getTopTrabajadores(),
            'materialesExpirar' => $this->getMaterialesPorExpirar(),
        ];

        return view('panel_de_control', compact('chartData'));
    }

    /**
     * Endpoint para peticiones AJAX de la gráfica principal
     */
    public function getMovimientosAjax(Request $request)
    {
        $periodo = $request->get('periodo', 'año');
        return response()->json($this->procesarMovimientos($periodo));
    }

    private function procesarMovimientos($periodo)
    {
        list($startDate, $endDate) = $this->getIntervaloFechas($periodo);
        $dateSelect = 'fecha_operacion'; // Asegúrate que esta columna existe en tu DB
        
        // Configuración de agrupación según el periodo
        switch ($periodo) {
            case 'dia':
                $groupByRaw = "HOUR($dateSelect)";
                $labelsReferencia = range(0, 23);
                break;
            case 'semana':
            case 'mes':
                $groupByRaw = "DAY($dateSelect)";
                $labelsReferencia = [];
                $current = $startDate->copy();
                while ($current <= $endDate) {
                    $labelsReferencia[] = (int)$current->format('d');
                    $current->addDay();
                }
                break;
            case 'año':
            default:
                $groupByRaw = "MONTH($dateSelect)";
                $labelsReferencia = range(1, 12);
                break;
        }

        $movimientos = Movimientos::select(
            DB::raw($groupByRaw . ' as periodo_eje'),
            DB::raw('SUM(CASE WHEN tipo_movimiento = 1 THEN cantidad ELSE 0 END) as entradas'),
            DB::raw('SUM(CASE WHEN tipo_movimiento = 2 THEN cantidad ELSE 0 END) as salidas')
        )
        ->whereBetween($dateSelect, [$startDate, $endDate])
        ->groupBy('periodo_eje')
        ->get();

        // Mapear resultados a las etiquetas de referencia para evitar huecos en la gráfica
        $datosEntradas = array_fill_keys($labelsReferencia, 0);
        $datosSalidas = array_fill_keys($labelsReferencia, 0);

        foreach ($movimientos as $mov) {
            $key = (int)$mov->periodo_eje;
            if (isset($datosEntradas[$key])) {
                $datosEntradas[$key] = (float)$mov->entradas;
                $datosSalidas[$key] = (float)$mov->salidas;
            }
        }

        return [
            'labels' => $this->formatearEtiquetas($labelsReferencia, $periodo),
            'entradas' => array_values($datosEntradas),
            'salidas' => array_values($datosSalidas),
        ];
    }

    private function getMaterialesPorExpirar()
    {
        return DB::table('materiales')
            ->join('inventario', 'materiales.id', '=', 'inventario.id_material')
            ->select('materiales.nombre', 'inventario.cantidad_actual', 'materiales.fecha_caducidad')
            ->where('materiales.fecha_caducidad', '<=', now()->addDays(30))
            ->orderBy('materiales.fecha_caducidad', 'asc')
            ->get();
    }

    public function getTopMateriales()
    {
        $top = Movimientos::select(
            'id_material',
            DB::raw('SUM(CASE WHEN tipo_movimiento = 1 THEN cantidad ELSE 0 END) as total_entradas'),
            DB::raw('SUM(CASE WHEN tipo_movimiento = 2 THEN cantidad ELSE 0 END) as total_salidas')
        )
        ->groupBy('id_material')
        ->orderByRaw('(SUM(cantidad)) DESC')
        ->limit(5)
        ->with('materiales') 
        ->get();

        return [
            'labels' => $top->map(fn($item) => $item->materiales->nombre ?? 'N/A')->toArray(),
            'entradas' => $top->pluck('total_entradas')->toArray(),
            'salidas' => $top->pluck('total_salidas')->toArray(),
        ];
    }

    public function getTopTrabajadores()
    {
        $top = Movimientos::select('id_usuario', DB::raw('COUNT(*) as total'))
            ->groupBy('id_usuario')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->with('trabajador')
            ->get();

        return [
            'labels' => $top->map(fn($item) => $item->trabajador->name ?? 'Anonimo')->toArray(),
            'data' => $top->pluck('total')->toArray(),
        ];
    }

    // --- MÉTODOS DE APOYO ---

    private function getIntervaloFechas($periodo)
    {
        return match($periodo) {
            'dia' => [now()->startOfDay(), now()->endOfDay()],
            'semana' => [now()->startOfWeek(), now()->endOfWeek()],
            'mes' => [now()->startOfMonth(), now()->endOfMonth()],
            'año' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }

    private function formatearEtiquetas($labels, $periodo)
    {
        if ($periodo === 'año') {
            $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            return array_map(fn($m) => $meses[$m - 1], $labels);
        }
        return $labels;
    }
}