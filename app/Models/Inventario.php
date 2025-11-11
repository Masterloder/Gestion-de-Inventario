<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
            'id_material',
            'id_almacen',
            'cantidad_actual',
            'unidad_medida',
            'punto_reorden',
            'ubicacion_fisica'
    ];
}
