<?php

namespace App\Providers;

use App\Interfaces\CancelSpotInterface;
use App\Interfaces\ReserveSpotInterface;
use App\Services\CancelSpotService;
use App\Services\ReserveSpotService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReserveSpotInterface::class, ReserveSpotService::class);
        $this->app->bind(CancelSpotInterface::class, CancelSpotService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
