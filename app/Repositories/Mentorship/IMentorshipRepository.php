<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

interface IMentorshipRepository
{
    public function getMentorIdByMenteeId(int $mentee_id): ?int;
}
