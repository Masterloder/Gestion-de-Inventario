<?php

namespace App\Console\Commands;

use App\Models\Movimientos;
use App\Notifications\inventarioNotification;
use Illuminate\Console\Command;

class CheckMaterialExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-material-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $tiempos = [
        '2 meses' => now()->addMonths(2)->format('Y-m-d'),
        '1 mes'   => now()->addMonth()->format('Y-m-d'),
        '1 semana' => now()->addWeek()->format('Y-m-d'),
    ];

    foreach ($tiempos as $label => $fecha) {
        // Buscamos movimientos o inventarios que venzan exactamente en esas fechas
        $vencimientos = Movimientos::where('fecha_caducidad', $fecha)->get();

        foreach ($vencimientos as $mov) {
            $material = $mov->material; // Asumiendo relación en el modelo
            $usuario = $mov->usuario;   // Usuario que debe recibir la alerta

            $usuario->notify(new inventarioNotification(
                "Alerta: Vencimiento en $label", 
                $material->nombre, 
                $mov->cantidad
            ));
        }
    }
}
}
