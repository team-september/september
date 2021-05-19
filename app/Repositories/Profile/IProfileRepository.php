<?php

declare(strict_types=1);

namespace App\Repositories\Profile;

use App\Http\Requests\MultipleProfileUpdateRequest;

interface IProfileRepository
{
    public function getByUserId(int $userId);

    public function create($userId);

    public function update($profile, MultipleProfileUpdateRequest $request);
}
