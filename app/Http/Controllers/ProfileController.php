<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MultipleProfileUpdateRequest;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\Career\ICareerRepository;
use App\Repositories\Profile\IProfileRepository;
use App\Repositories\Purpose\IPurposeRepository;
use App\Repositories\Skill\ISkillRepository;
use App\Repositories\Url\IUrlRepository;
use App\Repositories\User\IUserRepository;
use App\Services\UrlService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected $userRepository;
    protected $applicationRepository;
    protected $careerRepository;
    protected $purposeRepository;
    protected $skillRepository;
    protected $profileRepository;
    protected $urlRepository;
    protected $urlService;

    /**
     * ApplicationController constructor.
     * @param IUserRepository $userRepository
     * @param IApplicationRepository $applicationRepository
     * @param ICareerRepository $careerRepository
     * @param IPurposeRepository $purposeRepository
     * @param ISkillRepository $skillRepository
     * @param IProfileRepository $profileRepository
     * @param IUrlRepository $urlRepository
     * @param UrlService $urlService
     */
    public function __construct(
        IUserRepository $userRepository,
        IApplicationRepository $applicationRepository,
        ICareerRepository $careerRepository,
        IPurposeRepository $purposeRepository,
        ISkillRepository $skillRepository,
        IProfileRepository $profileRepository,
        IUrlRepository $urlRepository,
        UrlService $urlService
    ) {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $this->careerRepository = $careerRepository;
        $this->purposeRepository = $purposeRepository;
        $this->skillRepository = $skillRepository;
        $this->profileRepository = $profileRepository;
        $this->urlRepository = $urlRepository;
        $this->urlService = $urlService;
    }

    public function index()
    {
        $auth0User = Auth::user();
        $user = $this->userRepository->getUserBySub($auth0User->sub);

        //データがない場合ユーザー関連情報を作成
        if (empty($user)) {
            $userInfo = [
                'sub' => $auth0User->sub,
                'nickname' => $auth0User->nickname,
                'name' => $auth0User->name,
                'picture' => $auth0User->picture,
            ];

            $user = $this->userRepository->create($userInfo);
            // UserObserverにて関連レコードを作成
        }

        //入力されていた値の取得
        $profile = $user->profile;
        $urls = $this->urlService->findUrls($profile, config('url.types'));
        $career = $profile->career;
        $purposes = $profile->purposes;
        $skills = $profile->skills;
        $mentors = $this->userRepository->getMentors();
        $application = $this->applicationRepository->getLatestApplication($user->id);
        $mentor_applied = $application ? $application->mentor : null;

        return view(
            'profile.index',
            compact(
                'user',
                'profile',
                'urls',
                'career',
                'purposes',
                'skills',
                'mentors',
                'application',
                'mentor_applied'
            )
        );
    }

    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);
        $profile = $user->profile;
        $urls = $this->urlService->findUrls($profile, config('url.types'));
        $career = $profile->career;
        $purposes = $profile->purposes;
        $skills = $profile->skills;
        $mentors = $this->userRepository->getMentors();
        $application = $this->applicationRepository->getLatestApplication($user->id);
        $mentor_applied = $application ? $application->mentor : null;

        return view(
            'profile.show',
            compact(
                'user',
                'profile',
                'urls',
                'career',
                'purposes',
                'skills',
                'mentors',
                'application',
                'mentor_applied'
            )
        );
    }

    public function edit($id)
    {
        $user = $this->userRepository->getUserById($id);
        $profile = $user->profile;
        $urls = $this->urlService->findUrls($profile, config('url.types'));
        $user_career = $profile->career;
        $careers = $this->careerRepository->getAll();
        $user_purpose = $profile->purposes;
        $purposes = $this->purposeRepository->getAll();
        $user_skill = $profile->skills;
        $skills = $this->skillRepository->getAll();

        $application = $this->applicationRepository->getLatestApplication($user->id);
        $mentor_applied = $application ? $application->mentor : null;

        return view(
            'profile.edit',
            compact(
                'user',
                'profile',
                'urls',
                'user_career',
                'careers',
                'user_purpose',
                'purposes',
                'user_skill',
                'skills',
                'application',
                'mentor_applied'
            )
        );
    }

    public function update(MultipleProfileUpdateRequest $request, $id)
    {
        $user = $this->userRepository->getUserById($id);
        $profile = $user->profile;
        $urls = $profile->urls;

        DB::transaction(
            function () use ($request, $user, $profile, $urls): void {
                $this->userRepository->update($user, $request);
                $this->profileRepository->update($profile, $request);
                foreach ($urls as $index => $url) {
                    $this->urlRepository->update($url, $request, config('url.types'), $index);
                }
            }
        );

        return redirect()->route('profile.index')->with('success', '更新しました');
    }
}
