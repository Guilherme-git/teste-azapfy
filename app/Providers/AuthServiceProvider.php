<?php

namespace App\Providers;

use App\Models\NotaFiscal;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("view",function (User $user, NotaFiscal $notaFiscal){
            if($user->id == $notaFiscal->id_usuario){
                return true;
            }
            throw new \Exception('Esse usuário não tem permissão para ver / editar / remover essa nota fiscal');
        });
    }
}
