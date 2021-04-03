<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(AvailabilityService $service, Request $request)
    {
        // 日付データ取得
        $date = $request->ym ? new Carbon($request->ym) : Carbon::now();
        $availabilityData = $service->getAvailabilityDataByMonth($date);

        return view('reservation.index', [
            'mentor_id' => $availabilityData->mentor_id,
            'prevMonth' => $availabilityData->prevMonth,
            'nextMonth' => $availabilityData->nextMonth,
            'currentMonth' => $availabilityData->currentMonth,
            'calendarData' => $availabilityData->weeks,
        ]);
    }

    public function reserve(ReservationRequest $request)
    {
        dd($request);
    }

    public function setting(AvailabilityService $service, Request $request)
    {
        $Availabilities = $service->updateAvailabilities($request);

        // 指定された月に予約可能な日がなければカレンダー画面へ戻す
        if ($Availabilities->isEmpty()) {
            return back();
        }

        return view('reservation.setting', [
            'settingDates' => $Availabilities,
        ]);
    }

    public function setTime(AvailabilityService $service, Request $request)
    {
        $result = $service->updateAvailableTimes($request);

        if ($result) {
            return redirect(route('reservation.index'))->with('message', '予約可能な日時を設定しました。');
        }
        back()->withErrors('日時の設定に失敗しました');
    }
}
