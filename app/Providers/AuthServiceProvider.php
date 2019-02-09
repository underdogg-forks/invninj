<?php

namespace App\Providers;

use App\Models\Customer;
use App\Policies\CustomerPolicy;
use Auth;
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
        Customer::class => CustomerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('users', function ($app, array $config) {
            return new MultiDatabaseUserProvider($this->app['hash'], $config['model']);
        });

        Auth::provider('contacts', function ($app, array $config) {
            return new MultiDatabaseUserProvider($this->app['hash'], $config['model']);

        });

        Gate::define('view-list', function ($user, $entity) {

            $entity = strtolower(class_basename($entity));

                return $user->hasPermission('view_' . $entity) || $user->isAdmin();

        });

    }

}
