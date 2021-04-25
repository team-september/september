<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface IAvailabilityRepository
{
    public function getMonthsAvailabilitiesByDate(Carbon $date, User $user): Collection;

    public function findAvailabilitiesByDates(Collection $date, int $mentorId): Collection;

    public function removeAvailabilitiesByDates(Collection $dates, int $mentorId);

    public function updateAvailableTimes(Collection $times, int $mentorId);
}
