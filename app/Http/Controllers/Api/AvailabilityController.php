<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Availability\IAvailabilityRepository;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    protected $availabilityRepository;

    public function __construct(IAvailabilityRepository $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function getAvailability(Request $request)
    {
        // 日付をコレクションに入れる
        $dates = collect($request->date);

        // 設定された空き日を取得
        $availabilities = $this->availabilityRepository->findAvailabilitiesByDates($dates, $request->mentor_id);

        // 日付⇒時間の連想配列に加工する
        $result = [];

        foreach ($availabilities as $availability) {
            $date = $availability->available_date->format('Y-m-d');
            $result[$date] = $availability->availableTimes->map(function ($availableTime) {
                return substr($availableTime->time, 0, 5); // 末尾の不要な:00除去してから返す
            });
        }
        // JSONレスポンス
        return response()->json($result);
    }
}
