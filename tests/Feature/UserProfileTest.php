<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function プロフィールページで必要な情報が取得できる()
    {
        $me = User::factory()->create([
            'name' => 'テスト太郎',
            'img_url' => 'profiles/test_image.jpg',
        ]);

        $mySellItem = Item::factory()->create(['user_id' => $me->id, 'name' => '出品した腕時計']);

        $otherSeller = User::factory()->create();
        $othersItem = Item::factory()->create(['user_id' => $otherSeller->id, 'name' => '購入したバッグ']);

        Purchase::create([
            'user_id' => $me->id,
            'item_id' => $othersItem->id,
            'post_code' => '000-0000',
            'address' => '住所',
            'payment_method' => 1,
            'status' => Purchase::STATUS_COMPLETED,
        ]);

        $this->actingAs($me)
            ->get(route('mypage'))
            ->assertStatus(200)
            ->assertSee('テスト太郎')
            ->assertSee('test_image.jpg')
            ->assertSee('出品した腕時計')
            ->assertDontSee('購入したバッグ');

        $this->actingAs($me)
            ->get(route('mypage', ['tab' => 'buy']))
            ->assertStatus(200)
            ->assertSee('購入したバッグ')
            ->assertDontSee('出品した腕時計');
    }

    #[Test]
    public function プロフィール編集画面に初期値が正しく表示される()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'コーポ101',
        ]);

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertStatus(200)
            ->assertSee('value="テスト太郎"', false)
            ->assertSee('value="123-4567"', false)
            ->assertSee('value="東京都渋谷区"', false)
            ->assertSee('value="コーポ101"', false);
    }
}
