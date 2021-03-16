<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Repositories\Application\IApplicationRepository;
use App\Repositories\User\IUserRepository;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

class SetUserInfo
{
    public function __construct(
        Factory $viewFactory,
        IUserRepository $userRepository,
        IApplicationRepository $applicationRepository,
        AuthManager $authManager
    )
    {
        $this->viewFactory = $viewFactory;
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $this->authManager = $authManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->userRepository->getUserBySub($this->authManager->id());
        $unreadApprovalCount = $this->applicationRepository->countUnreadApplications();
        $unreadApplicationCount = $this->applicationRepository->countUnreadApproval();

        $this->viewFactory->share('user', $user);
        $this->viewFactory->share('unreadApprovalCount', $unreadApprovalCount);
        $this->viewFactory->share('unreadApplicationCount', $unreadApplicationCount);

        return $next($request);
    }
}
