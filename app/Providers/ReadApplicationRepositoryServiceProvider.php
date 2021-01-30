<?php

namespace App\Providers;

use App\Repositories\ReadApplication\IReadApplicationRepository;
use App\Repositories\ReadApplication\ReadApplicationRepository;
use Illuminate\Support\ServiceProvider;

class ReadApplicationRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IReadApplicationRepository::class,
            ReadApplicationRepository::class
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
