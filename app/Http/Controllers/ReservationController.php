<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use App\Http\Requests\ReservationRequest;
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
        return view();
    }

    public function store(ReservationRequest $request)
    {
        try {
            $this->reservationService->makeNewReservation($request);
            return redirect(route('schedule.index'))->with(['message' => '1on1の予約申請を受け付けました']);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withErrors('予約の申請に失敗しました');
        }
    }
}
