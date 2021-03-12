<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Models\Availability;
use Carbon\Carbon;

class AvailabilityEQRepository implements IAvailabilityRepository
{
    public static function getMonthsAvailabilitiesByDate(Carbon $date, int $mentor_id): ?Availability
    {
        return Availability::where('mentor_id', $mentor_id)
            ->where('available_date', '>=', $date->firstOfMonth())
            ->where('available_date', '<=', $date->lastOfMonth())
            ->first();
    }
}