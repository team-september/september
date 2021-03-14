<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

use App\Models\Mentorship;

class MentorshipEQRepository implements IMentorshipRepository
{
    public function getMentorIdByMenteeId(int $mentee_id): ?int
    {
        $Mentorship = Mentorship::where('mentee_id', $mentee_id)->first();

        return optional($Mentorship)->mentor_id;
    }
}
