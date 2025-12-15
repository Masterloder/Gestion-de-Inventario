<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    use HasFactory;
    protected $table = 'materiales';

     protected $fillable = [
            'nombre',
            'descripcion',
            'unidad_medida',
            'categoria',
            'categoria_especifica',
    ];

    public function proveedores()
    {
        return $this->belongsTo(Provedores::class, 'id_proveedor');
    }
    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'id_material');
    }

}
