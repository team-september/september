<?php

declare(strict_types=1);

namespace App\Repositories\Application;

use App\Models\Application;

class ApplicationEQRepository implements IApplicationRepository
{
    public function create($mentee_id, $mentor_id)
    {
        return Application::create(
            [
                'mentee_id' => $mentee_id,
                'mentor_id' => $mentor_id,
                'status' => config('application.status.applied'),
            ]
        );
    }

    public function getLatestApplication($user_id)
    {
        return Application::where('mentee_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getOngoingApplication($user_id)
    {
        return Application::where('mentee_id', $user_id)
            ->whereNotIn('status', [config('application.status.rejected')])
            ->orderBy('id', 'desc')
            ->first();
    }

    public function countUnreadApplications()
    {
        return Application::doesntHave('read_applications')->count();
    }
}
