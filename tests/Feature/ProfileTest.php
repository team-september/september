<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ProfileTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function ゲストユーザーはNavのプロフィールリンクが見えない(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertDontSee('プロフィール');
    }

    /**
     * @test
     */
    public function ゲストユーザーがプロフィールにアクセスしようとするとログイン画面にリダイレクトされる(): void
    {
        $response = $this->get('/profile');
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

//    /**
//     * @test
//     */
//    public function 認証ユーザーはNavのプロフィールリンクが見える(): void
//    {
//        $user = AuthUtil::createDummyAuthUser();
//        $this->be($user);
//
//        $response = $this->get('/');
//        $response->assertStatus(200)
//            ->assertSee('プロフィール');
//    }
//
//    /**
//     * @test
//     */
//    public function 認証ユーザーは自分の情報がプロフィール画面で見れる(): void
//    {
//        $user = AuthUtil::createDummyAuthUser();
//        $this->be($user);
//
//        $response = $this->get('/profile');
//        $response->assertStatus(200)
//            ->assertSee('Ryo')
//            ->assertSee('https://example.com/picture.png');
//    }
}
