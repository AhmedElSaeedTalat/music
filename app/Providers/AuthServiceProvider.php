<?php

namespace App\Providers;


use App\Events;
use Carbon\Carbon;
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
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\seller' => 'App\Policies\sellerPolicy',
        'App\User'=> 'App\Policies\adminRestrictions',
        'App\Events' => 'App\Policies\eventPolicy',
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
       Passport::TokensExpireIn(Carbon::now()->addMinutes(30));
       Passport::RefreshTokensExpireIn(Carbon::now()->addDays(30));
       Passport::tokensCan([
        'access' => 'this one can access all songs',
        'show' => 'this one can show songs only',
       ]);
    }
}
