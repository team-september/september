<?php

declare(strict_types=1);

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

    public function readApplications()
    {
        return $this->hasMany('App\Models\ReadApplication', 'user_id', 'mentor_id');
    }

    public function readApproval()
    {
        return $this->hasMany('App\Models\ReadApproval', 'user_id', 'mentee_id');
    }
}
