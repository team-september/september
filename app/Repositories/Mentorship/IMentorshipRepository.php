<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

use App\Models\User;

interface IMentorshipRepository
{
    public function getMentorIdByUser(User $user): ?int;
}
