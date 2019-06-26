<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use League\OAuth2\Server\AuthorizationServer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->get(AuthorizationServer::class)->enableGrantType(new PersonalAccessGrant(), new \DateInterval('PT12H'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
