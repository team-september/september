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
        UrlService $urlService,
        IUserRepository $userRepository,
        IApplicationRepository $applicationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
    }
    public function findProfile($profile)
    {
        //$urls = $this->urlService->findUrls($profile, config('url.types'));
        $career = $profile->career;
        $purposes = $profile->purposes;
        $skills = $profile->skills;
        $mentors = $this->userRepository->getMentors();
        $application = $this->applicationRepository->getLatestApplication($profile->id);
        $mentor_applied = $application ? $application->mentor : null;

        return array(
          //          $urls,
                    $career,
                    $purposes,
                    $skills,
                    $mentors,
                    $application,
                    $mentor_applied
                );
    }
}
