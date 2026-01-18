<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserSecurityAnswer extends Model {
    protected $table = 'user_security_answers';
    protected $fillable = ['user_id', 'question_id', 'answer'];

    // Relación para saber qué pregunta es
    public function question_data() {
    // El segundo parámetro debe ser la columna que tienes en la tabla 'user_security_answers'
    return $this->belongsTo(SecurityQuestion::class, 'security_question_id');
}

    // Mutador para encriptar automáticamente la respuesta
    public function setAnswerAttribute($value) {
        $this->attributes['answer'] = Hash::make(strtolower($value));
    }

    public function question()
    {
        return $this->belongsTo(SecurityQuestionList::class, 'question_id');
    }
}