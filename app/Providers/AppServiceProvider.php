<?php

namespace App\Providers;

use App\Contracts\Authenticatable;
use App\Contracts\Resettable;
use App\Contracts\Sociable;
use App\Contracts\Verifiable;
use App\Services\Auth\AuthService;
use App\Services\Auth\ResetService;
use App\Services\Auth\SocialAuthService;
use App\Services\Auth\VerifyService;
use App\ValueObjects\MoneySynthesizer;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Authenticatable::class, AuthService::class);
        $this->app->bind(Verifiable::class, VerifyService::class);
        $this->app->bind(Resettable::class, ResetService::class);

        $this->app->bind(Sociable::class, SocialAuthService::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::propertySynthesizer(MoneySynthesizer::class);
    }
}
