<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logged_in_user_can_post_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $commentContent = 'テストコメントです';

        $this->post("/item/{$item->id}/comment", [
            'content' => $commentContent,
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => $commentContent,
        ]);

        $response = $this->get("/item/{$item->id}");
        $response->assertSee($commentContent);
        $response->assertSee('コメント(1)');
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => '未ログインコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => '未ログインコメント',
        ]);
    }

    public function test_validation_error_is_shown_when_comment_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);

        $viewResponse = $this->get("/item/{$item->id}");
        $viewResponse->assertSee('コメントを入力してください', false);
    }

    public function test_validation_error_is_shown_when_comment_exceeds_255_characters()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $tooLongComment = str_repeat('あ', 256);

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => $tooLongComment,
        ]);

        $response->assertSessionHasErrors(['content']);

        $viewResponse = $this->get("/item/{$item->id}");
        $viewResponse->assertSee('コメントは255文字以内で入力してください', false);
    }
}
