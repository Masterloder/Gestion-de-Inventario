<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla de catálogo (Preguntas que tú defines)
        Schema::create('security_questions_list', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->timestamps();
        });

        // 2. Tabla de respuestas (Lo que el usuario elige y responde)
        Schema::create('user_security_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('security_questions_list');
            $table->string('answer'); // Aquí guardaremos el Hash
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_security_answers');
        Schema::dropIfExists('security_questions_list');
    }
};