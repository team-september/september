<?php

declare(strict_types=1);

namespace App\Repositories\ReadApproval;

interface IReadApprovalRepository
{
    public function create($application);
}
