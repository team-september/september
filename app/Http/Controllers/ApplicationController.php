<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationCreateRequest;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    protected $applicationRepository;
    protected $userRepository;

    /**
     * ApplicationController constructor.
     * @param $applicationRepository
     */
    public function __construct(IApplicationRepository $applicationRepository, IUserRepository $userRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->userRepository = $userRepository;
    }

    public function store(ApplicationCreateRequest $request)
    {
        $auth0User = Auth::user();
        $user = $this->userRepository->getUserBySub($auth0User->sub);

        if ($this->applicationRepository->getOngoingApplication($user->id)) {
            return redirect()->route('profile.index')->with(['alert' => '既に申請済みです。']);
        }

        if (!$this->applicationRepository->create($user->id, $request->mentor_id)) {
            return redirect()->route('profile.index')->with(['alert' => '申請に失敗しました。']);
        }

        return redirect()->route('profile.index')->with(['success' => "申請しました！\nメンターの承認をお待ちください。"]);
    }

}
