<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\ItemSeeder;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function 全商品を取得できる()
    {
        $this->seed(ItemSeeder::class);

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);

        $expectedItems = [
            '腕時計', 'HDD', '玉ねぎ3束', '革靴', 'ノートPC',
            'マイク', 'ショルダーバッグ', 'タンブラー', 'コーヒーミル', 'メイクセット',
        ];

        foreach ($expectedItems as $name) {
            $response->assertSee($name);
        }
    }

    /** @test */
    public function 購入済み商品は「_sold」と表示される()
    {
        $this->seed(MasterDataSeeder::class);
        $item = Item::factory()->create();

        $buyer = User::factory()->create();
        Purchase::factory()->for($item)->create([
            'user_id' => $buyer->id,
        ]);

        $response = $this->get(route('items.index'));

        $response->assertSee('Sold');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $this->seed(MasterDataSeeder::class);

        $user = User::factory()->create();
        $this->actingAs($user);

        $myItem = Item::factory()->create(['user_id' => $user->id]);

        $otherItem = Item::factory()->SpecificData()->create();

        $response = $this->get(route('items.index'));

        $response->assertDontSee($myItem->name);
        $response->assertSee($otherItem->name);
    }
}
