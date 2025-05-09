<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileEditTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_profile_edit_screen_displays_initial_user_info()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'zipcode' => '111-2222',
            'address' => '東京都世田谷区',
            'profile_image' => 'test.png',
        ]);
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertSee('value="テストユーザー"', false);
        $response->assertSee('value="111-2222"', false);
        $response->assertSee('value="東京都世田谷区"', false);

        $response->assertSee('src="' . asset('storage/profile/test.png') . '"', false);
    }
}
