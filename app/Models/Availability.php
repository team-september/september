<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $casts = ['available_date' => 'date'];

    public function availableTimes()
    {
        return $this->hasMany('App\Models\AvailableTime', 'availability_id', 'id');
    }
}
