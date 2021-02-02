<?php

namespace App\Providers;

use App\Repositories\Career\CareerEQRepository;
use App\Repositories\Career\ICareerRepository;
use Illuminate\Support\ServiceProvider;

class CareerRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ICareerRepository::class,
            CareerEQRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
