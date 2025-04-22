<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'user_id' => 1,
            'item_id' => 2,
            'content' => 'このHDDは何TBの容量ですか？また使用頻度や動作状況について教えていただけますか？',
        ]);

        Comment::create([
            'user_id' => 2,
            'item_id' => 3,
            'content' => '玉ねぎは新鮮な状態でしょうか？発送の際はどのような梱包になりますか？',
        ]);

        Comment::create([
            'user_id' => 3,
            'item_id' => 4,
            'content' => 'サイズ感が気になります。普段26.5cmを履いているのですが、ちょうど良いでしょうか？',
        ]);

        Comment::create([
            'user_id' => 4,
            'item_id' => 5,
            'content' => 'バッテリーの持ちはどのくらいですか？動作はスムーズでしょうか？気になっています。',
        ]);

        Comment::create([
            'user_id' => 5,
            'item_id' => 1,
            'content' => 'この腕時計、デザインがとても気に入りました。実物は写真通りの色味でしょうか？',
        ]);
    }
}
