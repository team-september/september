<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Availability\IAvailabilityRepository;
use App\Repositories\Mentorship\IMentorshipRepository;
use App\Repositories\User\IUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 現在ログイン中のユーザーに合わせて対象月の1on1予約可能日のデータを返すクラス.
 */
class AvailabilityService
{
    protected User $user;

    protected int $mentor_id;

    protected Carbon $carbon;

<<<<<<< HEAD
    protected Carbon $fistDayOfMonth;

    protected Carbon $nextMonth;

    protected Carbon $prevMonth;

    public function __construct(Request $request)
    {
        // 日付系のデータ取得／加工
        $this->Carbon = $request->ym ? new Carbon($request->ym) : Carbon::now();
        $this->firstDayOfMonth = $this->Carbon->copy()->firstOfMonth();
        $this->lastDayOfMonth = $this->Carbon->copy()->lastOfMonth();
        $this->prevMonth = $this->Carbon->copy()->subMonthsNoOverflow();
        $this->nextMonth = $this->Carbon->copy()->addMonthsNoOverflow();

=======
    public function __construct(
        IUserRepository $userRepository,
        IMentorshipRepository $mentorshipRepository,
        IAvailabilityRepository $availabilityRepository
    ) {
        $this->availabilityRepository = $availabilityRepository;
>>>>>>> 36df1a7ea58e05c72b590dc1138dd9521d8cec90
        // メンターID取得（メンティーの場合は担当メンター）
        $this->user = $userRepository->getUserBySub(Auth::id());
        $this->mentor_id = $this->user->is_mentor ? $this->user->id : $mentorshipRepository->getMentorIdByMenteeId($this->user->id);
    }

    /**
     * 当月のデータ取得.
<<<<<<< HEAD
     * @return object
=======
>>>>>>> 36df1a7ea58e05c72b590dc1138dd9521d8cec90
     * @properties
     * Carbon $object->currentMonth
     * Carbon $object->nextMonth
     * Carbon $object->prevMonth
     * Array  $object->weeks->days
     * @see $this->getDays()
     * @param Carbon $date
     * @return object
     */
    public function getAvailabilityDataByMonth(Carbon $date): object
    {
        $this->carbon = $date;
        // メンターに紐づいた当月の予約可能日取得
        $this->availabilities = $this->availabilityRepository->getMonthsAvailabilitiesByDate($this->carbon, $this->mentor_id);
        $firstDayOfMonth = $this->carbon->copy()->firstOfMonth();
        $lastDayOfMonth = $this->carbon->copy()->lastOfMonth();
        $prevMonth = $this->carbon->copy()->subMonthsNoOverflow();
        $nextMonth = $this->carbon->copy()->addMonthsNoOverflow();

        $weeks = [];
        $tmpDay = $firstDayOfMonth;

        // 月末までループ
        while ($tmpDay->lte($lastDayOfMonth)) {
            $weeks[] = $this->getDaysByWeek($tmpDay);
            $tmpDay->addDay(7);
        }

        return (object) [
<<<<<<< HEAD
            'currentMonth' => $this->Carbon,
            'nextMonth' => $this->nextMonth,
            'prevMonth' => $this->prevMonth,
=======
            'currentMonth' => $this->carbon,
            'nextMonth' => $nextMonth,
            'prevMonth' => $prevMonth,
>>>>>>> 36df1a7ea58e05c72b590dc1138dd9521d8cec90
            'weeks' => $weeks,
        ];
    }

    public function updateAvailabilities(Request $request)
    {
        // ユーザーがメンターでなければbad request
        if ($this->user->is_mentor === false) {
            abort(400);
        }
        $dates = collect($request->availability_setting);

        $deleteTargets = $dates->where('is_available', false);
        $deleteResult = $this->availabilityRepository->removeAvailabilitiesByDates($deleteTargets, $this->mentor_id);

        if ($deleteResult === false) {
            return back()->withErrors('更新処理に失敗しました');
        }

        $updateTargets = $dates->where('is_available', true);
        return $this->availabilityRepository->updateOrInsertAvailabilitiesByDates($updateTargets, $this->mentor_id);
    }

    public function updateAvailableTimes(Request $request)
    {
        // ユーザーがメンターでなければbad request
        if ($this->user->is_mentor === false) {
            abort(400);
        }

        $times = collect($request->set_time);

        return $this->availabilityRepository->updateOrInsertAvailableTimes($times, $this->mentor_id);
    }

    /**
     * 週毎のデータを配列化したもの.
     * @param Carbon $date
     * @return array $days
     *
     * day object properties
     * date         => Y-m-d
     * date_j       => 1 - 31
     * day          => mon - sun
     * is_today     => bool
     * is_past      => bool
     * is_available => bool
     */
    private function getDaysByWeek(Carbon $date): array
    {
        $tmpDay = $date->copy()->startOfWeek(); // 週の頭にセット
        $endOfWeek = $date->copy()->endOfWeek(); // 週末を定義

        // 週末まで処理をループ
        $days = [];
        while ($tmpDay->lte($endOfWeek)) {
            //前の月、もしくは後ろの月の場合はnull
            if ($tmpDay->month !== $this->carbon->month) {
                $days[] = null;
                $tmpDay->addDay(1);
                continue;
            }

            $day = [
                'date' => $tmpDay->format('Y-m-d'),
                'date_j' => $tmpDay->format('j'),
                'day' => strtolower($tmpDay->format('D')),
                'is_today' => $tmpDay->isToday(),
                'is_past' => $tmpDay->endOfDay()->isPast(),
            ];

            // is_availableフラグ
            if ($this->availabilities->isEmpty()) {
                $day['is_available'] = false;
            } else {
                $day['is_available'] = $this->availabilities
                    ->filter(
                        function ($date) use ($day) {
                            return $date->available_date->format('Y-m-d') == $day['date'];
                        }
                    )
                    ->isNotEmpty();
            }

            $days[] = (object) $day;
            $tmpDay->addDay(1);
        }
        return $days;
    }
}
