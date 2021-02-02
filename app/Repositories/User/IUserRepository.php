<?php

declare(strict_types=1);

namespace App\Repositories\User;

interface IUserRepository
{
    public function create($userInfo);

    public function update($user, $request);

    public function getUserBySub($sub);

    public function getUserById($id);

    public function getMentors();
}
