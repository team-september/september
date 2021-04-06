<?php

namespace App\Repositories\Reservation;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Exception;

class ReservationEQRepository implements IReservationRepository
{
    /**
     * 予約の新規作成
     * @param ReservationRequest $request
     * @param int $user_id
     * 
     * @return bool 保存に成功した場合はtrueを返す
     * @throws Exception 重複する予約があった場合は例外を投げる
     */
    public function store(ReservationRequest $request, int $user_id):bool 
    {
        $duplicate = Reservation::where('mentee_id', $user_id)
        ->where('mentor_id', $request->mentor_id)
        ->where('date', $request->date)
        ->first();

        if($duplicate) {
            throw new Exception(__FILE__ . 'Error:Duplicate Reservation Found');
        }

        $reservation = new Reservation();
        $reservation->mentee_id = $user_id;
        $reservation->mentor_id = $request->mentor_id;
        $reservation->date = $request->date;
        $reservation->time = $request->time;        

        return $reservation->save();
    }
}