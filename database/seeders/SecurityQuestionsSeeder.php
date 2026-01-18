<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            ['question' => '¿Cuál era el nombre de tu primera mascota?'],
            ['question' => '¿En qué ciudad se conocieron tus padres?'],
            ['question' => '¿Cuál es el nombre de tu primo mayor?'],
            ['question' => '¿Cuál fue tu primer número de teléfono?'],
            ['question' => '¿Cómo se llamaba tu escuela primaria?'],
            ['question' => '¿Cuál es el nombre de la ciudad donde naciste?'],
            ['question' => '¿Cuál era tu apodo de la infancia?'],
            ['question' => '¿Cuál es el nombre de tu cantante o banda favorita?'],
            ['question' => '¿Cuál fue el primer país que visitaste fuera del tuyo?'],
            ['question' => '¿Cómo se llama tu abuelo materno?'],
        ];

        DB::table('security_questions_list')->insert($questions);
    }
}