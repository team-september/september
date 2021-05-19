<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MultipleProfileUpdateRequest;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\Career\ICareerRepository;
use App\Repositories\Profile\IProfileRepository;
use App\Repositories\Purpose\IPurposeRepository;
use App\Repositories\Skill\ISkillRepository;
use App\Repositories\User\IUserRepository;

class ProfileService
{
    protected $userRepository;

    protected $applicationRepository;

    protected $profileRepository;

    protected $careerRepository;

    protected $purposeRepository;

    protected $skillRepository;

    public function __construct(
        IUserRepository $userRepository,
        IApplicationRepository $applicationRepository,
        IProfileRepository $profileRepository,
        ICareerRepository $careerRepository,
        IPurposeRepository $purposeRepository,
        ISkillRepository $skillRepository
    ) {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $this->profileRepository = $profileRepository;
        $this->careerRepository = $careerRepository;
        $this->purposeRepository = $purposeRepository;
        $this->skillRepository = $skillRepository;
    }

    public function getUserProfileByUserId($userId)
    {
        return $this->profileRepository->getByUserId($userId);
    }

    public function findProfileDetail($profile)
    {
        $userCareer = $profile->career;
        $careers = $this->careerRepository->getAll();
        $userPurposes = $profile->purposes;
        $purposes = $this->purposeRepository->getAll();
        $userSkills = $profile->skills;
        $skills = $this->skillRepository->getAll();
        $mentors = $this->userRepository->getMentors();
        $application = $this->applicationRepository->getLatestApplication($profile->user_id);
        $appliedMentor = $application ? $application->mentor : null;

        return [
            $userCareer,
            $careers,
            $userPurposes,
            $purposes,
            $userSkills,
            $skills,
            $mentors,
            $application,
            $appliedMentor,
        ];
    }

    public function update($profile, MultipleProfileUpdateRequest $request)
    {
        return $this->profileRepository->update($profile, $request);
    }
}
