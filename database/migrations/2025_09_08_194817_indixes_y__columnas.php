<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Añadir nueva columna a la tabla materiales
        Schema::table('materiales', function (Blueprint $table) {
            $table->string('categoria_especifica')->nullable()->after('categoria');
        });

        // Añadir índices
        Schema::table('inventario', function (Blueprint $table) {
            $table->index(['id_material', 'id_almacen'], 'idx_inventario_material_almacen');
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->index('fecha_hora', 'idx_movimientos_fecha');
            $table->index('tipo_movimiento', 'idx_movimientos_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            $table->dropColumn('categoria_especifica');
        });

        Schema::table('inventario', function (Blueprint $table) {
            $table->dropIndex('idx_inventario_material_almacen');
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropIndex('idx_movimientos_fecha');
            $table->dropIndex('idx_movimientos_tipo');
        });
    }
};
