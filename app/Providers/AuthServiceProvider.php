<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //Administrator
        Gate::define('administration', function($user){
            return $user->hasRole(['Administrator']);
        });

        //operator
        Gate::define('isOperator', function($user){
            return $user->hasRole(['Operator']);
        });

        //Define Gates
        Gate::define('AdminCheck', function($user){
            return $user->hasAnyRoles(['Administrator', 'Admin']);
        });

        //Add Permission
        Gate::define('add', function($user){
            return $user->hasAnyRoles(['Administrator', 'Add']);
        });

        //Edit Permission
        Gate::define('edit', function($user){
            return $user->hasAnyRoles(['Administrator', 'Edit']);
        });

        //Delete Permission
        Gate::define('delete', function($user){
            return $user->hasAnyRoles(['Administrator', 'Delete']);
        });

        //Role Permission
        Gate::define('role', function($user){
            return $user->hasAnyRoles(['Administrator', 'Role']);
        });

        //Employee Permission
        Gate::define('employee', function($user){
            return $user->hasAnyRoles(['Administrator', 'Employee']);
        });


    }
}
