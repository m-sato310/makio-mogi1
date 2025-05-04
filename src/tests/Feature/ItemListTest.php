<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_items_are_displayed()
    {
        Item::factory()->create([
            'name' => 'テスト商品A',
        ]);
        Item::factory()->create([
            'name' => 'テスト商品B',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品A');
        $response->assertSee('テスト商品B');
    }

    public function test_sold_label_is_displayed_for_purchased_items()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_logged_in_users_own_items_are_not_displayed()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Item::factory()->create([
            'user_id' => $userA->id,
            'name' => '自分の商品',
        ]);

        Item::factory()->create([
            'user_id' => $userB->id,
            'name' => '他人の商品',
        ]);

        $this->actingAs($userA);
        $response = $this->get('/');

        $response->assertDontSee('自分の商品');

        $response->assertSee('他人の商品');
    }
}
