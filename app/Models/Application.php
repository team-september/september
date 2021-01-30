<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mentor()
    {
        return $this->belongsTo('App\Models\User', 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo('App\Models\User', 'mentee_id');
    }

    public function read_applications()
    {
        return $this->hasMany('App\Models\ReadApplication', 'user_id', 'mentor_id');
    }

}
