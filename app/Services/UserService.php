<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\User\IUserRepository;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isMentor(string $sub)
    {
        return $this->userRepository->getUserBySub($sub)->is_mentor ? true : false;
    }
}
