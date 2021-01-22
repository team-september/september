<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'career_id',
        'created_at',
        'updateed_at'
    ];

    //purposeの取得
    public function purposes()
    {
        return $this->belongsToMany('App\Models\Purpose', 'profile_purposes');
    }

    //skillの取得
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'profile_skills');
    }

    //urlの取得
    public function urls()
    {
        return $this->belongsToMany('App\Models\Url', 'profile_urls');
    }

}
