<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class movimientoNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $movimiento;
    protected $user;

    // Recibimos el tipo (update, delete, create) y el nombre del usuario
    public function __construct($tipo, $movimiento, $user = null)
    {
        $this->tipo = $tipo;
        $this->movimiento = $movimiento;
        $this->user = auth()->user()->name ;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        // Lógica para decidir el mensaje según el tipo
        $config = match($this->tipo) {
            'create' => [
                'titulo' => 'Nuevo Movimiento',
                'mensaje' => "Se ha registrado el Movimiento: {$this->movimiento} por el usuario: {$this->user}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Movimiento Actualizado',
                'mensaje' => "Cambios Efectuados en: {$this->movimiento} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'Eliminacion' => [
                'titulo' => 'Movimiento Eliminado',
                'mensaje' => "El Movimiento: {$this->movimiento} ha sido eliminado por el usuario {$this->user}.",
                'icono' => 'bi-trash',
                'color' => 'text-danger'
            ],
            'Actualización' => [
                'titulo' => 'Movimiento Actualizado',
                'mensaje' => "El Movimiento: {$this->movimiento} ha sido actualizado por el usuario {$this->user}.",
                'icono' => 'bi-arrow-repeat',
                'color' => 'text-warning'
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
