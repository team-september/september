<?php

declare(strict_types=1);

namespace Tests\Utils;

use Auth0\Login\Auth0JWTUser;
use Illuminate\Support\Facades\Auth;

class AuthUtil
{
    /**
     * ダミーのログインユーザーを作成して返却.
     * @return null|\Illuminate\Contracts\Auth\Authenticatable
     */
    public static function createDummyAuthUser()
    {
        $dummyAuth0User = [
            'sub' => 'auth0|xxxx|xxxxxxxx',
            'nickname' => 'Ryo',
            'name' => 'Ryo',
            'picture' => 'https://example.com/picture.png',
            'updated_at' => '2020-11-29T08:10:37.855Z',
            'email' => 'test@example.com',
        ];

        $auth0 = new Auth0JWTUser($dummyAuth0User);
        Auth::setUser($auth0);

        return Auth::user();
    }
}
