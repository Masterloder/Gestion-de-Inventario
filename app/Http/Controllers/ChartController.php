<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{

    public function index(){
        





        return view('panel_de_control',[

        ])
    }

    public function GraficaMes()
    {
        // 1. Obtén y formatea los datos (Ejemplo: Ventas por mes)
        // En una aplicación real, harías una consulta Eloquent para agrupar.
        
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May'];
        $ventas_mensuales = [65, 59, 80, 81, 56]; // Tus datos

        $chartData = [
            'labels' => $meses, // Las etiquetas del eje X (ej: meses)
            'datasets' => [
                [
                    'label' => 'Ventas Mensuales', // Etiqueta para el dataset
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $ventas_mensuales, // Los valores de tu gráfica
                    // Puedes añadir más opciones aquí (ej: 'fill' => false para línea)
                ]
                // Puedes añadir más datasets aquí si necesitas múltiples líneas/barras
            ]
        ];

        // 2. Pasa los datos a la vista
        return view('charts.index', compact('chartData'));
    }

}
