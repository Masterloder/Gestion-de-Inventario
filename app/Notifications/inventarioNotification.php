<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use function PHPSTORM_META\map;

class inventarioNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $Nombrematerial;
    protected $cantidad;
    protected $user;
    
    public function __construct($tipo, $Nombrematerial = null, $cantidad = null, $user = null)
    {
        $this->tipo = $tipo;
        $this->Nombrematerial = $Nombrematerial;
        $this->cantidad = $cantidad;
        $this->user = auth()->user()->name ;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toArray($notifiable): array
    {

         $config = match($this->tipo) {
            'Ingreso' => [
                'titulo' => 'Nuevo Movimiento de Inventario',
                'mensaje' => "Se ha registrado el ingreso : {$this->Nombrematerial} - Cantidad: {$this->cantidad} por el usuario: {$this->user}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Movimiento Actualizado',
                'mensaje' => "Cambios Efectuados en: {$this->Nombrematerial} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete' => [
                'titulo' => 'Movimiento Eliminado',
                'mensaje' => "El Movimiento: {$this->Nombrematerial} ha sido eliminado por el usuario: {$this->user}.",
                'icono' => 'bi-trash',
                'color' => 'text-danger'
            ],
            default => [
                'titulo' => 'Notificación del Sistema',
                'mensaje' => 'Acción realizada.',
                'icono' => 'bi-info-circle',
                'color' => 'text-secondary'
            ]
        };
            return $config;
    }
}
