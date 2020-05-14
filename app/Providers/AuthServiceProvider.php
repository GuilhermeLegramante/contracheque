<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Municipe;
use Illuminate\Http\Request;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        Gate::define('fiscal', function(User $user){
            return $user->tipo == 'fiscal';
        });

        Gate::define('prestador', function(User $user){
            return $user->tipo == 'prestador';
        });

        Gate::define('ativo', function(Municipe $municipe){
            return $municipe->inscricaomunicipal == '26';
        });

    }
}
