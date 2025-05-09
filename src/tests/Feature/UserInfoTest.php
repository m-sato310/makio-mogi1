<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_information_is_displayed_on_mypage()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'default.png',
        ]);
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        $purchasedItem = Item::factory()->create([
            'name' => '購入商品B',
        ]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $response = $this->get('/mypage');
        $response->assertSee('テストユーザー');
        $response->assertSee('default.png');
        $response->assertSee('出品商品A');

        $buyTab = $this->get('/mypage?tab=buy');
        $buyTab->assertSee('購入商品B');
    }
}
