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

    public function suministrosAgrupados()
    {
        // Vincula Proveedor con Movimientos_Inventario
        return $this->hasMany(Movimientos::class, 'id_proveedor')
            ->selectRaw('id_material, id_proveedor, SUM(cantidad) as total_suministrado')
            ->groupBy('id_material', 'id_proveedor')
            ->with(['material.categoria', 'material.categoriaEspecifica']);
    }

    public function movimientos()
    {
        return $this->hasManyThrough(Movimientos::class, Materiales::class, 'id_proveedor', 'id_material', 'id', 'id');
    }
    public function ProvedoresCantidad()
    {
        // Si usas una tabla intermedia (pivote) que guarde la cantidad
        return $this->belongsToMany(Movimientos::class)->withPivot('cantidad');
    }
    public function movimientos1() {
    return $this->hasMany(Movimientos::class, 'id_proveedor');
}
}
