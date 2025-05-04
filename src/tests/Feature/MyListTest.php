<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => '商品1']);
        $item2 = Item::factory()->create(['name' => '商品2']);
        $item3 = Item::factory()->create(['name' => '商品3']);

        $user->likedItems()->attach([$item1->id, $item3->id]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('商品1');
        $response->assertSee('商品3');

        $response->assertDontSee('商品2');
    }

    public function test_sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $itemA = Item::factory()->create(['name' => '商品A']);
        $itemB = Item::factory()->create(['name' => '商品B']);

        $user->likedItems()->attach([$itemA->id, $itemB->id]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $itemB->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }

    public function test_own_items_are_not_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $otherUser = User::factory()->create();
        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
        ]);

        $user->likedItems()->attach([$ownItem->id, $otherItem->id]);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

    public function test_nothing_is_displayed_in_mylist_for_guests()
    {
        Item::factory()->create([
            'name' => 'ログインしないと見えない商品',
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('ログインしないと見えない商品');
    }
}
