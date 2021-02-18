<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

use App\Models\Mentorship;

class MentorshipRepository implements IMentorshipRepository
{
    public function create($mentor_id, $mentee_id)
    {
        return MentorShip::create(
            [
                'mentor_id'=> $mentor_id,
                'mentee_id'=> $mentee_id,
                'is_active'=> true
            ]
        );
    }
}
