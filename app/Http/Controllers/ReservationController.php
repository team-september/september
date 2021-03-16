<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $Service = new CalendarService($request);
        $prevMonth = $Service->getPrevMonth()->format('Y-m');
        $nextMonth = $Service->getNextMonth()->format('Y-m');
        $currentMonth = $Service->getCurrentMonth()->format('Y年m月');
        $calendarData = $Service->getCalendarData();

        return view('reservation.index', compact('prevMonth', 'nextMonth', 'currentMonth', 'calendarData'));
    }
}
