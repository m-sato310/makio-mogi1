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
            'zipcode' => '123-4567',
            'address' => '東京都新宿区西新宿1-1-1',
            'building' => '新宿マンション101',
        ]);

        Purchase::create([
            'user_id' => 1,
            'item_id' => 8,
            'payment_method' => 'クレジットカード',
            'zipcode' => '321-9876',
            'address' => '北海道札幌市中央区1-1-1',
            'building' => '札幌マンション101',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 7,
            'payment_method' => 'コンビニ払い',
            'zipcode' => '345-6789',
            'address' => '東京都世田谷区三軒茶屋3-3-3',
            'building' => '世田谷アパート303',
        ]);
    }
}
