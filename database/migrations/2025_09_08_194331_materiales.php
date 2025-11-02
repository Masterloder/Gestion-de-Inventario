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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 100)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('unidad_medida', ['metros_cubicos', 'kilogramos', 'litros', 'unidades']);
            $table->enum('categoria',['Materiales Pétreos', 'Materiales Cerámicos y vítreos' , 'Materiales Compuestos' , 'Materiales Metálicos', 'Materiales Orgánicos']);
            $table->enum('categoria_especifica', ['Estructural', 'Aglutinantes', 'Acabado', 'Cerramiento'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
