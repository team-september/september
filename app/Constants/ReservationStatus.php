<?php

declare(strict_types=1);

namespace App\Constants;

class ReservationStatus
{
    const APPLIED = 1; // 申請中
    const APPROVED = 2; // 承認済み
    const DECLINED = 3; // 却下
}