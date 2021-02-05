<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationCreateRequest;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\ReadApplication\IReadApplicationRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\Auth;

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
        $applications = $user->is_mentor ? $user->mentorApplications : $user->menteeApplications;

        $coustomer = $applications->all();
        //既読処理メンター
        if ($user->is_mentor) {
            $this->readApplicationRepository->create($applications);
            foreach ($coustomer as $coustom) {
                $user =$this->userRepository->getUserById($coustom->mentee_id);
                $create = $coustom->created_at;
                $coustomers[] = array('id'=>$coustom->mentee_id,'name'=>$user->name,'created_at'=>$create);
            }
        } else {
            //$this->readApplicationRepository->create($applications);
            //メンティ側の画面
            foreach ($coustomer as $coustom) {
                $user =$this->userRepository->getUserById($coustom->mentor_id);
                $create = $coustom->created_at;
                $coustomers[] = array('id'=>$coustom->_id,'name'=>$user->name,'created_at'=>$create);
            }
        }
        return view('application.index', compact('applications', 'coustomers'));
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
