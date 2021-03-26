<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface IAvailabilityRepository
{
    public function getMonthsAvailabilitiesByDate(Carbon $date, int $mentor_id): Collection;

    public function findAvailabilitiesByDates(Collection $date, int $mentor_id): Collection;

    public function removeAvailabilitiesByDates(Collection $dates, int $mentor_id);

    public function updateOrInsertAvailableTimes(Collection $times, int $mentor_id);
}
