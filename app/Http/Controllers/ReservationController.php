<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\User\IUserRepository;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request, IUserRepository $UserRepository)
    {
        $user = $UserRepository->getUserBySub(Auth::id());
        $Service = new CalendarService($user, $request);
        $prevMonth = $Service->getPrevMonth()->format('Y-m');
        $nextMonth = $Service->getNextMonth()->format('Y-m');
        $currentMonth = $Service->getCurrentMonth()->format('Y年m月');
        $calendarData = $Service->getCalendarData();

        return view('reservation.index', compact('user', 'prevMonth', 'nextMonth', 'currentMonth', 'calendarData'));
    }
}
