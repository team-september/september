<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CalendarService;

class ReservationController extends Controller
{
    public function index()
    {
        $Service = new CalendarService();
        $prev = $Service->getPrevMonth()->format('Y-m');
        $next = $Service->getNextMonth()->format('Y-m');
        $current = $Service->getCurrentMonth()->format('Y年m月');
        $calendar = $Service->render();

        return view('reservation.index', compact('prev', 'next', 'current', 'calendar'));
    }
}
