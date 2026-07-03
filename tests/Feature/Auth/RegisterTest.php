<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 名前が未入力だとバリデーションエラーになる()
    {
        $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    /** @test */
    public function メールアドレスが未入力だとバリデーションエラーになる()
    {
        $this->from('/register')->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    /** @test */
    public function パスワードが未入力だとバリデーションエラーになる()
    {
        $this->from('/register')->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ])->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    /** @test */
    public function test_必須項目が未入力だとバリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
    }

    /** @test */
    public function test_パスワードが7文字以下だとエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    /** @test */
    public function test_確認用パスワードと一致しないとエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);
    }

    /** @test */
    public function test_正常に会員登録できてプロフィール画面へ遷移する()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'taro@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'taro@example.com']);
        $this->assertAuthenticated();
        $response->assertRedirect(route('profile.edit'));
    }
}
