<?php

declare(strict_types=1);

namespace App\Repositories\ReadApproval;

use App\Models\ReadApproval;
use Carbon\Carbon;

class ReadApprovalRepository implements IReadApprovalRepository
{
    public function create($application)
    {
        return ReadApproval::create(
            [
                'application_id' => $application->id,
                'user_id'        => $application->mentee_id,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]
        );
    }
}
