<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Condition;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
        foreach ($categories as $categoryName) {
            Category::updateOrCreate(['content' => $categoryName]);
        }

        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];
        foreach ($conditions as $conditionName) {
            Condition::updateOrCreate(['content' => $categoryName]);
        }
    }
}
