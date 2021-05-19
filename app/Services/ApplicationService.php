<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Application\IApplicationRepository;
use App\Repositories\ReadApproval\IReadApprovalRepository;

class ApplicationService
{
    protected $applicationRepository;

    protected $readApprovalRepository;

    /**
     * ApplicationService constructor.
     *
     * @param $applicationRepository
     * @param $readApprovalRepository
     */
    public function __construct(
        IApplicationRepository $applicationRepository,
        IReadApprovalRepository $readApprovalRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->readApprovalRepository = $readApprovalRepository;
    }

    public function justApproved($application): bool
    {
        if (!$application) {
            return false;
        }

        if (!$application->readApproval->isEmpty()) {
            return false;
        }

        if (!$application->status == config('application.status.approved')) {
            return false;
        }

        return true;
    }

    public function createReadApproval($application)
    {
        return $this->readApprovalRepository->create($application);
    }
}
