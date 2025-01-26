<?php

namespace App\Providers;

use App\Extensions\AnimalsUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider(AnimalsUserProvider::class, function (Application $app, array $config) {
            return new AnimalsUserProvider($config['password']);
        });
    }
}
