<?php

declare(strict_types=1);

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;

class UserQBRepository implements IUserRepository
{
    protected $table = 'users';

    public function getUserBySub($sub)
    {
        return DB::table($this->table)->where('sub', $sub)->first();
    }

    public function getUserById($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function getMentors()
    {
        return DB::table($this->table)->where('is_mentor', 1)->get();
    }
}
