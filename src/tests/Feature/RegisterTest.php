<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_name_required()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $postResponse->assertSessionHasErrors([
            'name' => 'お名前を入力してください'
        ]);
    }

    public function test_email_required()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $postResponse->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    public function test_password_required()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $postResponse->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    public function test_password_must_be_at_least_8_characters()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $postResponse->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    public function test_password_confirmation_must_match()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $postResponse->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません'
        ]);
    }

    public function test_successful_registration_redirects_to_verify_email()
    {
        $getResponse = $this->get('/register');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
        ]);

        $postResponse->assertRedirect('/verify-email');
    }
}
