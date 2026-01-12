<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEspecifica extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categorias_especificas';

    protected $fillable = [
        'categoria_id',
        'nombre_especifico',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_id');
    }

    public function materiales()
    {
        return $this->hasMany(Materiales::class, 'categoria_especifica_id');
    }
    

}
