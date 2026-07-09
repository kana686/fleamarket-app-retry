<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ItemExhibitionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function 出品商品情報が正しく保存されること(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $condition = Condition::create(['id' => 1, 'content' => '新品、未使用']);
        $category = Category::create(['id' => 1, 'content' => 'レディース']);

        $dummyImage = UploadedFile::fake()->image('item.jpg');

        $requestData = [
            'name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'description' => 'これは商品の説明文です。',
            'img_url' => $dummyImage,
            'categories' => [$category->id],
            'condition_id' => $condition->id,
            'price' => '5,000',
        ];

        $response = $this->actingAs($user)
            ->post(route('sell.store'), $requestData);

        $response->assertRedirect(route('mypage'));
        $response->assertSessionHas('message', '登録が完了しました！');

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'price' => 5000,
            'description' => 'これは商品の説明文です。',
        ]);

        $this->assertDatabaseHas('category_item', [
            'category_id' => $category->id,
        ]);

        $item = Item::first();
        Storage::disk('public')->assertExists($item->img_url);
    }
}
