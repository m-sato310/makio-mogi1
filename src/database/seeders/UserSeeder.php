<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'テストユーザー1',
                'email' => 'user1@example.com',
                'password' => 'password111',
                'zipcode' => '123-4567',
                'address' => '東京都新宿区西新宿1-1-1',
                'building' => '新宿マンション101',
            ],
            [
                'name' => 'テストユーザー2',
                'email' => 'user2@example.com',
                'password' => 'password222',
                'zipcode' => '234-5678',
                'address' => '東京都渋谷区道玄坂2-2-2',
                'building' => '渋谷ハイツ202',
            ],
            [
                'name' => 'テストユーザー3',
                'email' => 'user3@example.com',
                'password' => 'password333',
                'zipcode' => '345-6789',
                'address' => '東京都世田谷区三軒茶屋3-3-3',
                'building' => '世田谷アパート303',
            ],
            [
                'name' => 'テストユーザー4',
                'email' => 'user4@example.com',
                'password' => 'password444',
                'zipcode' => '456-7890',
                'address' => '東京都品川区大井4-4-4',
                'building' => '品川レジデンス404',
            ],
            [
                'name' => 'テストユーザー5',
                'email' => 'user5@example.com',
                'password' => 'password555',
                'zipcode' => '567-8901',
                'address' => '東京都港区六本木5-5-5',
                'building' => '六本木ヒルズ505',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($user['password']),
                'profile_image' => 'default.png',
                'zipcode' => $user['zipcode'],
                'address' => $user['address'],
                'building' => $user['building'],
            ]);
        }
    }
}
