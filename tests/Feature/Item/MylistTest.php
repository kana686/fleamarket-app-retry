<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Mylist;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedItem = Item::factory()->create(['name' => '好きな商品']);
        Mylist::factory()->create(['user_id' => $user->id, 'item_id' => $likedItem->id]);

        $otherItem = Item::factory()->create(['name' => 'その他の商品']);

        $response = $this->get(route('items.index', ['tab' => 'mylist']));
        $response->assertSee('好きな商品');
        $response->assertDontSee('その他の商品');
    }

    #[Test]
    public function 購入済み商品は「sold」と表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => '購入済みの商品']);

        Mylist::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        Purchase::factory()->create(['item_id' => $item->id]);

        $response = $this->get(route('items.index', ['tab' => 'mylist']));

        $response->assertSee('Sold');
    }

    #[Test]
    public function 未認証の場合は何も表示されない()
    {
        $item = Item::factory()->create(['name' => '誰かの商品']);
        Mylist::factory()->create(['user_id' => 1, 'item_id' => $item->id]);

        $response = $this->get(route('items.index', ['tab' => 'mylist']));

        $response->assertDontSee('誰かの商品');
    }
}
