<?php

namespace App\Providers;

use App\Repositories\Purpose\IPurposeRepository;
use App\Repositories\Purpose\PurposeEQRepository;
use Illuminate\Support\ServiceProvider;

class PurposeRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IPurposeRepository::class,
            PurposeEQRepository::class
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
