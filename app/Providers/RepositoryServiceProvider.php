<?php

namespace App\Providers;

use App\Repositories\Availability\IAvailabilityRepository;
use App\Repositories\Availability\AvailabilityEQRepository;

use App\Repositories\Mentorship\IMentorshipRepository;
use App\Repositories\Mentorship\MentorshipEQRepository;

use App\Repositories\Application\IApplicationRepository;
use App\Repositories\Application\ApplicationEQRepository;
use App\Repositories\ReadApplication\IReadApplicationRepository;
use App\Repositories\ReadApplication\ReadApplicationRepository;
use App\Repositories\ReadApproval\IReadApprovalRepository;
use App\Repositories\ReadApproval\ReadApprovalRepository;

use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserEQRepository;

use App\Repositories\Profile\IProfileRepository;
use App\Repositories\Profile\ProfileEQRepository;
use App\Repositories\ProfileUrl\IProfileUrlRepository;
use App\Repositories\ProfileUrl\ProfileUrlEQRepository;
use App\Repositories\Career\ICareerRepository;
use App\Repositories\Career\CareerEQRepository;
use App\Repositories\Skill\ISkillRepository;
use App\Repositories\Skill\SkillEQRepository;
use App\Repositories\Url\IUrlRepository;
use App\Repositories\Url\UrlEQRepository;
use App\Repositories\Purpose\IPurposeRepository;
use App\Repositories\Purpose\PurposeEQRepository;
use App\Repositories\Reservation\IReservationRepository;
use App\Repositories\Reservation\ReservationEQRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAvailabilityRepository::class, AvailabilityEQRepository::class);

        $this->app->bind(IMentorshipRepository::class, MentorshipEQRepository::class);
        $this->app->bind(IApplicationRepository::class, ApplicationEQRepository::class);
        $this->app->bind(IReservationRepository::class, ReservationEQRepository::class);

        $this->app->bind(IReadApplicationRepository::class, ReadApplicationRepository::class);
        $this->app->bind(IReadApprovalRepository::class,ReadApprovalRepository::class);

        $this->app->bind(IUserRepository::class,UserEQRepository::class);

        $this->app->bind(IProfileRepository::class,ProfileEQRepository::class);
        $this->app->bind(IProfileUrlRepository::class,ProfileUrlEQRepository::class);
        $this->app->bind(ICareerRepository::class, CareerEQRepository::class);
        $this->app->bind(IPurposeRepository::class,PurposeEQRepository::class);
        $this->app->bind(ISkillRepository::class,SkillEQRepository::class);
        $this->app->bind(IUrlRepository::class,UrlEQRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
