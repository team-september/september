<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

class UserEQRepository implements IUserRepository
{
    public function create($userInfo)
    {
        return User::create(
            [
                'sub' => $userInfo['sub'],
                'is_mentor' => 0,
                'nickname' => $userInfo['nickname'],
                'name' => $userInfo['name'],
                'picture' => $userInfo['picture'],
            ]
        );
    }

    public function update($user, $request)
    {
        return $user->fill(
            [
                'name' => $request->name,
            ]
        )->save();
    }

    public function getUserBySub($sub)
    {
        return User::where('sub', $sub)->first();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getMentors()
    {
        return User::where('is_mentor', 1)->get();
    }
}
