<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaterialNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $material;
    protected $user;

   // Recibimos el tipo (update, delete, create) y el nombre
    public function __construct($tipo, $material, $user = null)
    {
        $this->tipo = $tipo;
        $this->material = $material;
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
                'titulo' => 'Nuevo Material',
                'mensaje' => "Se ha registrado el Material: {$this->material}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Material Actualizado',
                'mensaje' => "Cambios Efectuados en: {$this->material} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete' => [
                'titulo' => 'Material Eliminado',
                'mensaje' => "El Material: {$this->material} ha sido eliminado por el usuario {$this->user}.",
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
