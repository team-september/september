<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Models\Availability;
use App\Models\AvailableTime;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AvailabilityEQRepository implements IAvailabilityRepository
{
    public function getMonthsAvailabilitiesByDate(Carbon $date, int $mentorId): Collection
    {
        return Availability::where('mentor_id', $mentorId)
            ->whereDate('available_date', '>=', $date->firstOfMonth())
            ->whereDate('available_date', '<=', $date->lastOfMonth())
            ->with('availableTimes')
            ->get();
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

    public function updateOrInsertAvailableTimes(Collection $times, int $mentorId): bool
    {
        if ($times->isEmpty()) {
            return true;
        }

        try {
            // 親（設定された空き日）を取得
            $availabilites = Availability::where('mentor_id', $mentorId)
                ->whereIn('available_date', $times->keys())
                ->get();

            foreach ($availabilites as $availability) {
                // 紐づいた子を一回削除
                optional($availability->available_times)->delete();

                // 日付に合致する時間をインサート
                foreach ($times as $date => $time) {
                    if ($availability->available_date !== new Carbon($date)) {
                        continue;
                    }
                    $availableTime = new AvailableTime();
                    $availableTime->availability_id = $availability->id;
                    $availableTime->time = $time;
                    $availableTime->save();
                }
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }
}
