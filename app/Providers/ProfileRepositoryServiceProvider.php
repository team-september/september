<?php

namespace App\Providers;

use App\Repositories\Profile\IProfileRepository;
use App\Repositories\Profile\ProfileEQRepository;
use Illuminate\Support\ServiceProvider;

class ProfileRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IProfileRepository::class,
            ProfileEQRepository::class
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
