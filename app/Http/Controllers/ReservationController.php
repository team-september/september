<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationRequest;
use App\Services\ReservationService;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    protected $reservationService;

    /**
     * ReservationController constructor.
     *
     * @param $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $reservations = $this->reservationService->getReservationsBySub(Auth::id());

        return view('reservation.index', compact('reservations'));
    }

    /**
     * メンティー側の1on1予約
     *
     * @param StoreReservationRequest $request
     *
     * @return Application|RedirectResponse|Redirector
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
     * メンター側の1on1申請承認・拒否
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
