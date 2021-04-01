<?php

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

        //
        $result = [];
        foreach ($availabilities as $availability) {
            $date = $availability->available_date->format('Y-m-d');
            $result[$date] = $availability->availableTimes->map(function ($availableTime) {
                return $availableTime->time;
            });
        }
        return response()->json($result);
    }
}
