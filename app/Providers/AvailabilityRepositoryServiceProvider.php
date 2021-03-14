<?php

namespace App\Providers;

use App\Repositories\Availability\IAvailabilityRepository;
use App\Repositories\Availability\AvailabilityEQRepository;
use Illuminate\Support\ServiceProvider;

class AvailabilityRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAvailabilityRepository::class, AvailabilityEQRepository::class);
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
