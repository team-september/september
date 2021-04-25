<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Http\Requests\MultipleProfileUpdateRequest;

interface IUserRepository
{
    public function create($userInfo);

    public function update($user, MultipleProfileUpdateRequest $request);

    public function getBySub($sub);

    public function getById($id);

    public function getMentors();
}
