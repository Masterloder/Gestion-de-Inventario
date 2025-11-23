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

    public function materiales()
    {
        // Asumiendo que la clave foránea es 'id_material'
        return $this->belongsTo(Materiales::class, 'id_material');
    }

    public function almacenes()
    {
        // Asumiendo que la clave foránea es 'id_almacen'
        return $this->belongsTo(Almacenes::class, 'id_almacen');
    }

    public function usuarios()
    {
        // Asumiendo que la clave foránea es 'id_usuario'
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
