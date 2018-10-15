<?php

namespace App\Providers;

use App\Country;
use App\Organization;
use App\Policies\CountryPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Country::class => CountryPolicy::class,
        User::class => UserPolicy::class,
        Organization::class => OrganizationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerMacros();

        Passport::routes();
    }

    public function registerMacros()
    {
        $this->getModelMacro();
    }

    public function getModelMacro()
    {
        FormRequest::macro('getModel', function($key, $class) {
           $model = $this->route($key);
           return $model instanceof $class ? $model : resolve($class)->findOrFail($model);
        });
    }
}
