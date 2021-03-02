<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Application\IApplicationRepository;
use App\Repositories\User\IUserRepository;

class ProfileService
{
    protected $userRepository;

    protected $applicationRepository;

    protected $urlService;

    public function __construct(
        IUserRepository $userRepository,
        IApplicationRepository $applicationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
    }

    public function findProfile($profile)
    {
        $career = $profile->career;
        $purposes = $profile->purposes;
        $skills = $profile->skills;
        $mentors = $this->userRepository->getMentors();
        $application = $this->applicationRepository->getLatestApplication($profile->user_id);
        $appliedMentor = $application ? $application->mentor : null;

        return [
            $career,
            $purposes,
            $skills,
            $mentors,
            $application,
            $appliedMentor,
        ];
    }
}
