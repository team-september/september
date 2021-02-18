<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

interface IMentorshipRepository
{
    public function create($mentor_id, $mentee_id);
}
