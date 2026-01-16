<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiales extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida_id',
        'categoria_id',
        'categoria_especifica_id',
        'fecha_caducidad',
    ];
    protected $casts = [
        'fecha_caducidad' => 'date',
    ];


    public function proveedores()
    {
        return $this->belongsTo(Provedores::class, 'id_proveedor');
    }
    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'id_material');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_id');
    }

    public function categoriaEspecifica()
    {
        return $this->belongsTo(CategoriaEspecifica::class, 'categoria_especifica_id');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }
}
