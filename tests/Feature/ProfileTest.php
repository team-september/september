<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Utils\AuthUtil;

class ProfileTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function a_guest_cannot_see_the_profile_link_in_the_navigation(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('プロフィール');
    }

    /**
     * @test
     */
    public function a_guest_will_be_prompted_to_login_if_trying_to_access_the_profile_page(): void
    {
        $response = $this->get('/profile');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_auth_user_can_see_the_profile_link_in_the_navigation(): void
    {
        $user = AuthUtil::createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('プロフィール');
    }

    /**
     * @test
     */
    public function an_auth_user_can_see_his_information_in_the_profile(): void
    {
        $user = AuthUtil::createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/profile');
        $response->assertStatus(200)
            ->assertSee('Ryo')
            ->assertSee('https://example.com/picture.png');
    }
}
