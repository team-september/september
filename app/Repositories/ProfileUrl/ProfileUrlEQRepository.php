<?php


namespace App\Repositories\ProfileUrl;

use App\Models\ProfileUrl;

class ProfileUrlEQRepository implements IProfileUrlRepository
{
    public function create($profileId, $urlId)
    {
        return ProfileUrl::create(
            [
                'profile_id' => $profileId,
                'url_id' => $urlId,
            ]
        );
    }

}
