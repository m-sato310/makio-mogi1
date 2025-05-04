<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemRegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register_new_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $categories = Category::factory()->count(2)->create();

        Storage::fake('public');
        // $image = UploadedFile::fake()->image('test.jpg');
        $image = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $this->get('/sell')->assertStatus(200);

        $response = $this->post('/sell', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'これはテスト商品です。',
            'condition' => '良好',
            'image_path' => $image,
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'これはテスト商品です。',
            'condition' => '良好',
        ]);

        foreach ($categories as $category) {
            $this->assertDatabaseHas('item_category', [
                'category_id' => $category->id,
            ]);
        }

        Storage::disk('public')->assertExists('items/' . $image->hashName());

        $response->assertRedirect('/mypage');
    }
}
