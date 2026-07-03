<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function メールアドレスが未入力だとエラーになる()
    {
        $this->from('/login')->post('/login', [
            'email' => '',
            'password' => 'password123',
        ])->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    /** @test */
    public function パスワードが未入力だとエラーになる()
    {
        $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ])->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    /** @test */
    public function 登録済みのユーザーでログインできる()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    /** @test */
    public function 間違ったパスワードではログインできない()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }

    /** @test */
    public function 登録されていないメールアドレスではログインできない()
    {
        $user = User::factory()->create([
            'email' => 'best@example.com',
            'password' => 'password',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'not-registered@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }
}
