<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_detail_page_displays_all_expected_information()
    {
        $user = User::factory()->create();
        $liker1 = User::factory()->create();
        $liker2 = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 9999,
            'description' => 'テスト商品です',
            'condition' => '良好',
            'image_path' => 'dummy.jpg',
        ]);

        $category = Category::factory()->create(['name' => '家電']);
        $item->categories()->attach($category->id);

        $item->comments()->create([
            'user_id' => $user->id,
            'content' => 'テストコメント'
        ]);

        $item->likes()->attach([$liker1->id, $liker2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥9,999');
        $response->assertSee('テスト商品です');
        $response->assertSee('良好');
        $response->assertSee('家電');
        $response->assertSee('テストコメント');
        $response->assertSee($user->name);
        $response->assertSee('storage/items/dummy.jpg');
        $response->assertSee('<span class="like-count">2</span>', false);
        $response->assertSee('<span class="comment-count">1</span>', false);
    }

    public function test_multiple_categories_are_displayed_on_item_detail_page()
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        $category1 = Category::factory()->create(['name' => '家電']);
        $category2 = Category::factory()->create(['name' => '生活用品']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('家電');
        $response->assertSee('生活用品');
    }
}
