<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Profile;
use App\Models\ProfileUrl;
use App\Models\Url;
use App\Models\User;
use App\Repositories\Profile\IProfileRepository;
use App\Repositories\ProfileUrl\IProfileUrlRepository;
use App\Repositories\Url\IUrlRepository;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    protected $urlRepository;
    protected $profileRepository;
    protected $profileUrlRepository;

    /**
     * UserObserver constructor.
     * @param $urlRepository
     * @param $profileRepository
     * @param $profileUrlRepository
     */
    public function __construct(
        IUrlRepository $urlRepository,
        IProfileRepository $profileRepository,
        IProfileUrlRepository $profileUrlRepository
    ) {
        $this->urlRepository = $urlRepository;
        $this->profileRepository = $profileRepository;
        $this->profileUrlRepository = $profileUrlRepository;
    }


    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     */
    public function created(User $user): void
    {
        DB::transaction(function () use ($user) {
            $profile = $this->profileRepository->create($user->id);
            // GitHub, Twitter, Web, その他の4つのURL格納用レコードを最初に作成
            for ($urlId = 1; $urlId < 5; $urlId++) {
                $this->urlRepository->create($urlId);
                $this->profileUrlRepository->create($profile->id, $urlId);
            }
        });
    }

    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\User $user
     */
    public function updated(User $user): void
    {
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param \App\Models\User $user
     */
    public function deleted(User $user): void
    {
    }

    /**
     * Handle the User "restored" event.
     *
     * @param \App\Models\User $user
     */
    public function restored(User $user): void
    {
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param \App\Models\User $user
     */
    public function forceDeleted(User $user): void
    {
    }
}
