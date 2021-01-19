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
        'goal',
        'career_id',
        'created_at',
        'updateed_at'
    ];
    protected $primaryKey = 'user_id';
}
