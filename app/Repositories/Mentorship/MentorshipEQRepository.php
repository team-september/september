<?php

declare(strict_types=1);

namespace App\Repositories\Mentorship;

use App\Models\Mentorship;
use App\Models\User;

class MentorshipEQRepository implements IMentorshipRepository
{
    public function getMentorIdByUser(User $user): ?int
    {
        // ユーザーがメンターならユーザー自身のIDを返す
        if ($user->is_mentor) {
            return $user->id;
        }

        // メンティーなら紐付いた最初のメンターのIDを返す
        $mentorship = Mentorship::where('mentee_id', $user->id)
        ->where('is_active', true)
        ->first();

        return optional($mentorship)->mentor_id;
    }
}
