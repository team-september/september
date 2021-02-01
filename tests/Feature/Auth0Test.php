<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\AuthUtil;

class Auth0Test extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function ゲストはログインボタンが見える(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('ログイン');
    }

    /**
     * @test
     */
    public function ゲストはログアウトボタンが見えない(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('ログアウト');
    }

    /**
     * @test
     */
    public function 認証ユーザーはログアウトボタンが見える(): void
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
    public function 認証ユーザーはログインボタンが見えない(): void
    {
        $user = AuthUtil::createDummyAuthUser();
        $this->be($user);

        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('ログイン');
    }
}
