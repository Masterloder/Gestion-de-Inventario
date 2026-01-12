<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categorias_materiales';

    protected $fillable = [
        'nombre_categoria',
    ];

    public function categoriasEspecificas(): HasMany
    {
        // 'categoria_id' es la llave foránea en la tabla de categorías específicas
        return $this->hasMany(CategoriaEspecifica::class, 'categoria_id');
    }
}
