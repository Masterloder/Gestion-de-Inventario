<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'rol',
        'email',
        'password',
        'autorizacion',
        'security_questions',
        'configuracion_seguridad_completa',
    ];

    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'id_usuario');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function securityQuestions()
    {
        return $this->belongsToMany(
            SecurityQuestion::class,    // El modelo de las preguntas
            'user_security_answers',    // Tu tabla pivote
            'user_id',                  // Llave foránea de esta tabla en la pivote
            'question_id'               // Llave foránea del otro modelo en la pivote
        )->withPivot('answer');         // Para poder acceder a la respuesta después
    }
}
