<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Like::create([
            'user_id' => 1,
            'item_id' => 2,
        ]);

        Like::create([
            'user_id' => 1,
            'item_id' => 3,
        ]);

        Like::create([
            'user_id' => 2,
            'item_id' => 5,
        ]);
    }
}
