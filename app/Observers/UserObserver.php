<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Profile;
use App\Models\ProfileUrl;
use App\Models\Url;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     */
    public function created(User $user): void
    {
        $profile = Profile::make($user->id);

        // GitHub, Twitter, Web, その他の4つのURL格納用レコードを最初に作成
        for ($url_id = 1; $url_id < 5; $url_id++) {
            Url::make($url_id);
            ProfileUrl::make($profile->id, $url_id);
        }
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
