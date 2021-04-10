<?php

declare(strict_types=1);

namespace App\Models;

use App\Constants\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // デフォルト値の設定
    protected $attributes = [
        'status' => ReservationStatus::APPLIED,
    ];
}
