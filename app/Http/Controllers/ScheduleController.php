<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(AvailabilityService $availabilityService, Request $request)
    {
        // 日付データ取得
        $date = $request->ym ? new Carbon($request->ym) : Carbon::now();
        $availabilityData = $availabilityService->getAvailabilityDataByMonth($date);

        return view('schedule.index', [
            'mentor_id' => $availabilityData->mentor_id,
            'prevMonth' => $availabilityData->prevMonth,
            'nextMonth' => $availabilityData->nextMonth,
            'currentMonth' => $availabilityData->currentMonth,
            'calendarData' => $availabilityData->weeks,
        ]);
    }

    public function store(AvailabilityService $availabilityService, Request $request)
    {
        $result = $availabilityService->updateAvailableTimes($request);

        if ($result) {
            return redirect(route('schedule.index'))->with('message', '予約可能な日時を設定しました。');
        }
        return back()->withErrors('日時の設定に失敗しました');
    }

    public function update(AvailabilityService $availabilityService, Request $request)
    {
        $availabilities = $availabilityService->updateAvailabilities($request);

        // 指定された月に予約可能な日がなければカレンダー画面へ戻す
        if ($availabilities->isEmpty()) {
            return back();
        }

        return view('schedule.update', [
            'settingDates' => $availabilities,
        ]);
    }
}
