<?php

declare(strict_types=1);

namespace App\Repositories\Reservation;

use App\Constants\ReservationStatus;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReservationEQRepository implements IReservationRepository
{
    public function getReservationsByMenteeId(int $menteeId): Collection
    {
        return DB::table('reservations')
            ->where('mentee_id', $menteeId)
            ->where('status', ReservationStatus::APPLIED)
            ->join('users', 'users.id', 'reservations.mentor_id')
            ->get();
    }

    public function getReservationsByMentorId(int $mentorId): Collection
    {
        return DB::table('reservations')
            ->select('reservations.id as reservation_id', '*')
            ->where('mentor_id', $mentorId)
            ->where('status', ReservationStatus::APPLIED)
            ->join('users', 'users.id', 'reservations.mentee_id')
            ->get();
    }

    /**
     * 予約の新規作成.
     *
     * @param StoreReservationRequest $request
     * @param int                     $user_id
     *
     * @throws Exception 重複する予約があった場合は例外を投げる
     * @return bool 保存に成功した場合はtrueを返す
     */
    public function store(StoreReservationRequest $request, int $user_id): bool
    {
        $duplicate = Reservation::where('mentee_id', $user_id)
            ->where('mentor_id', $request->mentor_id)
            ->where('date', $request->date)
            ->first();

        if ($duplicate) {
            throw new Exception(__FILE__ . 'Error:Duplicate Reservation Found');
        }

        $reservation = new Reservation();
        $reservation->mentee_id = $user_id;
        $reservation->mentor_id = $request->mentor_id;
        $reservation->date = $request->date;
        $reservation->time = $request->time;

        return $reservation->save();
    }

    public function update(UpdateReservationRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            // 予約ステータスの更新
            foreach ($data['reservation-ids'] as $reservationId) {
                Reservation::where('id', $reservationId)->update(
                    [
                        'status' => $data['status'],
                        'mentor_comment' => $data['comment'][$reservationId],
                    ]
                );
            }

            // 選択されなかった同一ユーザーの他リクエストを削除
            Reservation::whereNotIn('id', $data['reservation-ids'])
                ->whereIn('mentee_id', $data['user-ids'])
                ->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function fetchReservationsByMenteeId(int $menteeId): Collection
    {
        return Reservation::where('mentee_id', $menteeId)->get();
    }
}
