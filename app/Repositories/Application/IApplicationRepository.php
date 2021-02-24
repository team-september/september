<?php

declare(strict_types=1);

namespace App\Repositories\Application;

interface IApplicationRepository
{
    public function create($mentee_id, $mentor_id);

    public function getLatestApplication($user_id);

    public function getOngoingApplication($user_id);

    public function updateApprovedApplication($mentor_id, $user_id);

    public function countUnreadApplications();
}
