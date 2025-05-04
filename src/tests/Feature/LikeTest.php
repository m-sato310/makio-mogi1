<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_like_an_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => 'いいね対象商品']);

        $this->post("/item/{$item->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get("/item/{$item->id}");
        $response->assertSee('<span class="like-count">1</span>', false);
    }

    public function test_liked_icon_has_liked_class_when_already_liked()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $user->likedItems()->attach($item->id);

        $response = $this->get("/item/{$item->id}");

        $this->assertStringContainsString('class="icon liked"', $response->getContent());
    }

    public function test_user_can_unlike_an_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $this->post("/item/{$item->id}/like");
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->post("/item/{$item->id}/unlike");
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get("/item/{$item->id}");
        $response->assertSee('<span class="like-count">0</span>', false);
    }
}
