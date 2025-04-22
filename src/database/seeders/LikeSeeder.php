<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
                'user_id' => 1,
                'item_id' => 2,
            ],
            [
                'user_id' => 1,
                'item_id' => 3,
            ],
            [
                'user_id' => 2,
                'item_id' => 5,
            ],
        ]);
    }
}
