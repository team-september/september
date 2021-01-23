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

    public function modify($request)
    {
        return $this->fill(
            [
                'name' => $request->name
            ]
        )->save();
    }


    public static function findBySub($sub)
    {
        return self::where('sub', $sub)->first();
    }

    public static function make($user_info)
    {
        return self::create(
            [
                'sub' => $user_info['sub'],
                'is_mentor' => 0,
                'nickname' => $user_info['nickname'],
                'name' => $user_info['name'],
                'picture' => $user_info['picture'],
            ]
        );
    }
}
