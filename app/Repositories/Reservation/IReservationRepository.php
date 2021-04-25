<?php

declare(strict_types=1);

namespace App\Repositories\Reservation;

use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Collection;

interface IReservationRepository
{
    public function getByMenteeId(int $menteeId): Collection;

    public function getByMentorId(int $mentorId): Collection;

    public function getUpcomingByUser($user): Collection;

    public function store(StoreReservationRequest $request, int $userId): bool;
}
