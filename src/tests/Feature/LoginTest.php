<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_required()
    {
        $getResponse = $this->get('/login');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $postResponse->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    public function test_password_required()
    {
        $getResponse = $this->get('/login');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $postResponse->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    public function test_invalid_credentials_shows_error_message()
    {
        $getResponse = $this->get('/login');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $postResponse->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません'
        ]);
    }

    public function test_successful_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $getResponse = $this->get('/login');
        $getResponse->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $postResponse->assertRedirect('/?tab=mylist');
        $this->assertAuthenticatedAs($user);
    }
}
