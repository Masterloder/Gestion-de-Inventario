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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento', ['Entrada', 'Salida', 'Ajuste']);
            $table->timestamp('fecha_operacion')->useCurrent();
            $table->decimal('cantidad', 10, 2);
            $table->string('numero_referencia')->nullable();
            $table->foreignId('id_material')->constrained('materiales');
            $table->foreignId('id_almacen')->constrained('almacenes');
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores');
            $table->string('destino')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
