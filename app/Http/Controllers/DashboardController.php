<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos simulados (Arrays que pasaríamos a la vista)
        $chartData = [
            'performance' => [100, 70, 90, 70, 85, 60, 75, 60, 90, 80, 110, 100], // Enero-Dic
            'shipments'   => [80, 100, 70, 80, 120, 80], // Jul-Dec
            'dailySales'  => [53, 20, 10, 80, 100, 45],  // USA, GER, AUS, UK, RO, BR
            'tasks'       => [90, 27, 60, 12, 20],       // Jul-Nov
        ];

        return view('panel_de_control', compact('chartData'));
    }
}