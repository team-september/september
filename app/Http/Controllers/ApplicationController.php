<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationUpdateRequest;
use App\Http\Requests\ApplicationCreateRequest;
use App\Models\Application;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\ReadApplication\IReadApplicationRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationRepository;

    protected $readApplicationRepository;

    protected $userRepository;

    /**
     * ApplicationController constructor.
     * @param IApplicationRepository     $applicationRepository
     * @param IReadApplicationRepository $readApplicationRepository
     * @param IUserRepository            $userRepository
     */
    public function __construct(
        IApplicationRepository $applicationRepository,
        IReadApplicationRepository $readApplicationRepository,
        IUserRepository $userRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->readApplicationRepository = $readApplicationRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $user = $this->userRepository->getUserBySub(Auth::id());
        $user_id = $user->id;
        $applications = $user->is_mentor ? $user->mentorApplications : $user->menteeApplications;

        $coustomer = $applications->all();

        //既読処理
        $this->readApplicationRepository->create($applications);

        $user_category = $user->is_mentor ?'mentee_id':'mentor_id';
        $coustomers = array();
        foreach ($coustomer as $coustom) {
            $user =$this->userRepository->getUserById($coustom->$user_category);
            $create = $coustom->created_at->format("Y/m/d");
            $coustomers[] = array('id'=>$coustom->$user_category,'name'=>$user->name,'created_at'=>$create);
        }
        return view('application.index', compact('applications', 'coustomers', 'user_category', 'user_id'));
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

    public function update(ApplicationUpdateRequest $request)
    {
        $mentor_id = $request->mentor_id;
        if ($request->has('rejected')) {
            //todo:application statusを3に更新
            dd('消します');
        } elseif ($request->has('approved')) {
            $mentees = $request->user_id;
            foreach ($mentees as $mentee_id) {
                //todo:aplication statusを2に更新
                $this->applicationRepository->updateApprovedApplication($mentor_id, $mentee_id);
                //todo:mentorshipに追加
            }
        }
        return redirect()->route('application.index')->with(['success' =>"承認しました。"]);
    }
}
