<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationUpdateRequest;
use App\Repositories\Application\IApplicationRepository;
use App\Repositories\ReadApplication\IReadApplicationRepository;
use App\Repositories\User\IUserRepository;

class AvailabilitieController extends Controller
{
    protected $applicationRepository;

    protected $readApplicationRepository;

    protected $userRepository;

    /**
     * ApplicationController constructor.
     *
     * @param IApplicationRepository     $applicationRepository
     * @param IReadApplicationRepository $readApplicationRepository
     * @param IUserRepository            $userRepository
     */
    public function __construct(
        IApplicationRepository $applicationRepository,
        IReadApplicationRepository $readApplicationRepository,
        IUserRepository $userRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->readApplicationRepository = $readApplicationRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('availabilitie.index');
    }

    public function update(ApplicationUpdateRequest $request): void
    {
    }
}
