<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Availability\IAvailabilityRepository;
use App\Repositories\Mentorship\IMentorshipRepository;
use App\Repositories\User\IUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * 現在ログイン中のユーザーに合わせて対象月の1on1予約可能日のデータを返すクラス.
 */
class AvailabilityService
{
    public User $user;

    protected Collection $Availabilities;

    protected Carbon $Carbon;

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
        
        // メンターID取得（メンティーの場合は担当メンター）
        $this->user = app(IUserRepository::class)->getUserBySub(Auth::id());
        $mentor_id = $this->user->is_mentor ? $this->user->id : app(IMentorshipRepository::class)->getMentorIdByMenteeId($this->user->id);

        // メンターに紐づいた予約可能日取得
        $this->Availabilities = app(IAvailabilityRepository::class)->getMonthsAvailabilitiesByDate($this->Carbon, $mentor_id);
    }

    /**
     * 当月のデータ取得
     * @return object 
     * @properties
     * Carbon $object->currentMonth
     * Carbon $object->nextMonth
     * Carbon $object->prevMonth
     * Array  $object->weeks->days
     * @see $this->getDays()
     */
    public function getAvailabilityDataByMonth(): object
    {
        $weeks = [];
        $tmpDay = $this->firstDayOfMonth->copy();

        // 月末までループ
        while ($tmpDay->lte($this->lastDayOfMonth)) {
            $weeks[] = $this->getDaysByWeek($tmpDay);
            $tmpDay->addDay(7);
        }

        return (object) [
            'currentMonth' => $this->Carbon,
            'nextMonth'    => $this->nextMonth,
            'prevMonth'    => $this->prevMonth,
            'weeks'        => $weeks,
        ];
    }

    /**
     * 週毎のデータを配列化したもの
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
                $day['is_available'] = $this->Availabilities->where('available_date', '=', $day['date'])->isNotEmpty();
            }

            $days[] = (object) $day;
            $tmpDay->addDay(1);
        }
        return $days;
    }
}
