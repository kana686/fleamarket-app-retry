<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(5)->create();

        $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
        foreach ($categories as $categoryName) {
            Category::updateOrCreate(['content' => $categoryName]);
        }

        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];
        foreach ($conditions as $conditionName) {
            Condition::updateOrCreate(['content' => $conditionName]);
        }
        $conditionMap = Condition::all()->pluck('id', 'content');

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => '高級感のある腕時計です。',
                'image_filename' => 'Armani-Mens-Clock.jpg',
                'condition_name' => '良好',
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image_filename' => 'HDD-Hard-Disk.jpg',
                'condition_name' => '目立った傷や汚れなし',
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand_name' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_filename' => 'onion.jpg',
                'condition_name' => 'やや傷や汚れあり',
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand_name' => '',
                'description' => 'クラシックなデザインの革靴',
                'image_filename' => 'Leather-Shoes.jpg',
                'condition_name' => '状態が悪い',
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => '',
                'description' => '高性能なノートパソコン',
                'image_filename' => 'Laptop.jpg',
                'condition_name' => '良好',
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand_name' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_filename' => 'Music-Mic.jpg',
                'condition_name' => '目立った傷や汚れなし',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'image_filename' => 'red-bag.jpg',
                'condition_name' => 'やや傷や汚れあり',
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand_name' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_filename' => 'Tumbler.jpg',
                'condition_name' => '状態が悪い',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_filename' => 'Coffee-Grinder.jpg',
                'condition_name' => '良好',
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => '',
                'description' => '便利なメイクアップセット',
                'image_filename' => 'cosme-set.jpg',
                'condition_name' => '目立った傷や汚れなし',
            ],
        ];

        foreach ($items as $item) {
            $sourcePath = database_path('seeders/images/'.$item['image_filename']);
            $targetPath = storage_path('app/public/'.$item['image_filename']);

            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $targetPath);
            }

            $createdItem = Item::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'condition_id' => $conditionMap[$item['condition_name']],
                'name' => $item['name'],
                'price' => $item['price'],
                'brand_name' => $item['brand_name'] ?? null,
                'description' => $item['description'],
                'img_url' => $item['image_filename'],
            ]);

            $categoryIds = Category::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $createdItem->categories()->attach($categoryIds);
        }
    }
}
