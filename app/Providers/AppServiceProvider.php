<?php

namespace App\Providers;

use App\Repositories\Contracts\DeputadoRepositoryInterface;
use App\Repositories\Eloquent\DeputadoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            DeputadoRepositoryInterface::class,
            DeputadoRepository::class
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
