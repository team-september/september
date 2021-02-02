<?php

namespace App\Providers;

use App\Repositories\ProfileUrl\IProfileUrlRepository;
use App\Repositories\ProfileUrl\ProfileUrlEQRepository;
use Illuminate\Support\ServiceProvider;

class ProfileUrlRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IProfileUrlRepository::class,
            ProfileUrlEQRepository::class
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
