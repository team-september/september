<?php

declare(strict_types=1);

namespace Tests\Feature;

use Auth0\Login\Auth0JWTUser;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Auth0Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function a_guest_can_see_the_login_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('ログイン');
    }

    /**
     * @test
     */
    public function a_guest_cannot_see_the_logout_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('ログアウト');
    }

    /**
     * @test
     */
    public function an_auth_user_can_see_the_logout_button(): void
    {
        $user = $this->createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('ログアウト');
    }

    /**
     * @test
     */
    public function an_auth_user_cannot_see_the_login_button(): void
    {
        $user = $this->createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('ログイン');
    }

    /**
     * ダミーのログインユーザーを作成して返却.
     * @return null|\Illuminate\Contracts\Auth\Authenticatable
     */
    private function createDummyAuthUser()
    {
        $dummyAuth0User = [
            'sub' => 'auth0|xxxx|xxxxxxxx',
            'nickname' => 'nickname',
            'name' => 'user name',
            'picture' => 'https://example.com/picture.png',
            'updated_at' => '2020-11-29T08:10:37.855Z',
            'email' => 'test@example.com',
        ];

        $auth0 = new Auth0JWTUser($dummyAuth0User);
        Auth::setUser($auth0);

        return Auth::user();
    }
}
