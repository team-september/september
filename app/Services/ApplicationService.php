<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\ApplicationStatus;
use App\Repositories\ReadApproval\IReadApprovalRepository;

class ApplicationService
{
    protected $applicationRepository;

    protected $readApprovalRepository;

    /**
     * @param $readApprovalRepository
     */
    public function __construct(
        IReadApprovalRepository $readApprovalRepository
    ) {
        $this->readApprovalRepository = $readApprovalRepository;
    }

    public function justApproved($application): bool
    {
        if (!$application) {
            return false;
        }

        $unread = $application->readApproval->isEmpty();
        $approved = $application->status === ApplicationStatus::APPROVED;

        return $unread && $approved;
    }

    public function createReadApproval($application)
    {
        return $this->readApprovalRepository->create($application);
    }
}
