<?php

declare(strict_types=1);

namespace App\Repositories\Reservation;

use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Collection;

interface IReservationRepository
{
    public function getReservationsByMenteeId(int $menteeId): Collection;

    public function getReservationsByMentorId(int $mentorId): Collection;

    public function store(StoreReservationRequest $request, int $user_id): bool;

}
