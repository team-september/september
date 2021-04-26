<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Services\ReservationService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    protected $reservationService;
    protected $userService;

    /**
     * ReservationController constructor.
     *
     * @param ReservationService $reservationService
     * @param UserService        $userService
     */
    public function __construct(ReservationService $reservationService, UserService $userService)
    {
        $this->reservationService = $reservationService;
        $this->userService = $userService;
    }

    public function index()
    {
        $sub = Auth::id();
        $reservations = $this->reservationService->getReservationsBySub($sub);
        if ($this->userService->isMentor($sub)) {
            return view('reservation.mentor.index', compact('reservations'));
        }

        return view('reservation.mentee.index', compact('reservations'));
    }

    /**
     * メンティー側の1on1予約.
     *
     * @param StoreReservationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(StoreReservationRequest $request)
    {
        try {
            $this->reservationService->store($request);
            return redirect(route('schedule.index'))->with(['message' => '1on1の予約申請を受け付けました']);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withErrors('予約の申請に失敗しました');
        }
    }

    /**
     * メンター側の1on1申請承認・拒否.
     *
     * @param UpdateReservationRequest $request
     *
     * @return RedirectResponse
     */
    public function update(UpdateReservationRequest $request)
    {
        if ($this->reservationService->update($request)) {
            return redirect()->back()->with(['message' => '更新しました。']);
        }

        return redirect()->back()->with(['failure' => '更新に失敗しました。']);
    }
}
