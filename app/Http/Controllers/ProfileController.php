<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MultipleProfileUpdateRequest;
use App\Services\ApplicationService;
use App\Services\ProfileService;
use App\Services\ReservationService;
use App\Services\UrlService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected $userService;

    protected $urlService;

    protected $profileService;

    protected $applicationService;

    protected $reservationService;

    /**
     * ApplicationController constructor.
     *
     * @param UserService        $userService
     * @param UrlService         $urlService
     * @param ProfileService     $profileService
     * @param ApplicationService $applicationService
     * @param ReservationService $reservationService
     */
    public function __construct(
        UserService $userService,
        UrlService $urlService,
        ProfileService $profileService,
        ApplicationService $applicationService,
        ReservationService $reservationService
    ) {
        $this->userService = $userService;
        $this->urlService = $urlService;
        $this->profileService = $profileService;
        $this->applicationService = $applicationService;
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $user = $this->userService->getOrCreate(Auth::user());

        $profile = $this->profileService->getUserProfileByUserId($user->id);

        $urls = $this->urlService->findUrls($profile, config('url.types'));

        $upcomingReservations = $this->reservationService->getUpcomingReservationsByUser($user);

        list($userCareer, $careers, $userPurposes, $purposes, $userSkills, $skills, $mentors, $application,
            $appliedMentor)
            = $this->profileService->findProfileDetail($profile);

        if ($justApproved = $this->applicationService->justApproved($application)) {
            //既読処理
            $this->applicationService->createReadApproval($application);
        }

        return view(
            'profile.index',
            compact(
                'user',
                'profile',
                'urls',
                'userCareer',
                'userPurposes',
                'userSkills',
                'mentors',
                'application',
                'appliedMentor',
                'justApproved',
                'upcomingReservations',
            )
        );
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        $profile = $this->profileService->getUserProfileByUserId($user->id);

        $urls = $this->urlService->findUrls($profile, config('url.types'));

        list($userCareer, $careers, $userPurposes, $purposes, $userSkills, $skills, $mentors, $application,
            $appliedMentor)
            = $this->profileService->findProfileDetail($profile);

        return view(
            'profile.show',
            compact(
                'user',
                'profile',
                'urls',
                'userCareer',
                'userPurposes',
                'userSkills',
                'mentors',
                'application',
                'appliedMentor'
            )
        );
    }

    public function edit()
    {
        $user = $this->userService->getUserBySub(Auth::id());

        $profile = $this->profileService->getUserProfileByUserId($user->id);

        $urls = $this->urlService->findUrls($profile, config('url.types'));

        list($userCareer, $careers, $userPurposes, $purposes, $userSkills, $skills, $mentors, $application,
            $appliedMentor)
            = $this->profileService->findProfileDetail($profile);

        return view(
            'profile.edit',
            compact(
                'user',
                'profile',
                'urls',
                'userCareer',
                'careers',
                'userPurposes',
                'purposes',
                'userSkills',
                'skills',
                'application',
                'appliedMentor'
            )
        );
    }

    public function update(MultipleProfileUpdateRequest $request, $id)
    {
        $user = $this->userService->getUserById($id);

        $profile = $this->profileService->getUserProfileByUserId($user->id);

        $urls = $this->urlService->findUrls($profile, config('url.types'));

        DB::transaction(
            function () use ($request, $user, $profile, $urls): void {
                $this->userService->update($user, $request);
                $this->profileService->update($profile, $request);

                foreach ($urls as $snsType => $url) {
                    $this->urlService->update($url, $request, $snsType);
                }
            }
        );

        return redirect()->route('profile.index')->with('success', '更新しました');
    }
}
