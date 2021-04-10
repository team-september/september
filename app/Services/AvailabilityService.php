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

    public function __construct(
        IUserRepository $userRepository,
        IMentorshipRepository $mentorshipRepository,
        IAvailabilityRepository $availabilityRepository
    ) {
        $this->mentorshipRepository = $mentorshipRepository;
        $this->availabilityRepository = $availabilityRepository;

        // 現在ログイン中のユーザー
        $this->user = $userRepository->getUserBySub(Auth::id());
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
        $this->carbon = $date;
        // メンターに紐づいた当月の予約可能日取得
        $this->availabilities = $this->availabilityRepository->getMonthsAvailabilitiesByDate($this->carbon, $this->user);
        $lastDayOfMonth = $this->carbon->copy()->lastOfMonth();

        $weeks = [];
        $tmpDay = $this->carbon->copy()->firstOfMonth(); // 月初からスタートする

        // 月末までループ
        while ($tmpDay->lte($lastDayOfMonth)) {
            $weeks[] = $this->getDaysByWeek($tmpDay);
            $tmpDay->addDay(7);
        }

        return (object) [
            'mentor_id' => $this->mentorshipRepository->getMentorIdByUser($this->user),
            'currentMonth' => $this->carbon,
            'nextMonth' => $this->carbon->copy()->addMonthsNoOverflow(),
            'prevMonth' => $this->carbon->copy()->subMonthsNoOverflow(),
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
     * @param Carbon $week
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
    private function getDaysByWeek(Carbon $week): array
    {
        $tmpDay = $week->copy()->startOfWeek(); // 週の頭にセット
        $endOfWeek = $week->copy()->endOfWeek(); // 週末を定義

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
                $day['is_available'] = $this->isAvailableDate($day['date']);
            }

            $days[] = (object) $day;
            $tmpDay->addDay(1);
        }
        return $days;
    }

    /**
     * Y-m-dの文字列を渡すと取得済みのコレクションから予約可能な日かどうかを判定.
     * @param string $date
     * @return bool
     */
    private function isAvailableDate(string $date): bool
    {
        return $this->availabilities
            ->filter(
                function ($availability) use ($date) {
                    return $availability->available_date->format('Y-m-d') == $date;
                }
            )
            ->isNotEmpty();
    }
}
