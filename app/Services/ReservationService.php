<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ReservationRequest;
use App\Repositories\Reservation\IReservationRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\Auth;

class ReservationService 
{
    protected $reservationRepository;
    
    public function __construct(
        IReservationRepository $reservationRepository,
        IUserRepository $userRepository
        )
    {
        $this->userRepository = $userRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function makeNewReservation(ReservationRequest $request) 
    {
        $user_id = $this->userRepository->getUserBySub(Auth::id())->id;
        return $this->reservationRepository->store($request, $user_id);
    }
}