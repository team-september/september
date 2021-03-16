<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $Service = new AvailabilityService($request);
        $availabilityData = $Service->getAvailabilityDataByMonth();

        return view('reservation.index', [
            'prevMonth' => $availabilityData->prevMonth->format('Y-m'),
            'nextMonth' => $availabilityData->nextMonth->format('Y-m'),
            'currentMonth' => $availabilityData->currentMonth->format('Y年m月'),
            'calendarData' => $availabilityData->weeks,
        ]);
    }
}
