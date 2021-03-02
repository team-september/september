<?php

declare(strict_types=1);

namespace App\Repositories\ReadApplication;

use App\Models\ReadApplication;
use Carbon\Carbon;

class ReadApplicationRepository implements IReadApplicationRepository
{
    public function create($applications)
    {
        $data = [];

        foreach ($applications as $application) {
            if ($application->readApplications->isNotEmpty()) {
                continue;
            }

            $data[] = [
                'application_id' => $application->id,
                'user_id' => $application->mentor_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        return ReadApplication::insert($data);
    }
}
