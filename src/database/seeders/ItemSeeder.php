<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => '腕時計', 'price' => 15000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'condition' => '良好', 'image_path' => 'Clock.jpg'],
            ['name' => 'HDD', 'price' => 5000, 'description' => '高速で信頼性の高いハードディスク', 'condition' => '目立った傷や汚れなし', 'image_path' => 'HDD.jpg'],
            ['name' => '玉ねぎ3束', 'price' => 300, 'description' => '新鮮な玉ねぎ3束のセット', 'condition' => 'やや傷や汚れあり', 'image_path' => 'Onion.jpg'],
            ['name' => '革靴', 'price' => 4000, 'description' => 'クラシックなデザインの革靴', 'condition' => '状態が悪い', 'image_path' => 'LeatherShoes.jpg'],
            ['name' => 'ノートPC', 'price' => 45000, 'description' => '高性能なノートパソコン', 'condition' => '良好', 'image_path' => 'Laptop.jpg'],
            ['name' => 'マイク', 'price' => 8000, 'description' => '高音質のレコーディング用マイク', 'condition' => '目立った傷や汚れなし', 'image_path' => 'Mic.jpg'],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'description' => 'おしゃれなショルダーバッグ', 'condition' => 'やや傷や汚れあり', 'image_path' => 'ShoulderBag.jpg'],
            ['name' => 'タンブラー', 'price' => 500, 'description' => '使いやすいタンブラー', 'condition' => '状態が悪い', 'image_path' => 'Tumbler.jpg'],
            ['name' => 'コーヒーミル', 'price' => 4000, 'description' => '手動のコーヒーミル', 'condition' => '良好', 'image_path' => 'CoffeeMill.jpg'],
            ['name' => 'メイクセット', 'price' => 2500, 'description' => '便利なメイクアップセット', 'condition' => '目立った傷や汚れなし', 'image_path' => 'MakeupSet.jpg'],
        ];

        foreach ($items as $index => $item) {
            Item::create(array_merge($item, ['user_id' => ($index % 5) + 1]));
        }
    }
}
