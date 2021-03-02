<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    public function availableTimes()
    {
        return $this->hasMany('App\Models\AvailableTime', 'availability_id', 'id');
    }
}
