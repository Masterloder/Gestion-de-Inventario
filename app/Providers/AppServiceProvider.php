<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Definimos una regla llamada 'admin-only'
    Gate::define('admin-only', function ($user) {
        // Retorna true solo si el usuario tiene el rol de admin
        return $user->rol === 'Administrador'; 
    });
    }
}
