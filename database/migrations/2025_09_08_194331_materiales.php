<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Creamos las tablas que no dependen de otras (Tablas Padre)
        Schema::create('categorias_materiales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_categoria')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('unidades_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_unidad')->unique();
            $table->string('simbolo')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Tabla que depende de categorias_materiales
        Schema::create('categorias_especificas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_materiales')->onDelete('cascade');
            $table->string('nombre_especifico');
            $table->softDeletes();
            $table->timestamps();
        });

        // 3. Por último, la tabla materiales que depende de todas las anteriores
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            
            
            
            // Asegúrate de que los nombres de las tablas coincidan exactamente
            $table->foreignId('unidad_medida_id')->constrained('unidades_medida');
            $table->foreignId('categoria_id')->constrained('categorias_materiales');
            $table->foreignId('categoria_especifica_id')->constrained('categorias_especificas');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Se eliminan en orden inverso para evitar errores de restricción de llaves
        Schema::dropIfExists('materiales');
        Schema::dropIfExists('categorias_especificas');
        Schema::dropIfExists('unidades_medida');
        Schema::dropIfExists('categorias_materiales');
    }
};