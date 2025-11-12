<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';

    protected $fillable = [

        'tipo_movimiento',
        'fecha_hora' ,
        'cantidad' ,
        'numero_referencia',
        'id_material',
        'id_almacen',
        'id_usuario'



    ];
}
