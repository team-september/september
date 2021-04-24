<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Repositories\Reservation\IReservationRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(
        IReservationRepository $reservationRepository,
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getReservationsBySub(string $sub)
    {
        $user = $this->userRepository->getUserBySub($sub);
        return $user->is_mentor
            ? $this->reservationRepository->getReservationsByMentorId($user->id)
            : $this->reservationRepository->getReservationsByMenteeId($user->id);
    }

    public function getReservationsByMentorId(int $mentorId)
    {
        return $this->reservationRepository->getReservationsByMentorId($mentorId);
    }

    public function store(StoreReservationRequest $request)
    {
        $userId = $this->userRepository->getUserBySub(Auth::id())->id;
        return $this->reservationRepository->store($request, $userId);
    }

    public function update(UpdateReservationRequest $request)
    {
        return $this->reservationRepository->update($request);
    }
}
