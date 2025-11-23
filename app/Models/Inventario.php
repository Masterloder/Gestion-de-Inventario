<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $fillable = [
            'id_material',
            'id_almacen',
            'cantidad_actual',
            'unidad_medida',
            'punto_reorden',
            'ubicacion_fisica'
    ];
    protected $table = 'inventario'; // Asegura que apunte a tu tabla

    // Relación: Un inventario pertenece a un Material
    public function material()
    {
        // Asumiendo que la clave foránea es 'id_material'
        return $this->belongsTo(Materiales::class, 'id_material');
    }

    // Relación: Un inventario pertenece a un Almacen
    public function almacen()
    {
        // Asumiendo que la clave foránea es 'id_almacen'
        return $this->belongsTo(Almacenes::class, 'id_almacen');
    }
}
