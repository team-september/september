<?php

declare(strict_types=1);

namespace App\Repositories\Profile;

use App\Models\Profile;

class ProfileEQRepository implements IProfileRepository
{
    public function create($userId)
    {
        return Profile::create(
            [
                'user_id' => $userId,
            ]
        );
    }

    public function update($profile, $request): void
    {
        $profile->fill(
            [
                'goal' => $request->goal,
                'career_id' => $request->career,
            ]
        )->save();

        $profile->purposes()->sync($request->get('purpose', []));
        $profile->skills()->sync($request->get('skill', []));
    }
}
