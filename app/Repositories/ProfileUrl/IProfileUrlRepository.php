<?php

declare(strict_types=1);

namespace App\Repositories\ProfileUrl;

interface IProfileUrlRepository
{
    public function create($profileId, $urlId);
}
