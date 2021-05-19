<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\User\IUserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(IUserRepository $userRepository): void
    {
        $this->registerPolicies();

        Gate::define('access_mentor_resource', function($user) use ($userRepository)
        {
            return $userRepository->getBySub($user->sub)->id;
        });
    }
}
