<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Models\Availability;
use App\Models\AvailableTime;
use App\Models\User;
use App\Repositories\Mentorship\IMentorshipRepository;
use App\Repositories\Reservation\IReservationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AvailabilityEQRepository implements IAvailabilityRepository
{
    public function __construct(
        IMentorshipRepository $mentorshipRepository,
        IReservationRepository $reservationRepository
    ) {
        $this->mentorshipRepository = $mentorshipRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getMonthsAvailabilitiesByDate(Carbon $date, User $user): Collection
    {
        $query = Availability::query();

        // メンターIDで絞り込み
        $mentorId = $this->mentorshipRepository->getMentorIdByUser($user);
        $query->where('mentor_id', $mentorId);

        // 既に予約日が紐付いているものは除外
        $existingReservationDates = $this->reservationRepository->fetchReservationsByMenteeId($user->id)->pluck('date');

        if ($existingReservationDates->isNotEmpty()) {
            $query->whereNotIn('available_date', $existingReservationDates);
        }
        // 日付が該当月のもの
        $query->whereDate('available_date', '>=', $date->firstOfMonth());
        $query->whereDate('available_date', '<=', $date->lastOfMonth());

        return $query->with('availableTimes')->get();
    }

    public function findAvailabilitiesByDates(Collection $dates, int $mentorId): Collection
    {
        return Availability::where('mentor_id', $mentorId)
            ->whereIn('available_date', $dates)
            ->get();
    }

    public function removeAvailabilitiesByDates(Collection $dates, int $mentorId): bool
    {
        // コレクションが空ならreturn
        if ($dates->isEmpty()) {
            return true;
        }

        try {
            foreach ($dates as $date => $values) {
                $targetDate = new Carbon($date);
                $availability = Availability::where('mentor_id', $mentorId)->where('available_date', $targetDate)->first();

                if ($availability) {
                    $availability->delete();
                }
            }
            return true;
        } catch (Exception $ex) {
            Log::error(__FILE__ . $ex->getMessage());
            return false;
        }
    }

    public function updateOrInsertAvailabilitiesByDates(Collection $dates, int $mentorId): Collection
    {
        $availabilities = []; // 返却用配列

        // コレクションが空ならreturn
        if ($dates->isEmpty()) {
            return collect($availabilities);
        }

        try {
            foreach ($dates as $date => $values) {
                $targetDate = new Carbon($date);

                // 該当するレコードがなければ新しいレコードをインスタンス化
                $availability = Availability::where('mentor_id', $mentorId)->where('available_date', $targetDate)->firstOrNew();

                $availability->mentor_id = $mentorId;
                $availability->available_date = $targetDate;
                $availability->save();

                $availabilities[] = $availability; // 更新したら返却用の配列にセット
            }

            return collect($availabilities); // コレクションインスタンスにして返却
        } catch (\Throwable $th) {
            Log::error(__FILE__ . $th->getMessage());
            return new Collection(); // エラーの場合は空コレクションを返却
        }
    }

    public function updateAvailableTimes(Collection $times, int $mentorId): bool
    {
        if ($times->isEmpty()) {
            return true;
        }

        try {
            // 親（設定された空き日）を取得
            $availabilities = Availability::where('mentor_id', $mentorId)
                ->whereIn('available_date', $times->keys())
                ->get();

            $availabilities->map(function($availability) use ($times) {
                // 紐づいた空き時間を一回削除
                optional($availability->available_times)->delete();

                // 日付に合致する時間をインサート
                foreach ($times as $date => $times) {
                    if ($date !== $availability->available_date->format('Y-m-d')) {
                        continue;
                    }
                    
                    array_map(function($time) use ($availability) {
                        $availableTime = new AvailableTime();
                        $availableTime->availability_id = $availability->id;
                        $availableTime->time = $time;
                        $availableTime->save();
                    }, $times);
                }
            });
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }
}
