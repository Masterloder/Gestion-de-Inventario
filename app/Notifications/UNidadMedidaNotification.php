<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UNidadMedidaNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $unidadMedida;
    protected $user;

    public function __construct($tipo, $unidadMedida)
    {
        $this->tipo = $tipo;
        $this->unidadMedida = $unidadMedida;
        $this->user = auth()->user()->name ;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $config = match($this->tipo) {
            'create' => [
                'titulo' => 'Nueva Unidad de Medida',
                'mensaje' => "Se ha registrado la Unidad de Medida: {$this->unidadMedida} por el usuario: {$this->user}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Unidad de Medida Actualizada',
                'mensaje' => "Cambios Efectuados en: {$this->unidadMedida} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete' => [
                'titulo' => 'Unidad de Medida Eliminada',
                'mensaje' => "La Unidad de Medida: {$this->unidadMedida} ha sido eliminada por el usuario: {$this->user}.",
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
