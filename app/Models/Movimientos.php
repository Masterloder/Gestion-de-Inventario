<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimientos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'movimientos_inventario';

    protected $fillable = [

        'tipo_movimiento',
        'fecha_operacion' ,
        'cantidad' ,
        'numero_referencia',
        'id_material',
        'id_almacen',
        'id_usuario',
        'id_proveedor',
        'destino'

    ];

    public function materiales()
    {
        // Asumiendo que la clave foránea es 'id_material'
        return $this->belongsTo(Materiales::class, 'id_material');
    }
    public function material()
    {
        // Asumiendo que la clave foránea es 'id_material'
        return $this->belongsTo(Materiales::class, 'id_material');
    }
    public function tipoMovimiento()
    {
        return $this->belongsTo(Movimientos::class, 'tipo_movimiento');
    }
    public function almacenes()
    {
        // Asumiendo que la clave foránea es 'id_almacen'
        return $this->belongsTo(Almacenes::class, 'id_almacen');
    }
    public function proveedores()
    {
        // Asumiendo que la clave foránea es 'id_proveedor'
        return $this->belongsTo(Provedores::class, 'id_proveedor');
    }

    public function trabajador()
    {
        // Asumiendo que la clave foránea es 'id_usuario'
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function Destino()
    {
        return $this->belongsTo(Movimientos::class,'destino');
    }

    public function movimientos() {
        return $this->hasMany(Movimientos::class, 'id_proveedor');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_id');
    }

    public function categoriaEspecifica()
    {
        return $this->belongsTo(CategoriaEspecifica::class, 'categoria_especifica_id');
    }
}