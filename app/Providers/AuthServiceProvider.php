<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        Passport::routes();

        Passport::personalAccessClientId(
            config('passport.personal_access_client.id', '1')
        );
    
        Passport::personalAccessClientSecret(
            config('passport.personal_access_client.secret', '9LVI4HyiG6VdIvgCOAfRlTB08n7pvbExoYsMEJf2')
        );


        Gate::define('access-admin', function($user){
            return $user->hasAnyRoles(['admin', 'treasurer']);
        });
        Gate::define('manage-users', function($user){
            return $user->hasRole('admin');
        });
        Gate::define('edit-users', function($user){
            return $user->hasRole('admin');
        });
        Gate::define('delete-users', function($user){
            return $user->hasRole('admin');
        });
        Gate::define('manage-finances', function($user){
            return $user->hasRole('treasurer');
        });
        
    }
}
