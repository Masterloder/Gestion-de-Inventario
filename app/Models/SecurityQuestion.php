<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityQuestion extends Model
{
    use HasFactory;
    protected $table = 'security_questions_list';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'user_id',
        'question',
        'answer',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización (JSON).
     * La respuesta debe estar oculta por seguridad.
     */
    protected $hidden = [
        'answer',
    ];

    /**
     * Relación: Una pregunta pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}