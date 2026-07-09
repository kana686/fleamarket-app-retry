<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Mylist;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\ItemSeeder;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
    public function 商品名で部分一致検索ができる()
    {
        $targetItem = Item::factory()->create(['name' => '美味しい時計']);
        $otherItem = Item::factory()->create(['name' => 'おいしいお皿']);

        $response = $this->get(route('items.index', ['keyword' => '時計']));

        $response->assertSee('美味しい時計');
        $response->assertDontSee('おいしいお皿');
    }

    #[Test]
    public function 検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $keyword = '時計';
        $item = Item::factory()->create(['name' => '高級時計']);
        Mylist::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->get(route('items.index', [
            'tab' => 'mylist',
            'keyword' => $keyword,
        ]));

        $response->assertSee('value="'.$keyword.'"', false);

        $response->assertSee('高級時計');
    }
}
