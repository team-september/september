<?php

declare(strict_types=1);

namespace App\Repositories\Profile;

interface IProfileRepository
{
    public function create($userId);

    public function update($profile, $request);
}
