<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MultipleProfileUpdateRequest;
use App\Repositories\User\IUserRepository;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getOrCreate($auth0User)
    {
        $user = $this->userRepository->getBySub($auth0User->sub);

        //データがない場合ユーザー関連情報を作成
        if (empty($user)) {
            $userInfo = [
                'sub' => $auth0User->sub,
                'nickname' => $auth0User->nickname,
                'name' => $auth0User->name,
                'picture' => $auth0User->picture,
            ];

            $user = $this->userRepository->create($userInfo);
            // UserObserverにて関連レコードを作成
        }

        return $user;
    }

    public function getUserBySub(string $sub)
    {
        return $this->userRepository->getBySub($sub);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->getById($userId);
    }

    public function update($user, MultipleProfileUpdateRequest $request)
    {
        return $this->userRepository->update($user, $request);
    }
}
