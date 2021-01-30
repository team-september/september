<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Utils\AuthUtil;

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
        $user = AuthUtil::createDummyAuthUser();
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
        $user = AuthUtil::createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('ログイン');
    }
}
