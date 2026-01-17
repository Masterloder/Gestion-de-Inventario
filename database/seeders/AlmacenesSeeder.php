<?php

namespace Database\Seeders;

use App\Models\Almacenes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Post = new Almacenes();
        $Post->nombre = \Faker\Factory::create()->name();
        $Post->direccion = \Faker\Factory::create()->address();
        $Post->save();
    }
}
