<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'user_id',
        'career_id',
        'goal',
        'created_at',
        'updateed_at'
    ];
}
