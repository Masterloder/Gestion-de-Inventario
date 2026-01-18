<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestionList extends Model {
    protected $table = 'security_questions_list';
    protected $fillable = ['question'];
}
