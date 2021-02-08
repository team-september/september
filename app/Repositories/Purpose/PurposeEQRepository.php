<?php

declare(strict_types=1);

namespace App\Repositories\Purpose;

use App\Models\Purpose;

class PurposeEQRepository implements IPurposeRepository
{
    public function getAll()
    {
        return Purpose::all();
    }
}
