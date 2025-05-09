<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_shipping_address_is_reflected_on_purchase_screen()
    {
        $user = User::factory()->create([
            'zipcode' => '000-0000',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);
        $this->actingAs($user);

        $item = Item::factory()->create();

        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee('000-0000');
        $response->assertSee('旧住所');
        $response->assertSee('旧ビル');

        $this->post("/purchase/address/{$item->id}", [
            'zipcode' => '111-2222',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $response = $this->get("/purchase/{$item->id}");
        $response->assertSee('111-2222');
        $response->assertSee('東京都新宿区');
        $response->assertSee('テストビル');

        $response->assertDontSee('000-0000');
        $response->assertDontSee('旧住所');
        $response->assertDontSee('旧ビル');
    }

    public function test_shipping_address_is_stored_with_purchase()
    {
        $user = User::factory()->create([
            'zipcode' => '000-0000',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);
        $this->actingAs($user);

        $item = Item::factory()->create();

        $this->post("/purchase/address/{$item->id}", [
            'zipcode' => '222-3333',
            'address' => '東京都世田谷区',
            'building' => 'テストビル',
        ]);

        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'カード',
            'zipcode' => '222-3333',
            'address' => '東京都世田谷区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'zipcode' => '222-3333',
            'address' => '東京都世田谷区',
            'building' => 'テストビル',
        ]);
    }
}
