<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'administrador';
        $user->firstname = 'Name';
        $user->lastname = 'lastname';
        $user->email = 'test@gmail.com';
        $user->rol = 'Administrador';
        $user->autorizacion = true;
        $user->password = bcrypt('domxfQ7c');
        $user->save();


        $this->call([
            // 1. Catálogos base (Sin dependencias)
            Categorias::class,
            UnidadesMedicion::class,
            ProvedoresSeeder::class,
            // 2. Entidades que dependen de los catálogos anteriores
            MaterialesSeeder::class,
            // Por ejemplo, Materiales necesita categoria_id y unidad_medida_id
            // 3. (Opcional) Si tienes un seeder para movimientos
            // MovimientosSeeder::class,
        ]);
    }
}


