<?php

namespace App\Providers;

use App\Repositories\ReadApproval\IReadApprovalRepository;
use App\Repositories\ReadApproval\ReadApprovalRepository;
use Illuminate\Support\ServiceProvider;

class ReadApprovalRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IReadApprovalRepository::class,
            ReadApprovalRepository::class
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
