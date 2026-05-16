<?php

namespace App\Providers;

use App\Repositories\Interfaces\DeputadoInterface;
use App\Repositories\Services\DeputadoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            DeputadoInterface::class,
            DeputadoService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
