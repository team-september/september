<?php

namespace App\Providers;

use App\Repositories\Skill\ISkillRepository;
use App\Repositories\Skill\SkillEQRepository;
use Illuminate\Support\ServiceProvider;

class SkillRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ISkillRepository::class,
            SkillEQRepository::class
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
