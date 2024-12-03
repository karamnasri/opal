<?php

namespace App\Providers;

use App\Contracts\Authenticatable;
use App\Contracts\Sociable;
use App\Contracts\Verifiable;
use App\Services\Auth\AuthService;
use App\Services\Auth\SocialAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Authenticatable::class, AuthService::class);
        $this->app->bind(Verifiable::class, AuthService::class);

        $this->app->bind(Sociable::class, SocialAuthService::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
