<?php

namespace Database\Seeders;

use App\Models\Provedores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProvedoresSeeder extends Seeder


{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Post = new Provedores();
        $Post->codigo = \Faker\Factory::create()->unique()->numberBetween(1000, 9999);
        $Post->nombre = \Faker\Factory::create()->name();
        $Post->contacto = \Faker\Factory::create()->unique()->safeEmail();
        $Post->direccion = \Faker\Factory::create()->address();
        $Post->save();
    }
}
