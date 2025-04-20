<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purchase::create([
            'user_id' => 1,
            'item_id' => 3,
            'payment_method' => 'クレジットカード',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 7,
            'payment_method' => 'コンビニ払い',
        ]);
    }
}
