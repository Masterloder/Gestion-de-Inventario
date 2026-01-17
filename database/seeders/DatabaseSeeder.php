<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear usuario administrador
        $user = new User();
        $user->name = 'administrador';
        $user->firstname = 'Name';
        $user->lastname = 'lastname';
        $user->email = 'test@gmail.com';
        $user->rol = 'Administrador';
        $user->autorizacion = true;
        $user->password = bcrypt('domxfQ7c');
        $user->save();

        // 1. Catálogos base (Sin dependencias)
        $this->call([
            Categorias::class,
            UnidadesMedicion::class,
            ProvedoresSeeder::class,
            AlmacenesSeeder::class,
        ]);

        // 2. Entidades que dependen de los catálogos
        $this->call([
            MaterialesSeeder::class,
        ]);

        // 3. Ejecutar MovimientosSeeder 10 veces
        // Lo ponemos fuera del array para poder usar un bucle
        for ($i = 0; $i < 70; $i++) {
            $this->call(MovimientosSeeder::class);
        }
    }
}