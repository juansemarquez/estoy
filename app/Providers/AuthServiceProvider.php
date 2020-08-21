<?php

namespace App\Providers;

use App\Alumno;
use App\Policies\AlumnoPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Alumno' => 'App\Policies\AlumnoPolicy',
        'App\Docentes' => 'App\Policies\DocentesPolicy',
        'App\Comunicacion' => 'App\Policies\ComunicacionPolicy'
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
