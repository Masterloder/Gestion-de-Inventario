<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provedores extends Model
{
    use hasfactory;
    use SoftDeletes;
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion'
    ];

    public function materiales()
    {
        return $this->hasMany(Materiales::class, 'id');
    }

    public function movimientos()
    {
        return $this->hasManyThrough(Movimientos::class, Materiales::class, 'id_proveedor', 'id_material', 'id', 'id');
    }


}
