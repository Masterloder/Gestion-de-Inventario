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
        $Post->nombre = \Faker\Factory::create()->name();
        $Post->correo = \Faker\Factory::create()->unique()->safeEmail();
        $Post->telefono = \Faker\Factory::create()->phoneNumber();
        $Post->direccion = \Faker\Factory::create()->address();
        $Post->save();
    }
}
