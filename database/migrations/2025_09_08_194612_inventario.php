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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_material')->constrained('materiales');
            $table->foreignId('id_almacen')->constrained('almacenes');
            $table->decimal('cantidad_actual', 10, 2);
            $table->enum('unidad_medida', ['M3', 'Kg', 'L', 'Uds']);
            $table->decimal('punto_reorden', 10, 2);
            $table->string('ubicacion_fisica')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
