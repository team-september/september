<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface IAvailabilityRepository
{
    public function getMonthsAvailabilitiesByDate(Carbon $date, int $mentor_id): Collection;
}
