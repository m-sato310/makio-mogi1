<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_selected_payment_method_is_reflected_in_purchase()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee('支払い方法');

        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'コンビニ払い',
            'zipcode' => '123-4567',
            'address' => '東京都港区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'コンビニ払い',
        ]);
    }
}
