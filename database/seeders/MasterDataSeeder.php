<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Condition;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
        foreach ($categories as $categoryName) {
            Category::create(['content' => $categoryName]);
        }

        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];
        foreach ($conditions as $conditionName) {
            Condition::create(['content' => $conditionName]);
        }
    }
}
