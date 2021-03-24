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

    protected Carbon $date;

    public function __construct()
    {
        // メンターID取得（メンティーの場合は担当メンター）
        $this->user = app(IUserRepository::class)->getUserBySub(Auth::id());
        $this->mentor_id = $this->user->is_mentor ? $this->user->id : app(IMentorshipRepository::class)->getMentorIdByMenteeId($this->user->id);
    }

    /**
     * 当月のデータ取得.
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
        $this->Carbon = $date;
        // メンターに紐づいた当月の予約可能日取得
        $this->Availabilities = app(IAvailabilityRepository::class)->getMonthsAvailabilitiesByDate($date, $this->mentor_id);
        $firstDayOfMonth = $date->copy()->firstOfMonth();
        $lastDayOfMonth = $date->copy()->lastOfMonth();
        $prevMonth = $date->copy()->subMonthsNoOverflow();
        $nextMonth = $date->copy()->addMonthsNoOverflow();

        $weeks = [];
        $tmpDay = $firstDayOfMonth;

        // 月末までループ
        while ($tmpDay->lte($lastDayOfMonth)) {
            $weeks[] = $this->getDaysByWeek($tmpDay);
            $tmpDay->addDay(7);
        }

        return (object) [
            'currentMonth' => $date,
            'nextMonth' => $nextMonth,
            'prevMonth' => $prevMonth,
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
        $deleteResult = app(IAvailabilityRepository::class)->removeAvailabilitiesByDates($deleteTargets, $this->mentor_id);

        if ($deleteResult === false) {
            return back()->withErrors('更新処理に失敗しました');
        }

        $updateTargets = $dates->where('is_available', true);
        return app(IAvailabilityRepository::class)->updateOrInsertAvailabilitiesByDates($updateTargets, $this->mentor_id);
    }

    public function updateAvailableTimes(Request $request)
    {
        // ユーザーがメンターでなければbad request
        if ($this->user->is_mentor === false) {
            abort(400);
        }

        $times = collect($request->set_time);

        return app(IAvailabilityRepository::class)->updateOrInsertAvailableTimes($times, $this->mentor_id);
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

        // 週末までループ
        $endOfWeek = $date->copy()->endOfWeek();
        $days = [];
        while ($tmpDay->lte($endOfWeek)) {
            //前の月、もしくは後ろの月の場合はnull
            if ($tmpDay->month !== $this->Carbon->month) {
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
            if ($this->Availabilities->isEmpty()) {
                $day['is_available'] = false;
            } else {
                $day['is_available'] = $this->Availabilities->filter(
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
