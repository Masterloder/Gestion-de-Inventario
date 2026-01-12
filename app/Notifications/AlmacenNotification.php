<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlmacenNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $almacen;
    protected $user;

    public function __construct($tipo, $almacen)
    {
        $this->tipo = $tipo;
        $this->almacen = $almacen;
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
                'titulo' => 'Nuevo Almacén',
                'mensaje' => "Se ha registrado el Almacén: {$this->almacen} por el usuario: {$this->user}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Almacén Actualizado',
                'mensaje' => "Cambios Efectuados en: {$this->almacen} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete' => [
                'titulo' => 'Almacén Eliminado',
                'mensaje' => "El Almacén: {$this->almacen} ha sido eliminado por el usuario: {$this->user}.",
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