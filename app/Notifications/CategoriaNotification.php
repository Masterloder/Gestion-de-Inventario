<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CategoriaNotification extends Notification
{
    use Queueable;

    protected $tipo;
    protected $categoriaNombre;
    protected $categoriaEspecificaNombre;
    protected $user;

    // Recibimos el tipo (update, delete, create) y el nombre
    public function __construct($tipo, $categoriaNombre = null, $categoriaEspecificaNombre = null)
    {
        $this->tipo = $tipo;
        $this->categoriaNombre = $categoriaNombre;
        $this->categoriaEspecificaNombre = $categoriaEspecificaNombre;
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
            'create_categoria' => [
                'titulo' => 'Nueva Categoría',
                'mensaje' => "Se ha registrado la Categoría: {$this->categoriaNombre}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'update_categoria' => [
                'titulo' => 'Categorías Actualizada',
                'mensaje' => "Cambios Efectuados en la Categorías: {$this->categoriaNombre} y {$this->categoriaEspecificaNombre} realizados por el usuario: {$this->user}",
                'icono' => 'bi-pencil-square',
                'color' => 'text-primary'
            ],
            'delete_categoria' => [
                'titulo' => 'Categoría Eliminada',
                'mensaje' => "La Categoría: {$this->categoriaNombre} ha sido eliminada por el usuario: {$this->user}.",
                'icono' => 'bi-trash',
                'color' => 'text-danger'
            ],
            'create_categoria_especifica' => [
                'titulo' => 'Nueva Categoría Específica',
                'mensaje' => "Se ha registrado la Categoría Específica: {$this->categoriaEspecificaNombre} realizados por el usuario: {$this->user}",
                'icono' => 'bi-plus-circle',
                'color' => 'text-success'
            ],
            'delete_categoria_especifica' => [
                'titulo' => 'Categoría Específica Eliminada',
                'mensaje' => "La Categoría Específica: {$this->categoriaEspecificaNombre} ha sido eliminada por el usuario: {$this->user}.",
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
