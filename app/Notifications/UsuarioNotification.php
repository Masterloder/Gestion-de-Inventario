<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsuarioNotification extends Notification
{
    use Queueable;
    protected $tipo;
    protected $usuario;
    protected $user;

    public function __construct($tipo, $usuario)
    {
        $this->tipo = $tipo;
        $this->usuario = $usuario;
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
                'titulo' => 'Nuevo Usuario',
                'mensaje' => "Se ha registrado el Usuario: {$this->usuario} ",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update' => [
                'titulo' => 'Usuario Actualizado',
                'mensaje' => "Cambios Efectuados en: {$this->usuario} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete' => [
                'titulo' => 'Usuario Eliminado',
                'mensaje' => "El Usuario: {$this->usuario} ha sido eliminado por el usuario: {$this->user}.",
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
