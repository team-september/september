<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Models\Availability;
use Carbon\Carbon;

interface IAvailabilityRepository
{
    public static function getMonthsAvailabilitiesByDate(Carbon $date, int $mentor_id): ?Availability;
}
