<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ReservationService;

class MenteeReservationController extends Controller
{
    protected $reservationService;

    /**
     * MenteeReservationController constructor.
     *
     * @param $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $menteeReservations = $this->reservationService->getMenteeReservations();
        return view('reservation.mentee.index');
    }
}
