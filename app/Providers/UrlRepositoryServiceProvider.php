<?php

namespace App\Providers;

use App\Repositories\Url\IUrlRepository;
use App\Repositories\Url\UrlEQRepository;
use Illuminate\Support\ServiceProvider;

class UrlRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IUrlRepository::class,
            UrlEQRepository::class
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
