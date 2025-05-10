<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_purchase_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee('テスト商品');

        $response = $this->post("/purchase/{$item->id}", [
            'payment_method' => 'カード',
            'zipcode' => '123-4567',
            'address' => '東京都港区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード',
        ]);
    }

    public function test_purchased_item_is_shown_as_sold_on_item_list()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $this->actingAs($buyer);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee($item->name);

        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'カード',
            'zipcode' => '123-4567',
            'address' => '東京都港区',
            'building' => 'テストビル',
        ]);

        $itemList = $this->get('/');

        $itemList->assertSee('Sold');
    }

    public function test_purchased_item_appears_in_user_profile_purchase_list()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $this->actingAs($buyer);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
        ]);

        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee($item->name);

        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'カード',
            'zipcode' => '123-4567',
            'address' => '東京都港区',
            'building' => 'テストビル',
        ]);

        $response = $this->get('/mypage?tab=buy');

        $response->assertSee('テスト商品');
    }
}
