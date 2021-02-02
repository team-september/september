<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function mentorApplications()
    {
        return $this->hasMany('App\Models\Application', 'mentor_id', 'id');
    }

    public function menteeApplications()
    {
        return $this->hasMany('App\Models\Application', 'mentee_id', 'id');
    }

}
