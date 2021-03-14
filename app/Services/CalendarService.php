<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Availability\IAvailabilityRepository;
use App\Repositories\Mentorship\IMentorshipRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * 現在ログイン中のユーザーに合わせてカレンダー用のデータを返すクラス
 * 1. メンティーの場合は紐づいたメンターの予定
 * 2. メンターの場合は過去の日付以外は設定のリンク表示.
 */
class CalendarService
{
    public User $user;

    protected Collection $Availabilities;

    protected Carbon $Carbon;

    protected Carbon $fistDayOfMonth;

    protected Carbon $nextMonth;

    protected Carbon $prevMonth;

    public function __construct(User $user, Request $request)
    {
        $this->user = $user;

        // 日付系のデータ取得／加工
        $this->Carbon = $request->ym ? new Carbon($request->ym) : Carbon::now();
        $this->firstDayOfMonth = $this->Carbon->copy()->firstOfMonth();
        $this->lastDayOfMonth = $this->Carbon->copy()->lastOfMonth();
        $this->prevMonth = $this->Carbon->copy()->subMonthsNoOverflow();
        $this->nextMonth = $this->Carbon->copy()->addMonthsNoOverflow();

        // メンターID取得（メンティーの場合は担当メンター）
        $mentor_id = $this->user->is_mentor ? $this->user->id : app(IMentorshipRepository::class)->getMentorIdByMenteeId($this->user->id);

        // メンターに紐づいた予約可能日取得
        $this->Availabilities = app(IAvailabilityRepository::class)->getMonthsAvailabilitiesByDate($this->Carbon, $mentor_id);
    }

    /**
     * @return Carbon $this->Carbon
     */
    public function getCurrentMonth(): Carbon
    {
        return $this->Carbon;
    }

    /**
     * @return Carbon $this->prevMonth
     */
    public function getPrevMonth(): Carbon
    {
        return $this->prevMonth;
    }

    /**
     * @return Carbon $this->prevMonth
     */
    public function getNextMonth(): Carbon
    {
        return $this->nextMonth;
    }

    /**
     * 日付データの取得.
     *
     * @return array $weeks
     */
    public function getCalendarData(): array
    {
        $weeks = [];
        $tmpDay = $this->firstDayOfMonth->copy();

        // 月末までループ
        while ($tmpDay->lte($this->lastDayOfMonth)) {
            $weeks[] = $this->getDays($tmpDay);
            $tmpDay->addDay(7);
        }

        return $weeks;
    }

    /**
     * 日付文字列配列.
     * @param Carbon $date
     * @return array $days
     */
    private function getDays(Carbon $date): array
    {
        $tmpDay = $date->copy()->startOfWeek(); // 週の頭にセット

        // 週末までループ
        $endOfWeek = $date->copy()->endOfWeek();
        $days = [];
        while ($tmpDay->lte($endOfWeek)) {
            //前の月、もしくは後ろの月の場合は空文字
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
