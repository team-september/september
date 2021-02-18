<?php

namespace App\Providers;

use App\Repositories\Mentorship\IMentorshipRepository;
use App\Repositories\Mentorship\MentorshipRepository;
use Illuminate\Support\ServiceProvider;

class MentorshipRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IMentorshipRepository::class,
            MentorshipRepository::class
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
