<?php

namespace App\Providers;

use App\Repositories\Application\ApplicationEQRepository;
use App\Repositories\Application\IApplicationRepository;
use Illuminate\Support\ServiceProvider;

class ApplicationRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IApplicationRepository::class,
            ApplicationEQRepository::class
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
