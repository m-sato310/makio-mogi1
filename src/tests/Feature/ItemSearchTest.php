<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_items_can_be_searched_by_partial_name()
    {
        Item::factory()->create(['name' => 'マックブックエアー']);
        Item::factory()->create(['name' => 'アイフォン']);

        $response = $this->get('/?keyword=マック');

        $response->assertStatus(200);
        $response->assertSee('マックブックエアー');
        $response->assertDontSee('アイフォン');
    }

    public function test_search_keyword_is_applied_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => 'マックブックプロ']);
        $item2 = Item::factory()->create(['name' => 'アイフォン']);

        $user->likedItems()->attach([$item1->id, $item2->id]);

        $response = $this->get('/?tab=mylist&keyword=マック');

        $response->assertStatus(200);
        $response->assertSee('マックブックプロ');
        $response->assertDontSee('アイフォン');
    }
}
