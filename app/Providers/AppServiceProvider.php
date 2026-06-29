<?php

namespace App\Providers;

use App\Models\Entrevista;
use App\Models\Estudiante;
use App\Policies\EntrevistaPolicy;
use App\Policies\EstudiantePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::policy(Estudiante::class, EstudiantePolicy::class);
        Gate::policy(Entrevista::class, EntrevistaPolicy::class);

        Gate::define('gestionar periodos', fn ($user) => $user->hasRole('administrador', 'bienestar'));
        Gate::define('gestionar tutores', fn ($user) => $user->hasRole('administrador', 'bienestar'));
        Gate::define('asignar tutorias', fn ($user) => $user->hasRole('administrador', 'bienestar'));
        Gate::define('importar estudiantes', fn ($user) => $user->hasRole('administrador', 'bienestar'));
    }
}